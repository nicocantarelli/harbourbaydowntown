<?php
/**
 * Live & Work page — secondary-page template (auto-applied to the Page with slug "live-work").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. The hero
 * matches the Nightlife centered hero (title + line + subtitle). The buildings come
 * from the Buildings CPT (with a static fallback), the Coming Soon card is toggled in
 * the Customizer, and the enquiry form is a placeholder (not wired to a handler).
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'livework-hero' );
?>

<div class="site-content site-content--livework">
	<?php
	hbd_render_section( 'livework-buildings' );
	hbd_render_section( 'livework-coming-soon' );
	hbd_render_section( 'livework-contact' );
	?>
</div>

<?php
get_footer();
