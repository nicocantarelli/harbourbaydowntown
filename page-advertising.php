<?php
/**
 * Advertising page — secondary-page template (auto-applied to the Page with slug "advertising").
 *
 * Non-hero (solid header), like Contact / Map / Magazine. Key Numbers and Ferry Passenger
 * Mix are stat-card sections; Advertising Opportunities pairs a benefits list with a labelled
 * image collage; "Get Your Brand Seen" is a banner card; and the enquiry form reuses the
 * Contact / Live & Work form. Content is editable via Customizer → Advertising Page.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content site-content--advertising">
	<?php
	hbd_render_section( 'adv-numbers' );
	hbd_render_section( 'adv-mix' );
	hbd_render_section( 'adv-opportunities' );
	hbd_render_section( 'adv-cta' );
	hbd_render_section( 'adv-form' );
	?>
</div>

<?php
get_footer();
