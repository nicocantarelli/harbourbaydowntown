<?php
/**
 * Shop page — secondary-page template (auto-applied to the Page with slug "shop").
 *
 * Mirrors the Dine page: hero, Shop Guides, Categories, Special Promotions, and a
 * Shops grid carousel. Only the Special Promotions cards differ (one large image
 * card + two stacked mini cards). Content is editable via Customizer → Shop Page
 * (the cards are static placeholders).
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'shop-hero' );
?>

<div class="site-content">
	<?php
	hbd_render_section( 'shop-guides' );
	hbd_render_section( 'shop-categories' );
	hbd_render_section( 'shop-promotions' );
	hbd_render_section( 'shop-shops' );
	?>
</div>

<?php
get_footer();
