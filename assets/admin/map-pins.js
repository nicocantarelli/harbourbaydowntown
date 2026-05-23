(function ($) {
	'use strict';

	const $form = $('#hbd-pins-form');
	if (!$form.length) return;

	const $layer    = $form.find('.hbd-pins-layer');
	const $canvas   = $form.find('.hbd-pins-canvas');
	const $dataIn   = $form.find('#hbd-pins-data');
	const $form2    = $form.find('.hbd-pin-form');
	const $labelIn  = $form2.find('.hbd-pin-label');
	const $titleIn  = $form2.find('.hbd-pin-title');
	const $catIn    = $form2.find('.hbd-pin-category');
	const $descIn   = $form2.find('.hbd-pin-description');
	const $linkIn   = $form2.find('.hbd-pin-link');
	const $imgPrev  = $form2.find('.hbd-pin-image-preview');
	const $imgClear = $form2.find('.hbd-pin-image-clear');
	const $xIn      = $form2.find('.hbd-pin-x');
	const $yIn      = $form2.find('.hbd-pin-y');
	const $presets  = $form2.find('.hbd-pin-presets');
	const pinSvg    = (window.HBDMapPins && window.HBDMapPins.pinSvg) || '';
	const presets   = (window.HBDMapPins && window.HBDMapPins.presets) || {};

	let pins = [];
	let iconUrls = {};
	let imageUrls = {};
	let selected = null;

	try { pins = JSON.parse($dataIn.val()) || []; } catch (e) { pins = []; }
	try {
		iconUrls = JSON.parse(document.getElementById('hbd-pins-icon-urls').textContent) || {};
	} catch (e) { iconUrls = {}; }
	try {
		imageUrls = JSON.parse(document.getElementById('hbd-pins-image-urls').textContent) || {};
	} catch (e) { imageUrls = {}; }

	// Build preset picker buttons once.
	Object.entries(presets).forEach(([key, preset]) => {
		const $btn = $('<button type="button" class="hbd-preset-btn"></button>')
			.attr('data-preset', key)
			.attr('title', preset.label)
			.css({
				width: '100%',
				aspectRatio: '1',
				background: '#151515',
				border: '2px solid transparent',
				borderRadius: '6px',
				padding: '0',
				cursor: 'pointer',
				display: 'flex',
				alignItems: 'center',
				justifyContent: 'center',
			})
			.append(
				$('<img>').attr('src', preset.url).css({
					width: '60%',
					height: '60%',
					objectFit: 'contain',
					pointerEvents: 'none',
				})
			);
		$presets.append($btn);
	});

	// Returns the URL of the icon to display inside a pin (preset OR uploaded).
	function iconUrlFor(pin) {
		if (pin.icon_id && iconUrls[pin.icon_id]) return { url: iconUrls[pin.icon_id], isPreset: false };
		if (pin.icon_preset && presets[pin.icon_preset]) return { url: presets[pin.icon_preset].url, isPreset: true };
		return null;
	}

	function renderAll() {
		$layer.empty();
		pins.forEach((pin, i) => {
			const $pin = $('<button type="button" class="hbd-pin"></button>')
				.css({
					position: 'absolute',
					left: pin.x + '%',
					top: pin.y + '%',
					width: '53px',
					height: '61px',
					transform: 'translate(-50%, -92.21%)',
					background: 'transparent',
					border: '0',
					padding: '0',
					cursor: 'grab',
					zIndex: selected === i ? 10 : 1,
				})
				.attr('data-index', i)
				.attr('title', pin.label || 'Pin ' + (i + 1));

			$pin.append(
				$('<img>').attr('src', pinSvg).css({
					width: '100%', height: '100%', display: 'block', pointerEvents: 'none',
				})
			);

			const ic = iconUrlFor(pin);
			if (ic) {
				$pin.append(
					$('<img>').attr('src', ic.url).css({
						position: 'absolute',
						top: '39%',
						left: '50%',
						margin: '-11px 0 0 -11px',
						width: '22px',
						height: '22px',
						objectFit: 'contain',
						filter: ic.isPreset ? 'none' : 'brightness(0) invert(1)',
						pointerEvents: 'none',
					})
				);
			}

			if (selected === i) {
				$pin.css({ outline: '2px solid #2271b1', outlineOffset: '2px' });
			}

			$layer.append($pin);
		});
		commit();
	}

	function commit() {
		$dataIn.val(JSON.stringify(pins));
	}

	function syncPresetButtons() {
		const current = selected !== null && pins[selected] ? pins[selected].icon_preset : '';
		$presets.find('.hbd-preset-btn').each(function () {
			$(this).css('borderColor', $(this).attr('data-preset') === current ? '#2271b1' : 'transparent');
		});
	}

	function renderImagePreview(pin) {
		const id = pin && pin.image_id ? pin.image_id : 0;
		const url = id && imageUrls[id] ? imageUrls[id] : '';
		if (url) {
			$imgPrev.html('<img src="' + url + '" style="max-width:100%;height:auto;border-radius:4px;display:block;" />');
			$imgClear.show();
		} else {
			$imgPrev.empty();
			$imgClear.hide();
		}
	}

	function select(i) {
		selected = i;
		if (i === null || !pins[i]) {
			$form2.hide();
		} else {
			const pin = pins[i];
			$labelIn.val(pin.label || '');
			$titleIn.val(pin.title || '');
			$catIn.val(pin.category || '');
			$descIn.val(pin.description || '');
			$linkIn.val(pin.link || '');
			renderImagePreview(pin);
			$xIn.val(pin.x.toFixed(1));
			$yIn.val(pin.y.toFixed(1));
			syncPresetButtons();
			$form2.find('.hbd-pin-icon-clear').toggle(!!(pin.icon_id || pin.icon_preset));
			$form2.show();
		}
		renderAll();
	}

	// -------------------------------------------------------------------------
	// Drag — uses an offset from cursor → pin tip captured on mousedown so
	// the pin doesn't snap-jump under the cursor; it follows naturally.
	// -------------------------------------------------------------------------
	$layer.on('mousedown', '.hbd-pin', function (e) {
		e.preventDefault();
		const i = parseInt($(this).attr('data-index'), 10);
		select(i);

		const rect = $canvas[0].getBoundingClientRect();
		const tipX = (pins[i].x / 100) * rect.width;
		const tipY = (pins[i].y / 100) * rect.height;
		const offX = (e.clientX - rect.left) - tipX;
		const offY = (e.clientY - rect.top) - tipY;

		const onMove = (ev) => {
			const r = $canvas[0].getBoundingClientRect();
			const x = ((ev.clientX - r.left - offX) / r.width) * 100;
			const y = ((ev.clientY - r.top - offY) / r.height) * 100;
			pins[i].x = Math.max(0, Math.min(100, x));
			pins[i].y = Math.max(0, Math.min(100, y));
			renderAll();
			$xIn.val(pins[i].x.toFixed(1));
			$yIn.val(pins[i].y.toFixed(1));
		};
		const onUp = () => {
			document.removeEventListener('mousemove', onMove);
			document.removeEventListener('mouseup', onUp);
		};
		document.addEventListener('mousemove', onMove);
		document.addEventListener('mouseup', onUp);
	});

	// Sidebar inputs.
	$labelIn.on('input', function () {
		if (selected === null) return;
		pins[selected].label = $(this).val();
		commit();
	});
	$titleIn.on('input', function () {
		if (selected === null) return;
		pins[selected].title = $(this).val();
		commit();
	});
	$catIn.on('input', function () {
		if (selected === null) return;
		pins[selected].category = $(this).val();
		commit();
	});
	$descIn.on('input', function () {
		if (selected === null) return;
		pins[selected].description = $(this).val();
		commit();
	});
	$linkIn.on('input', function () {
		if (selected === null) return;
		pins[selected].link = $(this).val();
		commit();
	});

	// Tooltip image — sets image_id.
	$form2.find('.hbd-pin-image-choose').on('click', function (e) {
		e.preventDefault();
		if (selected === null) return;
		const frame = wp.media({
			title: 'Choose tooltip image',
			button: { text: 'Use image' },
			multiple: false,
			library: { type: 'image' },
		});
		frame.on('select', function () {
			const att = frame.state().get('selection').first().toJSON();
			pins[selected].image_id = att.id;
			imageUrls[att.id] = (att.sizes && att.sizes.medium) ? att.sizes.medium.url : att.url;
			renderImagePreview(pins[selected]);
			commit();
		});
		frame.open();
	});
	$imgClear.on('click', function (e) {
		e.preventDefault();
		if (selected === null) return;
		pins[selected].image_id = 0;
		renderImagePreview(pins[selected]);
		commit();
	});
	$xIn.on('input', function () {
		if (selected === null) return;
		pins[selected].x = Math.max(0, Math.min(100, parseFloat($(this).val()) || 0));
		renderAll();
	});
	$yIn.on('input', function () {
		if (selected === null) return;
		pins[selected].y = Math.max(0, Math.min(100, parseFloat($(this).val()) || 0));
		renderAll();
	});

	// Preset picker — click a preset → set icon_preset, clear icon_id.
	$presets.on('click', '.hbd-preset-btn', function (e) {
		e.preventDefault();
		if (selected === null) return;
		const key = $(this).attr('data-preset');
		// Toggle: clicking the active preset clears it.
		if (pins[selected].icon_preset === key) {
			pins[selected].icon_preset = '';
		} else {
			pins[selected].icon_preset = key;
			pins[selected].icon_id = 0;
		}
		syncPresetButtons();
		$form2.find('.hbd-pin-icon-clear').toggle(!!(pins[selected].icon_id || pins[selected].icon_preset));
		renderAll();
	});

	// Custom upload — sets icon_id, clears preset.
	$form2.find('.hbd-pin-icon-choose').on('click', function (e) {
		e.preventDefault();
		if (selected === null) return;
		const frame = wp.media({
			title: 'Choose pin icon',
			button: { text: 'Use icon' },
			multiple: false,
			library: { type: 'image' },
		});
		frame.on('select', function () {
			const att = frame.state().get('selection').first().toJSON();
			pins[selected].icon_id = att.id;
			pins[selected].icon_preset = '';
			iconUrls[att.id] = att.url;
			syncPresetButtons();
			$form2.find('.hbd-pin-icon-clear').show();
			renderAll();
		});
		frame.open();
	});

	$form2.find('.hbd-pin-icon-clear').on('click', function (e) {
		e.preventDefault();
		if (selected === null) return;
		pins[selected].icon_id = 0;
		pins[selected].icon_preset = '';
		syncPresetButtons();
		$(this).hide();
		renderAll();
	});

	$form2.find('.hbd-pin-remove').on('click', function (e) {
		e.preventDefault();
		if (selected === null) return;
		pins.splice(selected, 1);
		select(null);
	});

	$('.hbd-pin-add').on('click', function (e) {
		e.preventDefault();
		pins.push({ x: 50, y: 50, icon_id: 0, icon_preset: '', label: '', title: '', category: '', description: '', link: '', image_id: 0 });
		select(pins.length - 1);
	});

	renderAll();
})(jQuery);
