// Mobile navigation drawer. A hamburger toggle (in the header and the sticky
// nav) opens a slide-in panel that reuses the header menu. Handles open/close,
// body-scroll lock, focus trap, Esc, submenu accordions, and auto-close when the
// viewport grows back to desktop. Styled in src/scss/components/_mobile-nav.scss.

const DESKTOP_MIN = 1024; // matches $breakpoints.desktop — drawer is for < this

export function initMobileNav() {
	const drawer = document.querySelector('[data-mobile-nav]');
	if (!drawer) return;

	const panel = drawer.querySelector('.mobile-nav__panel');
	const toggles = document.querySelectorAll('[data-mobile-nav-toggle]');
	const closers = drawer.querySelectorAll('[data-mobile-nav-close]');
	if (!panel || !toggles.length) return;

	let lastFocused = null;

	const isOpen = () => drawer.classList.contains('is-open');

	const getFocusable = () =>
		Array.from(panel.querySelectorAll('a[href], button:not([disabled])')).filter(
			(el) => el.offsetParent !== null
		);

	function open(trigger) {
		if (isOpen()) return;
		lastFocused = trigger || document.activeElement;
		drawer.hidden = false;
		void drawer.offsetWidth; // reflow so the slide-in transition runs
		drawer.classList.add('is-open');
		document.body.classList.add('mobile-nav-open');
		toggles.forEach((t) => t.setAttribute('aria-expanded', 'true'));
		(getFocusable()[0] || panel).focus();
		document.addEventListener('keydown', onKeydown);
	}

	function close() {
		if (!isOpen()) return;
		drawer.classList.remove('is-open');
		document.body.classList.remove('mobile-nav-open');
		toggles.forEach((t) => t.setAttribute('aria-expanded', 'false'));
		document.removeEventListener('keydown', onKeydown);

		// Hide from the a11y tree only after the slide-out finishes.
		const hide = () => {
			if (!isOpen()) drawer.hidden = true;
			panel.removeEventListener('transitionend', hide);
		};
		panel.addEventListener('transitionend', hide);

		if (lastFocused && typeof lastFocused.focus === 'function') {
			lastFocused.focus();
		}
	}

	function onKeydown(event) {
		if (event.key === 'Escape') {
			close();
			return;
		}
		if (event.key !== 'Tab') return;

		const focusable = getFocusable();
		if (!focusable.length) return;
		const first = focusable[0];
		const last = focusable[focusable.length - 1];

		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	}

	toggles.forEach((toggle) => {
		toggle.addEventListener('click', () => (isOpen() ? close() : open(toggle)));
	});

	closers.forEach((closer) => closer.addEventListener('click', close));

	// Tapping a submenu parent expands the accordion; tapping a real link closes
	// the drawer (it's about to navigate).
	panel.addEventListener('click', (event) => {
		const link = event.target.closest('.hbd-menu__link');
		if (!link) return;

		const item = link.parentElement;
		if (item && item.classList.contains('hbd-menu__item--has-children')) {
			event.preventDefault();
			const expanded = item.classList.toggle('is-expanded');
			link.setAttribute('aria-expanded', expanded ? 'true' : 'false');
			return;
		}

		close();
	});

	// Flag parent links as accordion controls for assistive tech.
	panel
		.querySelectorAll('.hbd-menu__item--has-children > .hbd-menu__link')
		.forEach((link) => link.setAttribute('aria-expanded', 'false'));

	// If the viewport grows back to desktop, the drawer is irrelevant — close it.
	let resizeScheduled = false;
	window.addEventListener(
		'resize',
		() => {
			if (resizeScheduled) return;
			resizeScheduled = true;
			requestAnimationFrame(() => {
				resizeScheduled = false;
				if (window.innerWidth >= DESKTOP_MIN && isOpen()) close();
			});
		},
		{ passive: true }
	);
}
