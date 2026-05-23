// Harbour Bay Downtown — frontend JS entry.
import { initCarousels } from './modules/carousels.js';
import { initTabs } from './modules/tabs.js';
import { initHeroParallax } from './modules/hero-parallax.js';
import { initStickyNav } from './modules/sticky-nav.js';
import { initFaqWidget } from './modules/faq-widget.js';
import { initMapPinTooltips } from './modules/map-pin-tooltips.js';
import { initNavDropdowns } from './modules/nav-dropdown.js';
import { initCountUp } from './modules/count-up.js';
import { initContactForms } from './modules/contact-forms.js';

function init() {
	initCarousels();
	initTabs();
	initHeroParallax();
	initStickyNav();
	initFaqWidget();
	initMapPinTooltips();
	initNavDropdowns();
	initCountUp();
	initContactForms();
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
