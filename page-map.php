<?php
/**
 * Map page — secondary-page template (auto-applied to the Page with slug "map").
 *
 * Unlike the other secondary pages, this one has NO full-screen hero — it uses the
 * solid site header and simply renders the shared walking-distance map (image +
 * pins) full-width under a "Map" heading.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content site-content--map">
	<?php hbd_render_section( 'map-page' ); ?>
</div>

<?php
get_footer();
