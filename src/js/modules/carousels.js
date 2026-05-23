// Native-scroll carousel — finds [data-carousel] roots and wires prev/next buttons
// to scroll the track by one card-width-plus-gap. Optional progress bar sync.

const SELECTOR_ROOT = '[data-carousel]';
const SELECTOR_TRACK = '[data-carousel-track]';
const SELECTOR_PREV = '[data-carousel-prev]';
const SELECTOR_NEXT = '[data-carousel-next]';
const SELECTOR_PROGRESS = '[data-carousel-progress]';

function getStep(track) {
	const firstCard = track.firstElementChild;
	if (!firstCard) return 0;

	const cardWidth = firstCard.getBoundingClientRect().width;
	const trackStyle = window.getComputedStyle(track);
	const gap = parseFloat(trackStyle.columnGap || trackStyle.gap) || 0;

	return cardWidth + gap;
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

	const scrollBy = (direction) => {
		const step = getStep(track);
		if (step <= 0) return;

		track.scrollBy({ left: step * direction, behavior: 'smooth' });
	};

	prev?.addEventListener('click', () => scrollBy(-1));
	next?.addEventListener('click', () => scrollBy(1));

	if (progress) {
		track.addEventListener('scroll', () => syncProgress(track, progress), { passive: true });
		syncProgress(track, progress);

		if (typeof ResizeObserver !== 'undefined') {
			new ResizeObserver(() => syncProgress(track, progress)).observe(track);
		}
	}
}

export function initCarousels(scope = document) {
	scope.querySelectorAll(SELECTOR_ROOT).forEach(initCarousel);
}
