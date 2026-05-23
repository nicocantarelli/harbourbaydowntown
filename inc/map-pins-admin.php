<?php
/**
 * Map Pins admin page — a visual drag-and-drop editor for the location pins
 * that overlay the homepage map. Each pin has a position (x%, y%), an
 * optional uploaded icon, and a label (used as aria-label on the frontend).
 *
 * Stored as the option `hbd_map_pins` — a JSON-serialized array of objects:
 *   [ { x: float, y: float, icon_id: int, label: string }, ... ]
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The teardrop pin shape as inline SVG (so CSS can recolour it via currentColor).
 * Used by the frontend map patterns instead of an <img>, which can't be themed.
 *
 * @param string $style Optional inline style for the <svg>.
 * @return string Inline SVG markup.
 */
function hbd_map_pin_shape_svg( $style = '' ) {
	$style_attr = $style ? ' style="' . esc_attr( $style ) . '"' : '';
	return '<svg class="map-pin__shape" width="53" height="61" viewBox="0 0 53 61" fill="currentColor" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"' . $style_attr . '>'
		. '<path d="M44.25 22.25C44.25 36.25 26.25 48.25 26.25 48.25C26.25 48.25 8.25 36.25 8.25 22.25C8.25 17.4761 10.1464 12.8977 13.5221 9.52208C16.8977 6.14642 21.4761 4.25 26.25 4.25C31.0239 4.25 35.6023 6.14642 38.9779 9.52208C42.3536 12.8977 44.25 17.4761 44.25 22.25Z"/>'
		. '<circle cx="26.25" cy="56.25" r="4"/>'
		. '</svg>';
}

/**
 * Built-in pin icon presets. Each value is a slug used as the filename
 * (assets/icons/pin-{slug}.svg) and as the value stored in `icon_preset`.
 *
 * @return array<string,array{label:string,file:string}>
 */
function hbd_pin_icon_presets() {
	return array(
		'route'    => array( 'label' => __( 'Route',    'harbour-bay-downtown' ), 'file' => 'pin-route.svg' ),
		'coffee'   => array( 'label' => __( 'Café',     'harbour-bay-downtown' ), 'file' => 'pin-coffee.svg' ),
		'building' => array( 'label' => __( 'Building', 'harbour-bay-downtown' ), 'file' => 'pin-building.svg' ),
		'bag'      => array( 'label' => __( 'Shopping', 'harbour-bay-downtown' ), 'file' => 'pin-bag.svg' ),
	);
}

/**
 * Default pins that match the original Figma layout.
 *
 * @return array
 */
function hbd_default_map_pins() {
	return array(
		array( 'x' => 9.0,  'y' => 18.0, 'icon_id' => 0, 'icon_preset' => 'route',    'label' => 'Walking route' ),
		array( 'x' => 18.0, 'y' => 23.0, 'icon_id' => 0, 'icon_preset' => 'coffee',   'label' => 'Café' ),
		array( 'x' => 67.0, 'y' => 14.0, 'icon_id' => 0, 'icon_preset' => 'coffee',   'label' => 'Café' ),
		array( 'x' => 33.0, 'y' => 43.0, 'icon_id' => 0, 'icon_preset' => 'building', 'label' => 'Building' ),
		array( 'x' => 39.0, 'y' => 40.0, 'icon_id' => 0, 'icon_preset' => 'bag',      'label' => 'Shopping' ),
		array( 'x' => 63.0, 'y' => 44.0, 'icon_id' => 0, 'icon_preset' => 'building', 'label' => 'Building' ),
		array( 'x' => 42.0, 'y' => 69.0, 'icon_id' => 0, 'icon_preset' => 'building', 'label' => 'Building' ),
	);
}

/**
 * Register the option.
 */
function hbd_register_map_pins_setting() {
	register_setting(
		'hbd_map_pins_settings',
		'hbd_map_pins',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'hbd_sanitize_map_pins',
			'default'           => hbd_default_map_pins(),
		)
	);
}
add_action( 'admin_init', 'hbd_register_map_pins_setting' );

/**
 * Sanitize submitted pin data. Form posts a JSON string in `hbd_map_pins`.
 *
 * @param mixed $value Raw value from the form (JSON string or array).
 * @return array Cleaned list of pins.
 */
