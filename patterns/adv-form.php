<?php
/**
 * Title: Advertising — Advertise at Harbour Bay Downtown
 * Slug: harbour-bay-downtown/adv-form
 * Categories: harbour-bay-downtown
 * Description: A title + intro on the left and a contact form on the right (reuses the Live & Work / Contact enquiry-form styles). The form submits via AJAX (see inc/forms.php) and emails the Advertising inbox (Media & Partnerships routes to the media team). Title/intro editable via Customizer → Advertising Page → Advertising — Enquiry Form.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_adv_form_title', "Advertise at\nHarbour Bay\nDowntown" ) ) );
$body  = get_theme_mod( 'hbd_adv_form_body', 'Be seen by millions of travelers right at arrival.' );
?>
<!-- wp:group {"tagName":"section","className":"lw-contact contact-message adv-form","layout":{"type":"default"}} -->
<section class="wp-block-group lw-contact contact-message adv-form">
	<!-- wp:html -->
	<div class="lw-contact__intro">
		<h2 class="lw-contact__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<p class="lw-contact__body"><?php echo esc_html( $body ); ?></p>
	</div>

	<form class="lw-contact__form" data-hbd-form="advertising" novalidate>
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
				<span class="lw-field__label">Enquiry Type*</span>
				<select class="lw-field__input lw-field__input--select" name="enquiry_type" required>
					<option value="" disabled selected>Select...</option>
					<option>Advertising</option>
					<option>Media &amp; Partnerships</option>
					<option>Sponsorship</option>
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
