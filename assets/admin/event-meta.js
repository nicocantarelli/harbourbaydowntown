/* global jQuery, wp */
/**
 * Event editor — file picker for the "link a file" field. Stores the chosen
 * attachment ID in `.hbd-file-id` and shows the filename.
 */
(function ($) {
	'use strict';

	$(document).on('click', '.hbd-file-choose', function (e) {
		e.preventDefault();
		const $field = $(this).closest('.hbd-file-field');

		const frame = wp.media({
			title: 'Select file',
			button: { text: 'Use this file' },
			multiple: false,
		});

		frame.on('select', function () {
			const file = frame.state().get('selection').first().toJSON();
			$field.find('.hbd-file-id').val(file.id);
			$field.find('.hbd-file-name').text(file.filename || file.url);
			$field.find('.hbd-file-clear').show();
		});

		frame.open();
	});

	$(document).on('click', '.hbd-file-clear', function (e) {
		e.preventDefault();
		const $field = $(this).closest('.hbd-file-field');
		$field.find('.hbd-file-id').val('0');
		$field.find('.hbd-file-name').text('No file selected');
		$(this).hide();
	});
})(jQuery);