function hbd_sanitize_map_pins( $value ) {
	if ( is_string( $value ) ) {
		$pins = json_decode( $value, true );
	} elseif ( is_array( $value ) ) {
		$pins = $value;
	} else {
		$pins = array();
	}

	if ( ! is_array( $pins ) ) {
		return array();
	}

	$valid_presets = array_keys( hbd_pin_icon_presets() );

	$clean = array();
	foreach ( $pins as $pin ) {
		if ( ! is_array( $pin ) ) {
			continue;
		}
		$preset = isset( $pin['icon_preset'] ) ? sanitize_key( $pin['icon_preset'] ) : '';
		if ( ! in_array( $preset, $valid_presets, true ) ) {
			$preset = '';
		}
		$clean[] = array(
			'x'           => max( 0, min( 100, (float) ( $pin['x'] ?? 50 ) ) ),
			'y'           => max( 0, min( 100, (float) ( $pin['y'] ?? 50 ) ) ),
			'icon_id'     => isset( $pin['icon_id'] ) ? absint( $pin['icon_id'] ) : 0,
			'icon_preset' => $preset,
			'label'       => isset( $pin['label'] ) ? sanitize_text_field( $pin['label'] ) : '',
			'title'       => isset( $pin['title'] ) ? sanitize_text_field( $pin['title'] ) : '',
			'category'    => isset( $pin['category'] ) ? sanitize_text_field( $pin['category'] ) : '',
			'description' => isset( $pin['description'] ) ? sanitize_textarea_field( $pin['description'] ) : '',
			'link'        => isset( $pin['link'] ) ? esc_url_raw( $pin['link'] ) : '',
			'image_id'    => isset( $pin['image_id'] ) ? absint( $pin['image_id'] ) : 0,
		);
	}
	return $clean;
}

/**
 * Register the admin menu page.
 */
function hbd_add_map_pins_page() {
	add_theme_page(
		__( 'Map Pins', 'harbour-bay-downtown' ),
		__( 'Map Pins', 'harbour-bay-downtown' ),
		'manage_options',
		'hbd-map-pins',
		'hbd_render_map_pins_page'
	);
}
add_action( 'admin_menu', 'hbd_add_map_pins_page' );

/**
 * Enqueue media library + admin JS/CSS on the Map Pins page only.
 */
