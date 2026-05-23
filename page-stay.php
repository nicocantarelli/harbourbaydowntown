<?php
/**
 * Stay page — secondary-page template (auto-applied to the Page with slug "stay").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. The
 * "Stay Guides" section reuses the Special Promotions layout (with a button +
 * Type-4 cards); the "Hotels" section is a static grid of Type-5 cards. Content
 * is editable via Customizer → Stay Page (the cards are static placeholders).
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'stay-hero' );
?>

<div class="site-content">
	<?php
	hbd_render_section( 'stay-guides' );
	hbd_render_section( 'stay-hotels' );
	?>
</div>

<?php
get_footer();
