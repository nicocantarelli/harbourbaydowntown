// Category filter dropdown (Dine / Shop). On tablet/mobile the tab row collapses
// into a pill dropdown (styled in src/scss/components/_category-filter.scss). The
// tab JS still handles panel switching; this only toggles the dropdown open/close
// and keeps the toggle's label in sync with the active tab. On desktop the toggle
// is hidden (CSS) so this is inert there.

function initCategoryFilter(root) {
	const toggle = root.querySelector('[data-category-filter-toggle]');
	const label = root.querySelector('[data-category-filter-label]');
	const menu = root.querySelector('.category-filter__menu');
	if (!toggle || !menu) return;

	const tabs = Array.from(menu.querySelectorAll('button'));

	const setOpen = (open) => {
		root.classList.toggle('is-open', open);
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
	};

	const syncLabel = () => {
		const active = menu.querySelector('.is-active') || tabs[0];
		if (active && label) label.textContent = active.textContent;
	};

	syncLabel();

	toggle.addEventListener('click', () => setOpen(!root.classList.contains('is-open')));

	// Selecting a category updates the label and closes the dropdown. Panel
	// switching (and the .is-active class on real tab rows) is handled by the tab
	// JS; for the static placeholder we set the active state here too.
	menu.addEventListener('click', (event) => {
		const tab = event.target.closest('button');
		if (!tab) return;
		tabs.forEach((node) => node.classList.toggle('is-active', node === tab));
		if (label) label.textContent = tab.textContent;
		setOpen(false);
	});

	// Close on outside click or Escape.
	document.addEventListener('click', (event) => {
		if (!root.contains(event.target)) setOpen(false);
	});
	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') setOpen(false);
	});
}

export function initCategoryFilters(scope = document) {
	scope.querySelectorAll('[data-category-filter]').forEach(initCategoryFilter);
}
