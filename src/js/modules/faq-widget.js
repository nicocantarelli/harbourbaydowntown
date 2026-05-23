// Floating FAQ / chat widget. The FAB toggles the panel; each FAQ row toggles
// its answer. Closes on outside-click and Escape. Styles in
// src/scss/components/_faq-widget.scss.

const SELECTOR_WIDGET = '[data-faq-widget]';

function initFaqWidget(scope = document) {
	const widget = scope.querySelector(SELECTOR_WIDGET);
	if (!widget) return;

	const toggle = widget.querySelector('[data-faq-toggle]');
	const panel = widget.querySelector('[data-faq-panel]');
	if (!toggle || !panel) return;

	// Hand visibility to CSS (.is-open) so the panel can animate open/closed.
	panel.hidden = false;

	function setOpen(open) {
		widget.classList.toggle('is-open', open);
		toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
	}

	toggle.addEventListener('click', (event) => {
		event.stopPropagation();
		setOpen(!widget.classList.contains('is-open'));
	});

	// FAQ accordion — single-open: opening one closes the others.
	const triggers = Array.from(widget.querySelectorAll('[data-faq-trigger]'));

	function setItemOpen(trigger, open) {
		trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
		const item = trigger.closest('[data-faq-item]');
		const answer = item ? item.querySelector('[data-faq-answer]') : null;
		if (answer) answer.hidden = !open;
	}

	triggers.forEach((trigger) => {
		trigger.addEventListener('click', () => {
			const willOpen = trigger.getAttribute('aria-expanded') !== 'true';
			triggers.forEach((other) => setItemOpen(other, other === trigger && willOpen));
		});
	});

	document.addEventListener('click', (event) => {
		if (widget.classList.contains('is-open') && !widget.contains(event.target)) {
			setOpen(false);
		}
	});

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && widget.classList.contains('is-open')) {
			setOpen(false);
			toggle.focus();
		}
	});
}

export { initFaqWidget };
