<?php
/**
 * Title: Shop Hero
 * Slug: harbour-bay-downtown/shop-hero
 * Categories: harbour-bay-downtown
 * Description: Full-screen hero with a centered title only. Editable via Customizer → Shop Page → Shop — Hero.
 * Inserter: no
 * Viewport Width: 1440
 */

$bg_url       = hbd_resolve_image( 'hbd_shop_hero_image_id', 'shop-hero.png' );
$heading_raw  = get_theme_mod( 'hbd_shop_hero_title', "Shop Along\nthe Bay" );
$heading_html = nl2br( esc_html( $heading_raw ) ); // escape first, then convert newlines to <br>.
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
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
