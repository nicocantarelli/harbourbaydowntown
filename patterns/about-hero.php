<?php
/**
 * Title: About Hero
 * Slug: harbour-bay-downtown/about-hero
 * Categories: harbour-bay-downtown
 * Description: Full-screen secondary-page hero — single background image with a bottom scrim, big title, and a CTA. Editable via Customizer → Theme Options → About — Hero.
 * Inserter: no
 * Viewport Width: 1440
 */

$bg_url       = hbd_resolve_image( 'hbd_about_hero_image_id', 'about-hero.png' );
$heading_raw  = get_theme_mod( 'hbd_about_hero_title', 'Where City Life Flows by the Sea' );
$heading_html = nl2br( esc_html( $heading_raw ) ); // escape first, then convert newlines to <br>.
$cta_label    = get_theme_mod( 'hbd_about_hero_cta_label', 'Explore the District' );
$cta_url      = get_theme_mod( 'hbd_about_hero_cta_url', '#' );
?>
<!-- wp:group {"tagName":"section","className":"page-hero","layout":{"type":"default"}} -->
<section class="wp-block-group page-hero">
	<!-- wp:html -->
	<figure class="page-hero__background"><img src="<?php echo esc_url( $bg_url ); ?>" alt=""/></figure>
	<!-- /wp:html -->

	<!-- wp:group {"className":"page-hero__inner","layout":{"type":"default"}} -->
	<div class="wp-block-group page-hero__inner">
		<!-- wp:heading {"level":1,"className":"page-hero__title","textColor":"base"} -->
		<h1 class="wp-block-heading page-hero__title has-base-color has-text-color"><?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already escaped via esc_html() above ?></h1>
		<!-- /wp:heading -->

		<?php if ( $cta_label ) : ?>
		<!-- wp:buttons {"className":"page-hero__cta"} -->
		<div class="wp-block-buttons page-hero__cta">
			<!-- wp:button {"className":"is-style-pill-big"} -->
			<div class="wp-block-button is-style-pill-big"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
