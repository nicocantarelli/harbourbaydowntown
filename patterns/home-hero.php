<?php
/**
 * Title: Home Hero
 * Slug: harbour-bay-downtown/home-hero
 * Categories: harbour-bay-downtown
 * Description: Two-image parallax hero. Background image sits behind the title, foreground image overlaps in front. Text content and CTA are configurable via Customizer → Theme Options → Hero.
 * Block Types:
 * Viewport Width: 1440
 */

$bg_url = hbd_hero_image_url( 'hbd_hero_background_id', 'hero-aerial.png' );
$fg_url = hbd_hero_image_url( 'hbd_hero_foreground_id', 'hero-overlay.png' );

$heading_raw  = get_theme_mod( 'hbd_hero_heading', "Harbour Bay\nDowntown" );
$heading_html = nl2br( esc_html( $heading_raw ) ); // escape first, then convert newlines to <br>.
$tagline      = get_theme_mod( 'hbd_hero_tagline', 'Stay. Dine. Stroll. Relax.' );
$cta_label    = get_theme_mod( 'hbd_hero_cta_label', 'Explore' );
$cta_url      = get_theme_mod( 'hbd_hero_cta_url', '#explore' );
?>
<!-- wp:group {"tagName":"section","className":"home-hero","layout":{"type":"default"}} -->
<section class="wp-block-group home-hero">
	<!-- wp:html -->
	<figure class="home-hero__background"><img src="<?php echo esc_url( $bg_url ); ?>" alt=""/></figure>
	<!-- /wp:html -->

	<!-- wp:group {"className":"home-hero__bottom","layout":{"type":"default"}} -->
	<div class="wp-block-group home-hero__bottom">
		<!-- wp:heading {"level":1,"className":"home-hero__heading","textColor":"base"} -->
		<h1 class="wp-block-heading home-hero__heading has-base-color has-text-color"><?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — already escaped via esc_html() above ?></h1>
		<!-- /wp:heading -->

		<?php // Tagline sits here (heading → tagline → button) when stacked on mobile;
			// on desktop it's absolutely positioned, so this DOM spot is layout-neutral. ?>
		<!-- wp:group {"className":"home-hero__tagline","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
		<div class="wp-block-group home-hero__tagline">
			<!-- wp:html -->
			<span class="home-hero__tagline-dash" aria-hidden="true"></span>
			<!-- /wp:html -->

			<!-- wp:paragraph {"className":"home-hero__tagline-text","textColor":"base","fontSize":"body-20"} -->
			<p class="home-hero__tagline-text has-base-color has-text-color has-body-20-font-size"><?php echo esc_html( $tagline ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons {"className":"home-hero__cta"} -->
		<div class="wp-block-buttons home-hero__cta">
			<!-- wp:button {"className":"is-style-pill-big"} -->
			<div class="wp-block-button is-style-pill-big"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<figure class="home-hero__foreground"><img src="<?php echo esc_url( $fg_url ); ?>" alt=""/></figure>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
