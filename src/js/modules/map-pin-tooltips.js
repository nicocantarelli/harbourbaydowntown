// Smart placement for the map-pin hover tooltips. On hover, measure the tooltip
// in its default position (above, centered) and flip it below and/or anchor it to
// the pin's left/right edge when it would overflow the viewport. CSS handles the
// actual repositioning via the modifier classes set here.

const SELECTOR_PIN = '.map-pin';
const SELECTOR_TOOLTIP = '.map-pin__tooltip';
const CLASS_BELOW = 'map-pin__tooltip--below';
const CLASS_LEFT = 'map-pin__tooltip--align-left';
const CLASS_RIGHT = 'map-pin__tooltip--align-right';
const MARGIN = 8; // px of breathing room from the viewport edges

function place(tooltip) {
	// Reset to the default position, then measure it.
	tooltip.classList.remove(CLASS_BELOW, CLASS_LEFT, CLASS_RIGHT);
	const rect = tooltip.getBoundingClientRect();
	const vw = window.innerWidth;

	if (rect.top < MARGIN) {
		tooltip.classList.add(CLASS_BELOW);
	}
	if (rect.left < MARGIN) {
		tooltip.classList.add(CLASS_LEFT);
	} else if (rect.right > vw - MARGIN) {
		tooltip.classList.add(CLASS_RIGHT);
	}
}

function initMapPinTooltips(scope = document) {
	scope.querySelectorAll(SELECTOR_PIN).forEach((pin) => {
		const tooltip = pin.querySelector(SELECTOR_TOOLTIP);
		if (!tooltip) return;
		pin.addEventListener('mouseenter', () => place(tooltip));
	});
}

export { initMapPinTooltips };
