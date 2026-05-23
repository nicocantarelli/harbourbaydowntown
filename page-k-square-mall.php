<?php
/**
 * K Square Mall page — secondary-page template (auto-applied to the Page with slug "k-square-mall").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. The hero
 * matches the Stay-style centered title hero. The remaining sections are new: Free
 * Shuttle (details card), About (image collage + text), and Nearby Area (place cards).
 * Content is editable via Customizer → K Square Mall Page.
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'ksquare-hero' );
?>

<div class="site-content site-content--ksquare">
	<?php
	hbd_render_section( 'ksquare-shuttle' );
	hbd_render_section( 'ksquare-about' );
	hbd_render_section( 'ksquare-nearby' );
	?>
</div>

<?php
get_footer();
