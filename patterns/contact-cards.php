<?php
/**
 * Title: Contact — Contact Us
 * Slug: harbour-bay-downtown/contact-cards
 * Categories: harbour-bay-downtown
 * Description: A centered "Contact Us" title above a row of two info cards (General Enquiries, Media & Partnerships) and a short "Stay In Touch" intro. Editable via Customizer → Contact Page → Contact — Contact Us.
 * Inserter: no
 * Viewport Width: 1440
 */

$title      = nl2br( esc_html( get_theme_mod( 'hbd_contact_title', 'Contact Us' ) ) );
$intro_tag  = get_theme_mod( 'hbd_contact_intro_tag', 'Stay In Touch' );
$intro_body = get_theme_mod( 'hbd_contact_intro_body', "Whether you're planning a visit, exploring business opportunities, or looking for more information, our team is here to help." );

$gen_title = get_theme_mod( 'hbd_contact_gen_title', 'General Enquiries' );
$gen_desc  = get_theme_mod( 'hbd_contact_gen_desc', 'For questions about Harbour Bay Downtown, facilities, directions, or visitor information:' );
$gen_email = get_theme_mod( 'hbd_contact_gen_email', 'info@harbourbaydowntown.com' );
$gen_phone = get_theme_mod( 'hbd_contact_gen_phone', '[number]' );
$gen_note  = get_theme_mod( 'hbd_contact_gen_note', 'We aim to respond within 1–2 working days.' );

$media_title = get_theme_mod( 'hbd_contact_media_title', 'Media & Partnerships' );
$media_desc  = get_theme_mod( 'hbd_contact_media_desc', 'For media enquiries, collaborations, or partnership opportunities:' );
$media_email = get_theme_mod( 'hbd_contact_media_email', '[media email]' );
$media_note  = get_theme_mod( 'hbd_contact_media_note', 'Kindly include your organisation name and a brief outline of your request.' );

$icon_mail  = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';
$icon_phone = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M13.832 16.568a1 1 0 0 0 1.213-.303l.355-.465A2 2 0 0 1 17 15h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2A18 18 0 0 1 2 4a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-.8 1.6l-.468.351a1 1 0 0 0-.292 1.233 14 14 0 0 0 6.392 6.384"/></svg>';
?>
<!-- wp:group {"tagName":"section","className":"contact-cards","layout":{"type":"default"}} -->
<section class="wp-block-group contact-cards">
	<!-- wp:heading {"level":1,"className":"contact-cards__title","textAlign":"center"} -->
	<h1 class="wp-block-heading contact-cards__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h1>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="contact-cards__row">
		<div class="contact-cards__group">
			<article class="contact-card">
				<div class="contact-card__content">
					<div class="contact-card__head">
						<h2 class="contact-card__title"><?php echo esc_html( $gen_title ); ?></h2>
						<?php if ( $gen_desc ) : ?><p class="contact-card__desc"><?php echo esc_html( $gen_desc ); ?></p><?php endif; ?>
					</div>

					<div class="contact-card__items">
						<?php if ( $gen_email ) : ?>
						<span class="contact-card__item">
							<span class="contact-card__item-icon" aria-hidden="true"><?php echo $icon_mail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="contact-card__item-text"><?php echo esc_html( $gen_email ); ?></span>
						</span>
						<?php endif; ?>
						<?php if ( $gen_phone ) : ?>
						<span class="contact-card__item">
							<span class="contact-card__item-icon" aria-hidden="true"><?php echo $icon_phone; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="contact-card__item-text"><?php echo esc_html( $gen_phone ); ?></span>
						</span>
						<?php endif; ?>
					</div>

					<?php if ( $gen_note ) : ?><p class="contact-card__note"><?php echo esc_html( $gen_note ); ?></p><?php endif; ?>
				</div>
			</article>

			<article class="contact-card">
				<div class="contact-card__content">
					<div class="contact-card__head">
						<h2 class="contact-card__title"><?php echo esc_html( $media_title ); ?></h2>
						<?php if ( $media_desc ) : ?><p class="contact-card__desc"><?php echo esc_html( $media_desc ); ?></p><?php endif; ?>
					</div>

					<div class="contact-card__items">
						<?php if ( $media_email ) : ?>
						<span class="contact-card__item">
							<span class="contact-card__item-icon" aria-hidden="true"><?php echo $icon_mail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
							<span class="contact-card__item-text"><?php echo esc_html( $media_email ); ?></span>
						</span>
						<?php endif; ?>
					</div>

					<?php if ( $media_note ) : ?><p class="contact-card__note"><?php echo esc_html( $media_note ); ?></p><?php endif; ?>
				</div>
			</article>
		</div>

		<div class="contact-cards__text">
			<?php if ( $intro_tag ) : ?>
			<div class="contact-cards__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $intro_tag ); ?></span>
			</div>
			<?php endif; ?>
			<?php if ( $intro_body ) : ?><p class="contact-cards__lede"><?php echo esc_html( $intro_body ); ?></p><?php endif; ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