function hbd_enqueue_map_pins_admin( $hook ) {
	if ( 'appearance_page_hbd-map-pins' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script(
		'hbd-map-pins-admin',
		HBD_THEME_URI . '/assets/admin/map-pins.js',
		array( 'jquery' ),
		HBD_THEME_VERSION,
		true
	);
	$presets = array();
	foreach ( hbd_pin_icon_presets() as $key => $preset ) {
		$presets[ $key ] = array(
			'label' => $preset['label'],
			'url'   => HBD_THEME_URI . '/assets/icons/' . $preset['file'],
		);
	}

	wp_localize_script(
		'hbd-map-pins-admin',
		'HBDMapPins',
		array(
			'pinSvg'  => HBD_THEME_URI . '/assets/icons/map-pin.svg',
			'presets' => $presets,
		)
	);
}
add_action( 'admin_enqueue_scripts', 'hbd_enqueue_map_pins_admin' );

/**
 * Render the Map Pins admin page.
 */
function hbd_render_map_pins_page() {
	$pins = get_option( 'hbd_map_pins', hbd_default_map_pins() );
	if ( ! is_array( $pins ) || empty( $pins ) ) {
		$pins = hbd_default_map_pins();
	}

	// Resolve the map image — same logic as the frontend.
	$map_image_url = hbd_resolve_image( 'hbd_map_image_id', 'map-bg.png' );

	// Build the icon-URL lookup so JS can render thumbnails.
	$icon_urls = array();
	// Tooltip image previews (image_id → medium URL).
	$image_urls = array();
	foreach ( $pins as $pin ) {
		$id = isset( $pin['icon_id'] ) ? absint( $pin['icon_id'] ) : 0;
		if ( $id && ! isset( $icon_urls[ $id ] ) ) {
			$icon_urls[ $id ] = wp_get_attachment_image_url( $id, 'thumbnail' );
		}
		$img_id = isset( $pin['image_id'] ) ? absint( $pin['image_id'] ) : 0;
		if ( $img_id && ! isset( $image_urls[ $img_id ] ) ) {
			$image_urls[ $img_id ] = wp_get_attachment_image_url( $img_id, 'medium' );
		}
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Map Pins', 'harbour-bay-downtown' ); ?></h1>
		<p style="max-width:70ch;"><?php esc_html_e( 'Drag pins to reposition them on the map. Click a pin to edit its icon, label, and hover tooltip (title, category, description, image, link). Click "+ Add pin" to drop a new pin in the center.', 'harbour-bay-downtown' ); ?></p>

		<form method="post" action="options.php" id="hbd-pins-form">
			<?php settings_fields( 'hbd_map_pins_settings' ); ?>

			<div class="hbd-pins-editor" style="display:flex;gap:24px;align-items:flex-start;margin-top:16px;flex-wrap:wrap;">
				<div class="hbd-pins-canvas" style="position:relative;width:828px;max-width:100%;aspect-ratio:828/416;border:1px solid #c3c4c7;border-radius:8px;overflow:hidden;background:#f0f0f1;user-select:none;flex-shrink:0;">
					<img src="<?php echo esc_url( $map_image_url ); ?>" alt="Map" style="width:100%;height:100%;object-fit:cover;object-position:bottom;display:block;pointer-events:none;" />
					<div class="hbd-pins-layer" style="position:absolute;inset:0;"></div>
				</div>

				<aside class="hbd-pins-sidebar" style="width:300px;flex-shrink:0;">
					<div class="hbd-pin-form" style="display:none;padding:16px;background:#fff;border:1px solid #c3c4c7;border-radius:4px;">
						<h3 style="margin-top:0;"><?php esc_html_e( 'Selected pin', 'harbour-bay-downtown' ); ?></h3>

						<p>
							<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Label', 'harbour-bay-downtown' ); ?></label>
							<input type="text" class="hbd-pin-label regular-text" style="width:100%;" />
							<span class="description"><?php esc_html_e( 'For screen readers (aria-label on the pin).', 'harbour-bay-downtown' ); ?></span>
						</p>

						<hr style="margin:16px 0;" />
						<p style="font-weight:600;margin:0 0 4px;"><?php esc_html_e( 'Tooltip', 'harbour-bay-downtown' ); ?></p>
						<p class="description" style="margin-top:0;"><?php esc_html_e( 'Shown when hovering the pin. Leave the title empty to show no tooltip.', 'harbour-bay-downtown' ); ?></p>

						<p>
							<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Title', 'harbour-bay-downtown' ); ?></label>
							<input type="text" class="hbd-pin-title regular-text" style="width:100%;" />
						</p>

						<p>
							<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Category chip', 'harbour-bay-downtown' ); ?></label>
							<input type="text" class="hbd-pin-category regular-text" style="width:100%;" />
							<span class="description"><?php esc_html_e( 'Small chip on the image, e.g. "Hotel". Optional.', 'harbour-bay-downtown' ); ?></span>
						</p>

						<p>
							<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Description', 'harbour-bay-downtown' ); ?></label>
							<textarea class="hbd-pin-description" rows="3" style="width:100%;"></textarea>
						</p>

						<p>
							<label style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Link', 'harbour-bay-downtown' ); ?></label>
							<input type="url" class="hbd-pin-link regular-text" style="width:100%;" placeholder="https://" />
							<span class="description"><?php esc_html_e( 'Where the tooltip card links to. Optional.', 'harbour-bay-downtown' ); ?></span>
						</p>

						<p>
							<label style="display:block;font-weight:600;margin-bottom:6px;"><?php esc_html_e( 'Image', 'harbour-bay-downtown' ); ?></label>
							<span class="hbd-pin-image-preview" style="display:block;margin-bottom:6px;"></span>
							<button type="button" class="button hbd-pin-image-choose"><?php esc_html_e( 'Set image…', 'harbour-bay-downtown' ); ?></button>
							<button type="button" class="button hbd-pin-image-clear" style="display:none;"><?php esc_html_e( 'Remove image', 'harbour-bay-downtown' ); ?></button>
						</p>

						<hr style="margin:16px 0;" />

						<p>
							<label style="display:block;font-weight:600;margin-bottom:6px;"><?php esc_html_e( 'Icon', 'harbour-bay-downtown' ); ?></label>
							<span class="description" style="display:block;margin-bottom:6px;"><?php esc_html_e( 'Pick a preset, or upload your own (white icons on dark backgrounds work best).', 'harbour-bay-downtown' ); ?></span>
							<div class="hbd-pin-presets" style="display:grid;grid-template-columns:repeat(4,1fr);gap:6px;margin-bottom:8px;"></div>
							<button type="button" class="button hbd-pin-icon-choose"><?php esc_html_e( 'Upload custom…', 'harbour-bay-downtown' ); ?></button>
							<button type="button" class="button hbd-pin-icon-clear" style="display:none;"><?php esc_html_e( 'Clear', 'harbour-bay-downtown' ); ?></button>
						</p>

						<p style="display:flex;gap:8px;">
							<label style="flex:1;">
								<span style="display:block;font-weight:600;margin-bottom:4px;">X (%)</span>
								<input type="number" min="0" max="100" step="0.1" class="hbd-pin-x" style="width:100%;" />
							</label>
							<label style="flex:1;">
								<span style="display:block;font-weight:600;margin-bottom:4px;">Y (%)</span>
								<input type="number" min="0" max="100" step="0.1" class="hbd-pin-y" style="width:100%;" />
							</label>
						</p>

						<p>
							<button type="button" class="button button-link-delete hbd-pin-remove"><?php esc_html_e( 'Remove pin', 'harbour-bay-downtown' ); ?></button>
						</p>
					</div>

					<p style="margin-top:16px;">
						<button type="button" class="button button-secondary hbd-pin-add" style="width:100%;"><?php esc_html_e( '+ Add pin', 'harbour-bay-downtown' ); ?></button>
					</p>
				</aside>
			</div>

			<input type="hidden" name="hbd_map_pins" id="hbd-pins-data" value="<?php echo esc_attr( wp_json_encode( $pins ) ); ?>" />
			<script type="application/json" id="hbd-pins-icon-urls"><?php echo wp_json_encode( $icon_urls ); ?></script>
			<script type="application/json" id="hbd-pins-image-urls"><?php echo wp_json_encode( $image_urls ); ?></script>

			<?php submit_button( __( 'Save pins', 'harbour-bay-downtown' ) ); ?>
		</form>
	</div>
	<?php
}
