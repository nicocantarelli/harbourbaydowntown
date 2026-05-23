// Harbour Bay Downtown — enquiry forms.
// Submits the Contact / Advertising / Sales & Leasing / Live & Work forms via
// AJAX to admin-ajax.php and shows an inline success/error message. Config
// (ajaxUrl + nonce) is provided by wp_localize_script as window.hbdForms.

export function initContactForms() {
	const config = window.hbdForms;
	if (!config || !config.ajaxUrl) {
		return;
	}

	document
		.querySelectorAll('.lw-contact__form')
		.forEach((form) => bindForm(form, config));
}

function bindForm(form, config) {
	form.addEventListener('submit', async (event) => {
		event.preventDefault();

		// Let the browser surface native required-field messages first.
		if (typeof form.reportValidity === 'function' && !form.reportValidity()) {
			return;
		}

		const status = form.querySelector('.lw-contact__status');
		const button = form.querySelector('.lw-contact__submit');

		setStatus(status, '', null);
		setLoading(button, true);

		const data = new FormData(form);
		data.append('action', 'hbd_form_submit');
		data.append('nonce', config.nonce);
		data.append('form', form.dataset.hbdForm || 'contact');
		data.append('source_url', window.location.href);

		try {
			const response = await fetch(config.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				body: data,
			});
			const result = await response.json();

			if (result && result.success) {
				showSuccess(form, result);
			} else {
				setLoading(button, false);
				setStatus(status, messageOf(result, 'Something went wrong. Please try again.'), 'error');
			}
		} catch (error) {
			setLoading(button, false);
			setStatus(status, 'Something went wrong. Please check your connection and try again.', 'error');
		}
	});
}

// Hides the fields and shows a centered confirmation card in the form's place.
function showSuccess(form, result) {
	const data = (result && result.data) || {};
	form.classList.add('is-submitted');

	const panel = document.createElement('div');
	panel.className = 'lw-contact__success';
	panel.setAttribute('role', 'status');
	panel.setAttribute('aria-live', 'polite');
	panel.setAttribute('tabindex', '-1');

	const icon = document.createElement('span');
	icon.className = 'lw-contact__success-icon';
	icon.setAttribute('aria-hidden', 'true');
	icon.innerHTML =
		'<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none"><path d="M27 8L12 23L5 16" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';

	const title = document.createElement('h3');
	title.className = 'lw-contact__success-title';
	title.textContent = data.title || 'Message sent';

	const text = document.createElement('p');
	text.className = 'lw-contact__success-text';
	text.textContent =
		data.message ||
		'Thank you for reaching out — our team has received your message and will be in touch shortly.';

	panel.append(icon, title, text);
	form.appendChild(panel);
	panel.focus();
}

function messageOf(result, fallback) {
	return (result && result.data && result.data.message) || fallback;
}

function setLoading(button, loading) {
	if (!button) {
		return;
	}
	button.disabled = loading;
	button.classList.toggle('is-loading', loading);
}

function setStatus(node, message, type) {
	if (!node) {
		return;
	}
	node.textContent = message;
	node.classList.remove('lw-contact__status--success', 'lw-contact__status--error');
	if (type) {
		node.classList.add(`lw-contact__status--${type}`);
	}
	node.hidden = !message;
}
