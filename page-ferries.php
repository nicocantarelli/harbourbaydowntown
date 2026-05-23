<?php
/**
 * Ferry Services page — secondary-page template (auto-applied to the Page with slug "ferries").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. The hero
 * matches the Stay-style centered title hero. Travel Guides reuses the shared guides
 * carousel (the "travel" Guide Section). The International / Domestic Ferry Routes are
 * static ferry-operator cards, and the Immigration & Passenger Information section is a
 * grouped FAQ accordion. Content is editable via Customizer → Ferries Page.
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'ferry-hero' );
?>

<div class="site-content site-content--ferries">
	<?php
	hbd_render_section( 'ferry-guides' );
	hbd_render_section( 'ferry-international' );
	hbd_render_section( 'ferry-domestic' );
	hbd_render_section( 'ferry-immigration' );
	?>
</div>

<?php
get_footer();
