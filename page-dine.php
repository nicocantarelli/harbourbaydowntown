<?php
/**
 * Dine page — secondary-page template (auto-applied to the Page with slug "dine").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px.
 * "Dine Guides" reuses the Stay Guides layout; "Categories" is a static filter +
 * card row; "Special Promotions" is a carousel of wide date-range cards; and
 * "Restaurants" is the Hotels grid with carousel controls. Content is editable
 * via Customizer → Dine Page (the cards are static placeholders).
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'dine-hero' );
?>

<div class="site-content">
	<?php
	hbd_render_section( 'dine-guides' );
	hbd_render_section( 'dine-categories' );
	hbd_render_section( 'dine-promotions' );
	hbd_render_section( 'dine-restaurants' );
	?>
</div>

<?php
get_footer();
