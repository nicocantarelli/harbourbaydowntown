<?php
/**
 * Sales & Leasing page — secondary-page template (auto-applied to the Page with slug "sales-leasing").
 *
 * Non-hero (solid header), like Contact / Advertising. "Why Harbour Bay" pairs copy + stats with
 * a photo; "Built-In Traffic" and "What Makes This Different" are stat-card sections; "Integrated
 * Environment" is a labelled image collage with a central text card; "Opportunities Available"
 * shows the leasable spaces + upcoming developments; and the enquiry form reuses the Contact /
 * Live & Work form. Content is editable via Customizer → Sales & Leasing Page.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content site-content--sales-leasing">
	<?php
	hbd_render_section( 'sl-why' );
	hbd_render_section( 'sl-traffic' );
	hbd_render_section( 'sl-environment' );
	hbd_render_section( 'sl-opportunities' );
	hbd_render_section( 'sl-different' );
	hbd_render_section( 'sl-form' );
	?>
</div>

<?php
get_footer();
