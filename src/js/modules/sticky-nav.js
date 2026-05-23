// Smart sticky navbar. Hidden while the threshold element (the hero on hero pages,
// or the solid header on other pages) is in view; once it has scrolled past, the
// pill slides in when scrolling UP and hides when scrolling DOWN. Toggles
// `.is-visible` (styled in src/scss/sections/_site-header.scss).

const SELECTOR_NAV = '[data-sticky-nav]';
// First match in document order wins: on hero pages the overlay header is skipped
// by :not(--overlay) so the hero is used; on solid-header pages the header is used.
const SELECTOR_HERO = '.site-header:not(.site-header--overlay), .home-hero, .page-hero';
const DELTA = 5; // px of movement required before reacting (ignores jitter)

function initStickyNav(scope = document) {
	const nav = scope.querySelector(SELECTOR_NAV);
	if (!nav) return;

	const hero = scope.querySelector(SELECTOR_HERO);
	let lastY = window.scrollY;
	let ticking = false;

	function setVisible(visible) {
		nav.classList.toggle('is-visible', visible);
		nav.setAttribute('aria-hidden', visible ? 'false' : 'true');
	}

	function update() {
		ticking = false;
		const y = Math.max(0, window.scrollY);

		// "Past the hero" = the hero's bottom edge has scrolled above the viewport.
		// (No hero, e.g. other templates: treat any scroll as past.)
		const pastHero = hero ? hero.getBoundingClientRect().bottom <= 0 : y > 0;

		if (!pastHero) {
			setVisible(false);
			lastY = y;
			return;
		}

		const delta = y - lastY;
		if (Math.abs(delta) > DELTA) {
			setVisible(delta < 0); // scrolling up → reveal; down → hide
			lastY = y;
		}
	}

	function onScroll() {
		if (ticking) return;
		ticking = true;
		requestAnimationFrame(update);
	}

	window.addEventListener('scroll', onScroll, { passive: true });
	update();
}

export { initStickyNav };
