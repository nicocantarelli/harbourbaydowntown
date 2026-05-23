<?php
/**
 * Title: Map — Full Map
 * Slug: harbour-bay-downtown/map-page
 * Categories: harbour-bay-downtown
 * Description: The shared walking-distance map (image + pins) rendered full-width with a "Map" heading. The map image (Customizer → Homepage → Map) and pins (Appearance → Map Pins) are shared with the homepage.
 * Inserter: no
 * Viewport Width: 1440
 */

$theme_uri     = esc_url( get_template_directory_uri() );
$title         = nl2br( esc_html( get_theme_mod( 'hbd_map_page_title', 'Map' ) ) );
$map_image_url = hbd_resolve_image( 'hbd_map_image_id', 'map-bg.png' );

$pins = get_option( 'hbd_map_pins', hbd_default_map_pins() );
if ( ! is_array( $pins ) || empty( $pins ) ) {
	$pins = hbd_default_map_pins();
}
$presets = hbd_pin_icon_presets();

// Inline styles for the pin + its children — guarantees the same dimensions and
// positions as the admin editor, independent of any CSS conflicts or cache states.
$pin_style   = 'position:absolute;display:inline-block;width:53px;height:61px;pointer-events:auto;margin:0;';
$shape_style = 'width:53px;height:61px;display:block;pointer-events:none;max-width:none;';
$icon_style  = 'position:absolute;top:39%;left:50%;margin:-11px 0 0 -11px;width:22px;height:22px;object-fit:contain;pointer-events:none;max-width:none;';
?>
<!-- wp:group {"tagName":"section","className":"map-page","layout":{"type":"default"}} -->
<section class="wp-block-group map-page">
	<!-- wp:heading {"level":1,"className":"map-page__title","textAlign":"center"} -->
	<h1 class="wp-block-heading map-page__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h1>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="home-map__map map-page__map">
		<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $map_image_url ); ?>" alt="<?php esc_attr_e( 'Map of Harbour Bay Downtown', 'harbour-bay-downtown' ); ?>"/></figure>

		<?php
		foreach ( $pins as $pin ) :
			$x       = (float) ( $pin['x'] ?? 50 );
			$y       = (float) ( $pin['y'] ?? 50 );
			$label   = isset( $pin['label'] ) ? $pin['label'] : '';
			$icon_id = isset( $pin['icon_id'] ) ? (int) $pin['icon_id'] : 0;
			$preset  = isset( $pin['icon_preset'] ) ? (string) $pin['icon_preset'] : '';

			$icon_url       = '';
			$icon_is_preset = false;
			if ( $icon_id ) {
				$icon_url = wp_get_attachment_image_url( $icon_id, 'thumbnail' );
			} elseif ( $preset && isset( $presets[ $preset ] ) ) {
				$icon_url       = $theme_uri . '/assets/icons/' . $presets[ $preset ]['file'];
				$icon_is_preset = true;
			}

			$icon_filter = $icon_is_preset ? '' : 'filter:brightness(0) invert(1);';

			$tip_title = isset( $pin['title'] ) ? (string) $pin['title'] : '';
			$tip_cat   = isset( $pin['category'] ) ? (string) $pin['category'] : '';
			$tip_desc  = isset( $pin['description'] ) ? (string) $pin['description'] : '';
			$tip_link  = isset( $pin['link'] ) ? (string) $pin['link'] : '';
			$tip_img   = ! empty( $pin['image_id'] ) ? wp_get_attachment_image_url( (int) $pin['image_id'], 'large' ) : '';
			$tip_tag   = $tip_link ? 'a' : 'span';
			?>
			<span class="map-pin" style="<?php echo esc_attr( $pin_style ); ?>left:<?php echo esc_attr( $x ); ?>%;top:<?php echo esc_attr( $y ); ?>%;"<?php if ( $label ) : ?> aria-label="<?php echo esc_attr( $label ); ?>" title="<?php echo esc_attr( $label ); ?>"<?php endif; ?>>
				<?php echo hbd_map_pin_shape_svg( $shape_style ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static markup, $style escaped inside ?>
				<?php if ( $icon_url ) : ?>
					<img class="map-pin__icon<?php echo $icon_is_preset ? ' map-pin__icon--preset' : ' map-pin__icon--upload'; ?>" src="<?php echo esc_url( $icon_url ); ?>" alt="" style="<?php echo esc_attr( $icon_style . $icon_filter ); ?>" />
				<?php endif; ?>
				<?php if ( $tip_title ) : ?>
					<span class="map-pin__tooltip">
						<<?php echo $tip_tag; // phpcs:ignore — 'a' or 'span' ?> class="map-pin__card"<?php echo $tip_link ? ' href="' . esc_url( $tip_link ) . '"' : ''; ?>>
							<?php if ( $tip_img ) : ?>
								<span class="map-pin__card-media">
									<img src="<?php echo esc_url( $tip_img ); ?>" alt="" />
									<?php if ( $tip_cat ) : ?><span class="tag-chip tag-chip--inverse map-pin__card-chip"><?php echo esc_html( $tip_cat ); ?></span><?php endif; ?>
									<?php if ( $tip_link ) : ?><span class="icon-button icon-button--light map-pin__card-arrow" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg></span><?php endif; ?>
								</span>
							<?php endif; ?>
							<span class="map-pin__card-body">
								<span class="map-pin__card-title"><?php echo esc_html( $tip_title ); ?></span>
								<?php if ( $tip_desc ) : ?><span class="map-pin__card-desc"><?php echo esc_html( $tip_desc ); ?></span><?php endif; ?>
							</span>
						</<?php echo $tip_tag; // phpcs:ignore — 'a' or 'span' ?>>
					</span>
				<?php endif; ?>
			</span>
			<?php
		endforeach;
		?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
