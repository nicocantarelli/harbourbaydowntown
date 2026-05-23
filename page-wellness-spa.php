<?php
/**
 * Wellness & Spa page — secondary-page template (auto-applied to the Page with slug "wellness-spa").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. Sections
 * reuse the existing layouts: Easy to Fit reuses the Explore decor-title treatment with
 * the "Our Story" card mirrored; Spa & Massage is a carousel of full-image cards
 * (Card_Type_7); Beauty & Grooming is the standard Listings grid (Wellness type).
 * Content is editable via Customizer → Wellness & Spa Page.
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'wellness-hero' );
?>

<div class="site-content">
	<?php
	hbd_render_section( 'wellness-easyfit' );
	hbd_render_section( 'wellness-spa' );
	hbd_render_section( 'wellness-beauty' );
	?>
</div>

<?php
get_footer();
