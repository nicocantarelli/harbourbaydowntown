<?php
/**
 * Title: Wellness Hero
 * Slug: harbour-bay-downtown/wellness-hero
 * Categories: harbour-bay-downtown
 * Description: Full-screen hero with a centered title, a vertical line decoration, and a subtitle. Editable via Customizer → Wellness & Spa Page → Wellness — Hero.
 * Inserter: no
 * Viewport Width: 1440
 */

$bg_url        = hbd_resolve_image( 'hbd_wellness_hero_image_id', 'wellness-hero.png' );
$heading_raw   = get_theme_mod( 'hbd_wellness_hero_title', 'Wellness & Spa' );
$heading_html  = nl2br( esc_html( $heading_raw ) ); // escape first, then convert newlines to <br>.
$subtitle_raw  = get_theme_mod( 'hbd_wellness_hero_subtitle', 'Wellness at Harbour Bay Downtown is about slowing down and feeling good without going far. From full spa treatments to quick massages and beauty services, everything is close by and easy to fit into your day.' );
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
