// Soft scroll parallax for the hero. As the hero scrolls away the three layers
// drift downward at different rates so they separate gently: the background lags
// most (reads as farthest), the heading sits in between, and the foreground
// image lags least (reads as closest).

const SELECTOR_HERO = '.home-hero';

// translateY = px-scrolled-past-the-hero-top × rate. Larger rate = more lag /
// stronger effect. Background must lag most, foreground least. Tune here.
const RATE_BACKGROUND = 0.3;
const RATE_TEXT = 0.18;
const RATE_FOREGROUND = 0.08;

function initHeroParallax(scope = document) {
	const hero = scope.querySelector(SELECTOR_HERO);
	if (!hero) return;

	const background = hero.querySelector('.home-hero__background');
	const heading = hero.querySelector('.home-hero__heading');
	const foreground = hero.querySelector('.home-hero__foreground');
	if (!background && !heading && !foreground) return;

	let ticking = false;

	function update() {
		ticking = false;
		// How far the hero top has scrolled above the viewport top (0 at rest).
		const scrolled = Math.max(0, -hero.getBoundingClientRect().top);

		if (background) {
			background.style.transform = `translate3d(0, ${scrolled * RATE_BACKGROUND}px, 0)`;
		}
		if (heading) {
			heading.style.transform = `translate3d(0, ${scrolled * RATE_TEXT}px, 0)`;
		}
		if (foreground) {
			foreground.style.transform = `translate3d(0, ${scrolled * RATE_FOREGROUND}px, 0)`;
		}
	}

	function onScroll() {
		if (ticking) return;
		ticking = true;
		requestAnimationFrame(update);
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	update(); // set the initial position (handles loads that start part-scrolled)
}

export { initHeroParallax };
