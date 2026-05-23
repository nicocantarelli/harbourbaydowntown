<?php
/**
 * Title: What's On Hero
 * Slug: harbour-bay-downtown/whats-on-hero
 * Categories: harbour-bay-downtown
 * Description: Full-screen hero with a centered title, a vertical line decoration, and a subtitle. Editable via Customizer → What's On Page → What's On — Hero.
 * Inserter: no
 * Viewport Width: 1440
 */

$bg_url        = hbd_resolve_image( 'hbd_whatson_hero_image_id', 'whats-on-hero.png' );
$heading_raw   = get_theme_mod( 'hbd_whatson_hero_title', "What's On" );
$heading_html  = nl2br( esc_html( $heading_raw ) ); // escape first, then convert newlines to <br>.
$subtitle_raw  = get_theme_mod( 'hbd_whatson_hero_subtitle', "Discover upcoming events, seasonal activities, and special promotions happening across Harbour Bay Downtown. From community gatherings to dining offers, explore what's on during your visit." );
$subtitle_html = nl2br( esc_html( $subtitle_raw ) );
?>
<!-- wp:group {"tagName":"section","className":"page-hero page-hero--centered","layout":{"type":"default"}} -->
<section class="wp-block-group page-hero page-hero--centered">
	<!-- wp:html -->
	<figure class="page-hero__background"><img src="<?php echo esc_url( $bg_url ); ?>" alt=""/></figure>
	<!-- /wp:html -->

	<!-- wp:group {"className":"page-hero__inner","layout":{"type":"default"}} -->
	<div class="wp-block-group page-hero__inner">
		<!-- wp:heading {"level":1,"className":"page-hero__title","textColor":"base"} -->
		<h1 class="wp-block-heading page-hero__title has-base-color has-text-color"><?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h1>
		<!-- /wp:heading -->

		<?php if ( $subtitle_raw ) : ?>
		<!-- wp:html -->
		<div class="page-hero__sub">
			<span class="page-hero__line" aria-hidden="true"></span>
			<p class="page-hero__subtitle"><?php echo $subtitle_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></p>
		</div>
		<!-- /wp:html -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
