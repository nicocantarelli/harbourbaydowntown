// Dropdown parent links (e.g. "Others") only reveal their submenu — they should
// never navigate. The submenu shows on hover and on focus-within (CSS), so a tap
// on touch devices still opens it via focus.
export function initNavDropdowns() {
	const parents = document.querySelectorAll('.hbd-menu__item--has-children > .hbd-menu__link');

	parents.forEach((link) => {
		link.addEventListener('click', (event) => {
			event.preventDefault();
		});
	});
}
