// Click-to-activate tabs. Activating a tab marks it .is-active (and aria-selected),
// then shows the matching [data-panel] within the same section and hides the rest.
// Panels are matched by slug: tab[data-tab="x"] -> [data-panel="x"]. No network.

const SELECTOR_ROOT = '[data-tabs]';
const SELECTOR_TAB = '[data-tab]';
const SELECTOR_PANEL = '[data-panel]';

function initTabsRoot(root) {
	const tabs = Array.from(root.querySelectorAll(SELECTOR_TAB));
	if (tabs.length === 0) return;

	// Panels live alongside the tablist inside the section, not within it.
	const scope = root.closest('section') || document;

	function activate(tab) {
		tabs.forEach((node) => {
			const isActive = node === tab;
			node.classList.toggle('is-active', isActive);
			node.setAttribute('aria-selected', isActive ? 'true' : 'false');
		});

		const slug = tab.getAttribute('data-tab');
		scope.querySelectorAll(SELECTOR_PANEL).forEach((panel) => {
			panel.hidden = panel.getAttribute('data-panel') !== slug;
		});
	}

	root.addEventListener('click', (event) => {
		const tab = event.target.closest(SELECTOR_TAB);
		if (!tab || !root.contains(tab)) return;
		activate(tab);
	});
}

export function initTabs(scope = document) {
	scope.querySelectorAll(SELECTOR_ROOT).forEach(initTabsRoot);
}
