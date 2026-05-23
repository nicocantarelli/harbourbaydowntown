<?php
/**
 * Title: Advertising — Get Your Brand Seen
 * Slug: harbour-bay-downtown/adv-cta
 * Categories: harbour-bay-downtown
 * Description: A light banner card — title on the left, a pill + short paragraph on the right. Editable via Customizer → Advertising Page → Advertising — Get Your Brand Seen.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_adv_cta_title', 'Get Your Brand Seen' ) ) );
$tag   = get_theme_mod( 'hbd_adv_cta_tag', 'Advertising Enquiry' );
$body  = get_theme_mod( 'hbd_adv_cta_body', 'Fill out the contact form and our team will get back to you with our advertising rate card.' );
?>
<!-- wp:group {"tagName":"section","className":"adv-cta","layout":{"type":"default"}} -->
<section class="wp-block-group adv-cta">
	<!-- wp:html -->
	<div class="adv-cta__card">
		<h2 class="adv-cta__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>

		<div class="adv-cta__info">
			<?php if ( $tag ) : ?>
			<div class="adv-cta__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>
			<?php if ( $body ) : ?><p class="adv-cta__body"><?php echo esc_html( $body ); ?></p><?php endif; ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
