<?php
/**
 * About page — secondary-page template (auto-applied to the Page with slug "about").
 *
 * Structure mirrors front-page.php: a full-bleed hero outside .site-content, then
 * the constrained content sections (capped at 1440px) inside it. Three sections are
 * reused from the homepage; two ("A Place…", "Our Story") are About-specific.
 * Content is editable via Customizer → Theme Options → the "About — …" sections.
 *
 * @package HarbourBayDowntown
 */

// Opt this template into the overlay header + smart sticky nav (see header.php).
$GLOBALS['hbd_hero_page'] = true;

get_header();

hbd_render_section( 'about-hero' );
?>

<div class="site-content site-content--about">
	<?php
	hbd_render_section( 'about-easy-reach' );
	hbd_render_section( 'about-place' );
	hbd_render_section( 'about-story' );
	hbd_render_section( 'about-map' ); // independent copy of the homepage map.
	?>
</div>

<?php
get_footer();
