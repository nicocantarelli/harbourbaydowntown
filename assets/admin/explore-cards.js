/* global jQuery, wp */
/**
 * Explore Cards admin — repeater with image picker and drag-reorder.
 * State lives in a single hidden input as JSON.
 */
(function ($) {
	'use strict';

	const $form = $('#hbd-explore-form');
	if (!$form.length) {
		return;
	}

	const $list = $form.find('.hbd-explore-list');
	const $data = $form.find('#hbd-explore-data');

	let cards = [];
	try {
		cards = JSON.parse($data.val() || '[]');
	} catch (e) {
		cards = [];
	}

	const blankCard = () => ({
		title: '',
		description: '',
		image_id: 0,
		image_file: '',
		image_url: '',
		link_text: 'Explore',
		link_url: '',
	});

	const render = () => {
		$list.empty();
		cards.forEach((card, idx) => {
			const $row = $(buildRow(card, idx));
			$list.append($row);
		});
		serialize();
	};

	const buildRow = (card, idx) => {
		const safeUrl = card.image_url || '';
		const thumb = safeUrl
			? `<img src="${escapeAttr(safeUrl)}" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />`
			: `<span style="color:#646970;font-size:12px;">No image</span>`;

		return `
			<div class="hbd-explore-card" data-idx="${idx}" style="display:flex;gap:16px;padding:16px;background:#fff;border:1px solid #c3c4c7;border-radius:6px;align-items:flex-start;">
				<div class="hbd-explore-handle" title="Drag to reorder" style="cursor:grab;color:#8c8f94;font-size:18px;line-height:1;padding-top:6px;">⋮⋮</div>

				<div class="hbd-explore-thumb" style="width:120px;height:120px;border-radius:6px;overflow:hidden;background:#f0f0f1;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
					${thumb}
				</div>

				<div style="flex:1;display:grid;grid-template-columns:1fr 1fr;gap:12px;">
					<label style="grid-column:1 / -1;">
						<span style="display:block;font-weight:600;margin-bottom:4px;">Title</span>
						<input type="text" class="hbd-explore-title regular-text" value="${escapeAttr(card.title)}" style="width:100%;" />
					</label>

					<label style="grid-column:1 / -1;">
						<span style="display:block;font-weight:600;margin-bottom:4px;">Description</span>
						<textarea class="hbd-explore-description" rows="3" style="width:100%;">${escapeText(card.description)}</textarea>
					</label>

					<label>
						<span style="display:block;font-weight:600;margin-bottom:4px;">Link text</span>
						<input type="text" class="hbd-explore-link-text" value="${escapeAttr(card.link_text)}" style="width:100%;" />
					</label>

					<label>
						<span style="display:block;font-weight:600;margin-bottom:4px;">Link URL</span>
						<input type="text" class="hbd-explore-link-url" value="${escapeAttr(card.link_url)}" style="width:100%;" placeholder="https://…" />
					</label>

					<div style="grid-column:1 / -1;display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
						<button type="button" class="button hbd-explore-image-choose">Choose image…</button>
						<button type="button" class="button hbd-explore-image-clear" ${card.image_id ? '' : 'style="display:none;"'}>Clear image</button>
						<button type="button" class="button button-link-delete hbd-explore-remove" style="margin-left:auto;">Remove card</button>
					</div>
				</div>
			</div>
		`;
	};

	const escapeAttr = (str) => String(str == null ? '' : str)
		.replace(/&/g, '&amp;')
		.replace(/"/g, '&quot;')
		.replace(/</g, '&lt;');

	const escapeText = (str) => String(str == null ? '' : str)
		.replace(/&/g, '&amp;')
		.replace(/</g, '&lt;');

	const serialize = () => {
		$data.val(JSON.stringify(cards));
	};

	// Bind input events (delegated, so they survive re-renders).
	$list.on('input', '.hbd-explore-title', function () {
		const idx = $(this).closest('.hbd-explore-card').data('idx');
		cards[idx].title = $(this).val();
		serialize();
	});

	$list.on('input', '.hbd-explore-description', function () {
		const idx = $(this).closest('.hbd-explore-card').data('idx');
		cards[idx].description = $(this).val();
		serialize();
	});

	$list.on('input', '.hbd-explore-link-text', function () {
		const idx = $(this).closest('.hbd-explore-card').data('idx');
		cards[idx].link_text = $(this).val();
		serialize();
	});

	$list.on('input', '.hbd-explore-link-url', function () {
		const idx = $(this).closest('.hbd-explore-card').data('idx');
		cards[idx].link_url = $(this).val();
		serialize();
	});

	$list.on('click', '.hbd-explore-image-choose', function () {
		const $row = $(this).closest('.hbd-explore-card');
		const idx = $row.data('idx');

		const frame = wp.media({
			title: 'Select card image',
			button: { text: 'Use this image' },
			library: { type: 'image' },
			multiple: false,
		});

		frame.on('select', function () {
			const attachment = frame.state().get('selection').first().toJSON();
			cards[idx].image_id = attachment.id;
			cards[idx].image_file = '';
			cards[idx].image_url = attachment.sizes && attachment.sizes.large
				? attachment.sizes.large.url
				: attachment.url;
			render();
		});

		frame.open();
	});

	$list.on('click', '.hbd-explore-image-clear', function () {
		const idx = $(this).closest('.hbd-explore-card').data('idx');
		cards[idx].image_id = 0;
		cards[idx].image_file = '';
		cards[idx].image_url = '';
		render();
	});

	$list.on('click', '.hbd-explore-remove', function () {
		const idx = $(this).closest('.hbd-explore-card').data('idx');
		if (!window.confirm('Remove this card?')) {
			return;
		}
		cards.splice(idx, 1);
		render();
	});

	$form.on('click', '.hbd-explore-add', function () {
		cards.push(blankCard());
		render();
	});

	// Sortable for drag-reorder.
	$list.sortable({
		handle: '.hbd-explore-handle',
		axis: 'y',
		opacity: 0.85,
		update: function () {
			const newOrder = [];
			$list.find('.hbd-explore-card').each(function () {
				newOrder.push(cards[$(this).data('idx')]);
			});
			cards = newOrder;
			render();
		},
	});

	render();
})(jQuery);
