<?php
/**
 * Title: Contact — Location
 * Slug: harbour-bay-downtown/contact-location
 * Categories: harbour-bay-downtown
 * Description: A centered "Location" title above an address column (left) and a Google Map (right). The map uses the Google Maps Embed API when an API key is set (Customizer → Contact Page → Contact — Location); until then it falls back to a keyless embed so a real map still shows. Editable via Customizer → Contact Page → Contact — Location.
 * Inserter: no
 * Viewport Width: 1440
 */

$title   = nl2br( esc_html( get_theme_mod( 'hbd_contact_location_title', 'Location' ) ) );
$tag     = get_theme_mod( 'hbd_contact_location_tag', 'Where Is' );
$place   = nl2br( esc_html( get_theme_mod( 'hbd_contact_location_place', 'Harbour Bay Downtown' ) ) );
$address = nl2br( esc_html( get_theme_mod( 'hbd_contact_location_address', "Harbour Bay, Batam, Indonesia\nLocated directly beside Harbour Bay International Ferry Terminal." ) ) );

$map_query = get_theme_mod( 'hbd_contact_map_query', 'Harbour Bay Downtown, Batam, Indonesia' );
$map_key   = get_theme_mod( 'hbd_contact_map_key', '' );

// With an API key, use the official Maps Embed API. Without one, fall back to the
// keyless embed so a real map still renders until the client supplies their key.
if ( $map_key ) {
	$map_src = 'https://www.google.com/maps/embed/v1/place?key=' . rawurlencode( $map_key ) . '&q=' . rawurlencode( $map_query );
} else {
	$map_src = 'https://maps.google.com/maps?q=' . rawurlencode( $map_query ) . '&z=15&output=embed';
}
?>
<!-- wp:group {"tagName":"section","className":"contact-location","layout":{"type":"default"}} -->
<section class="wp-block-group contact-location">
	<!-- wp:heading {"level":2,"className":"contact-location__title","textAlign":"center"} -->
	<h2 class="wp-block-heading contact-location__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="contact-location__row">
		<div class="contact-location__info">
			<?php if ( $tag ) : ?>
			<div class="contact-location__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>

			<div class="contact-location__text">
				<h3 class="contact-location__place"><?php echo $place; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h3>
				<p class="contact-location__address"><?php echo $address; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></p>
			</div>
		</div>

		<div class="contact-location__map">
			<iframe src="<?php echo esc_url( $map_src ); ?>" title="<?php echo esc_attr( get_theme_mod( 'hbd_contact_location_place', 'Harbour Bay Downtown' ) ); ?>" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
