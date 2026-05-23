<?php
/**
 * Contact page — secondary-page template (auto-applied to the Page with slug "contact-us").
 *
 * Like the Map and Magazine pages, this one has NO full-screen hero — it uses the solid
 * site header. "Contact Us" is a centered title with two info cards + an intro; "Send Us a
 * Message" reuses the Live & Work enquiry-form layout; "Location" pairs an address with a
 * Google Map embed. Content is editable via Customizer → Contact Page.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content site-content--contact">
	<?php
	hbd_render_section( 'contact-cards' );
	hbd_render_section( 'contact-message' );
	hbd_render_section( 'contact-location' );
	?>
</div>

<?php
get_footer();
