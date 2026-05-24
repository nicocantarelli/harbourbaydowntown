// Native-scroll carousel — finds [data-carousel] roots and wires prev/next buttons
// to scroll the track by one card-width-plus-gap. Optional progress bar sync.

const SELECTOR_ROOT = '[data-carousel]';
const SELECTOR_TRACK = '[data-carousel-track]';
const SELECTOR_PREV = '[data-carousel-prev]';
const SELECTOR_NEXT = '[data-carousel-next]';
const SELECTOR_PROGRESS = '[data-carousel-progress]';
const SELECTOR_CONTROLS = '.carousel__controls';

function getStep(track) {
	// Measure the first actual card — not firstElementChild — because WordPress's
	// block-layout support can inject a zero-width <style> element as the first
	// child, which would make the step ~0 and the arrows appear dead.
	const card = track.querySelector('.card') || track.firstElementChild;
	const cardWidth = card ? card.getBoundingClientRect().width : 0;
	const trackStyle = window.getComputedStyle(track);
	const gap = parseFloat(trackStyle.columnGap || trackStyle.gap) || 0;

	const step = cardWidth + gap;
	// Fallback: if no card can be measured (e.g. a hidden tab panel), advance by
	// most of the visible track width so a click still moves the carousel.
	return step > 1 ? step : Math.max(track.clientWidth * 0.8, 1);
}

function syncProgress(track, progressEl) {
	if (!progressEl) return;

	const scrollable = track.scrollWidth - track.clientWidth;
	if (scrollable <= 0) {
		progressEl.style.width = '100%';
		return;
	}

	const ratio = track.scrollLeft / scrollable;
	const minWidth = 25;
	const maxWidth = 100;
	progressEl.style.width = `${minWidth + (maxWidth - minWidth) * ratio}%`;
}

function initCarousel(root) {
	const track = root.querySelector(SELECTOR_TRACK);
	if (!track) return;

	const prev = root.querySelector(SELECTOR_PREV);
	const next = root.querySelector(SELECTOR_NEXT);
	const progress = root.querySelector(SELECTOR_PROGRESS);
	const controls = root.querySelector(SELECTOR_CONTROLS);

	const scrollBy = (direction) => {
		const step = getStep(track);
		if (step <= 0) return;

		track.scrollBy({ left: step * direction, behavior: 'smooth' });
	};

	prev?.addEventListener('click', () => scrollBy(-1));
	next?.addEventListener('click', () => scrollBy(1));

	// Hide the controls when the track has nothing to scroll (e.g. only a couple
	// of cards that already fit), and bring them back if a resize makes the cards
	// overflow. Avoids dead-looking arrows on short carousels.
	const refresh = () => {
		if (controls) {
			const scrollable = track.scrollWidth - track.clientWidth > 1;
			controls.style.display = scrollable ? '' : 'none';
		}
		syncProgress(track, progress);
	};

	if (progress) {
		track.addEventListener('scroll', () => syncProgress(track, progress), { passive: true });
	}

	refresh();

	if (typeof ResizeObserver !== 'undefined') {
		new ResizeObserver(refresh).observe(track);
	} else {
		window.addEventListener('resize', refresh, { passive: true });
	}
}

export function initCarousels(scope = document) {
	scope.querySelectorAll(SELECTOR_ROOT).forEach(initCarousel);
}
