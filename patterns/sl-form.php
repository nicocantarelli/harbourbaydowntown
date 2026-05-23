<?php
/**
 * Title: Sales & Leasing — Enquiry Form
 * Slug: harbour-bay-downtown/sl-form
 * Categories: harbour-bay-downtown
 * Description: A title + intro on the left and an enquiry form on the right (reuses the Contact / Live & Work form styles). The form submits via AJAX (see inc/forms.php) and emails the Sales & Leasing inbox. Title/intro editable via Customizer → Sales & Leasing Page → Sales & Leasing — Enquiry Form.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_sl_form_title', 'Sales & Leasing' ) ) );
$body_raw = get_theme_mod( 'hbd_sl_form_body', 'Own or lease space in Batam’s most connected waterfront district. Whether you are looking to open a business, invest, or secure a home, this is one of the few locations in Batam where everything works together.' );
$paras    = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', $body_raw ) ), 'strlen' );
?>
<!-- wp:group {"tagName":"section","className":"lw-contact contact-message sl-form","layout":{"type":"default"}} -->
<section class="wp-block-group lw-contact contact-message sl-form">
	<!-- wp:html -->
	<div class="lw-contact__intro">
		<h2 class="lw-contact__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<div class="lw-contact__body">
			<?php foreach ( $paras as $para ) : ?>
			<p><?php echo esc_html( $para ); ?></p>
			<?php endforeach; ?>
		</div>
	</div>

	<form class="lw-contact__form" data-hbd-form="sales-leasing" novalidate>
		<p class="hbd-hp" aria-hidden="true"><label>Leave this field empty<input type="text" name="hbd_hp" tabindex="-1" autocomplete="off" /></label></p>
		<div class="lw-contact__col">
			<label class="lw-field">
				<span class="lw-field__label">Name*</span>
				<input class="lw-field__input" type="text" name="name" placeholder="Your full name" required />
			</label>
			<label class="lw-field">
				<span class="lw-field__label">Company Name</span>
				<input class="lw-field__input" type="text" name="company" placeholder="Your company name" />
			</label>
			<label class="lw-field">
				<span class="lw-field__label">Email*</span>
				<input class="lw-field__input" type="email" name="email" placeholder="you@example.com" required />
			</label>
			<label class="lw-field">
				<span class="lw-field__label">Contact Number</span>
				<input class="lw-field__input" type="tel" name="phone" placeholder="+62 811 1234 567" />
			</label>
		</div>

		<div class="lw-contact__col">
			<label class="lw-field">
				<span class="lw-field__label">Interested In*</span>
				<select class="lw-field__input lw-field__input--select" name="enquiry_type" required>
					<option value="" disabled selected>Select...</option>
					<option>Retail &amp; F&amp;B space</option>
					<option>Office space</option>
					<option>Residential unit</option>
					<option>Investment</option>
					<option>Other</option>
				</select>
			</label>
			<label class="lw-field lw-field--grow">
				<span class="lw-field__label">Message*</span>
				<textarea class="lw-field__input lw-field__textarea" name="message" placeholder="Tell us more about your enquiry" required></textarea>
			</label>
			<button type="submit" class="lw-contact__submit">
				Submit
				<span class="lw-contact__submit-icon" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none"><path d="M18.3327 5.5L8.24935 15.5833L3.66602 11" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
			</button>
		</div>
		<p class="lw-contact__status" role="status" aria-live="polite" hidden></p>
	</form>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
