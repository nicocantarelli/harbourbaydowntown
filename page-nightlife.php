<?php
/**
 * Nightlife page — secondary-page template (auto-applied to the Page with slug "nightlife").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. Sections
 * reuse the About/homepage layouts: the waterfront section reuses .about-place, bars
 * reuses the Special Promotions layout, live music reuses the Explore layout, and the
 * closing section reuses "Our Story" with the staggered title. Content is editable via
 * Customizer → Nightlife Page (the bars/live-music cards are static placeholders).
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'nightlife-hero' );
?>

<div class="site-content">
	<?php
	hbd_render_section( 'nightlife-waterfront' );
	hbd_render_section( 'nightlife-bars' );
	hbd_render_section( 'nightlife-livemusic' );
	hbd_render_section( 'nightlife-evening' );
	?>
</div>

<?php
get_footer();
