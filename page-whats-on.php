<?php
/**
 * What's On page — secondary-page template (auto-applied to the Page with slug "whats-on").
 *
 * Hero is full-bleed (outside .site-content); the rest is capped at 1440px. The hero
 * matches the Nightlife/Wellness centered hero. The middle "Featured Events" section is
 * a PLACEHOLDER for now (data model TBD). The bottom reuses the homepage Special
 * Promotions section verbatim.
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // overlay header + sticky nav.

get_header();

hbd_render_section( 'whats-on-hero' );
?>

<div class="site-content site-content--whats-on">
	<?php
	hbd_render_section( 'whats-on-events' );
	hbd_render_section( 'home-promotions' );
	?>
</div>

<?php
get_footer();
