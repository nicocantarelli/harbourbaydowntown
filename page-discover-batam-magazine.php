<?php
/**
 * Magazine page — secondary-page template (auto-applied to the Page with slug "discover-batam-magazine").
 *
 * Like the Map page, this one has NO full-screen hero — it uses the solid site header.
 * The first block (Discover Batam) reuses the Wellness "Easy to Fit" decor-title + mirrored
 * card; "What You'll Find Inside" is new; "Read Online" reuses the Guides carousel layout
 * with image-only preview cards; "Where to Find the Magazine" reuses the Live & Work
 * "Coming Soon" card. Content is editable via Customizer → Magazine Page.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content site-content--magazine">
	<?php
	hbd_render_section( 'magazine-discover' );
	hbd_render_section( 'magazine-inside' );
	hbd_render_section( 'magazine-read' );
	hbd_render_section( 'magazine-where' );
	?>
</div>

<?php
get_footer();
