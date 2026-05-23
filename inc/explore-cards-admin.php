<?php
/**
 * Explore Cards admin page — manages the cards in the homepage "Explore"
 * carousel. Each card has a title, image, description, link text, and link URL.
 *
 * Stored as the option `hbd_explore_cards`: a JSON-serialized array of:
 *   [ { title, description, image_id, link_text, link_url }, ... ]
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default cards (matches the original Figma layout).
 *
 * @return array
 */
function hbd_default_explore_cards() {
	return array(
		array(
			'title'       => 'Stay',
			'description' => 'A range of hotels within walking distance of the waterfront, dining, and shopping, offering a comfortable and easy stay.',
			'image_id'    => 0,
			'image_file'  => 'card-stay.png',
			'link_text'   => 'Explore',
			'link_url'    => '#',
		),
		array(
			'title'       => 'Dine',
			'description' => 'Cafés, restaurants, and seaside venues offer dining from morning through evening, with live music and nightlife by the water.',
			'image_id'    => 0,
			'image_file'  => 'card-dine.png',
			'link_text'   => 'Explore',
			'link_url'    => '#',
		),
		array(
			'title'       => 'Shop',
			'description' => 'From local snacks and souvenirs to daily essentials, shops are designed for everyday convenience.',
			'image_id'    => 0,
			'image_file'  => 'card-shop.png',
			'link_text'   => 'Explore',
			'link_url'    => '#',
		),
		array(
			'title'       => 'Nightlife',
			'description' => 'Casual pubs, karaoke rooms, and a lively nightclub offer different ways to enjoy the evening and late night.',
			'image_id'    => 0,
			'image_file'  => 'card-nightlife.png',
			'link_text'   => 'Explore',
			'link_url'    => '#',
		),
	);
}

/**
 * Register the option.
 */
function hbd_register_explore_cards_setting() {
	register_setting(
		'hbd_explore_cards_settings',
		'hbd_explore_cards',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'hbd_sanitize_explore_cards',
			'default'           => hbd_default_explore_cards(),
		)
	);
}
add_action( 'admin_init', 'hbd_register_explore_cards_setting' );

/**
 * Sanitize submitted card data. Form posts a JSON string in `hbd_explore_cards`.
 *
 * @param mixed $value Raw value from the form (JSON string or array).
 * @return array Cleaned list of cards.
 */
function hbd_sanitize_explore_cards( $value ) {
	if ( is_string( $value ) ) {
		$cards = json_decode( $value, true );
	} elseif ( is_array( $value ) ) {
		$cards = $value;
	} else {
		$cards = array();
	}

	if ( ! is_array( $cards ) ) {
		return array();
	}

	$clean = array();
	foreach ( $cards as $card ) {
		if ( ! is_array( $card ) ) {
			continue;
		}
		$clean[] = array(
			'title'       => isset( $card['title'] ) ? sanitize_text_field( $card['title'] ) : '',
			'description' => isset( $card['description'] ) ? sanitize_textarea_field( $card['description'] ) : '',
			'image_id'    => isset( $card['image_id'] ) ? absint( $card['image_id'] ) : 0,
			'image_file'  => isset( $card['image_file'] ) ? sanitize_file_name( $card['image_file'] ) : '',
			'link_text'   => isset( $card['link_text'] ) ? sanitize_text_field( $card['link_text'] ) : '',
			'link_url'    => isset( $card['link_url'] ) ? esc_url_raw( $card['link_url'] ) : '',
		);
	}
	return $clean;
}

/**
 * Resolve the image URL for a card. Prefers an uploaded attachment (image_id),
 * always returning the ORIGINAL master file via wp_get_original_image_url() so
 * the frontend never serves WP's `-scaled.jpg` downscale. Falls back to a
 * bundled theme asset (image_file) so default cards still render before the
 * editor uploads anything.
 *
 * @param array $card
 * @return string
 */
function hbd_explore_card_image_url( $card ) {
	$id = isset( $card['image_id'] ) ? (int) $card['image_id'] : 0;
	if ( $id ) {
		$url = function_exists( 'wp_get_original_image_url' ) ? wp_get_original_image_url( $id ) : '';
		if ( ! $url ) {
			$url = wp_get_attachment_url( $id );
		}
		if ( $url ) {
			return $url;
		}
	}
	$file = isset( $card['image_file'] ) ? $card['image_file'] : '';
	if ( $file ) {
		return HBD_THEME_URI . '/assets/images/' . $file;
	}
	return '';
}

/**
 * Register the admin menu page.
 */
function hbd_add_explore_cards_page() {
	add_theme_page(
		__( 'Explore Cards', 'harbour-bay-downtown' ),
		__( 'Explore Cards', 'harbour-bay-downtown' ),
		'manage_options',
		'hbd-explore-cards',
		'hbd_render_explore_cards_page'
	);
}
add_action( 'admin_menu', 'hbd_add_explore_cards_page' );

/**
 * Enqueue media library + admin JS on the Explore Cards page only.
 */
function hbd_enqueue_explore_cards_admin( $hook ) {
	if ( 'appearance_page_hbd-explore-cards' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script(
		'hbd-explore-cards-admin',
		HBD_THEME_URI . '/assets/admin/explore-cards.js',
		array( 'jquery', 'jquery-ui-sortable' ),
		HBD_THEME_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'hbd_enqueue_explore_cards_admin' );

/**
 * Render the Explore Cards admin page.
 */
function hbd_render_explore_cards_page() {
	$cards = get_option( 'hbd_explore_cards', hbd_default_explore_cards() );
	if ( ! is_array( $cards ) || empty( $cards ) ) {
		$cards = hbd_default_explore_cards();
	}

	// Resolve image URLs server-side so the admin doesn't need another roundtrip.
	$resolved = array();
	foreach ( $cards as $card ) {
		$resolved[] = array_merge(
			$card,
			array( 'image_url' => hbd_explore_card_image_url( $card ) )
		);
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Explore Cards', 'harbour-bay-downtown' ); ?></h1>
		<p style="max-width:70ch;"><?php esc_html_e( 'Add, remove, and reorder the cards shown in the homepage Explore carousel. Drag a card by its handle to reorder. The Explore button on each card links to the URL you set.', 'harbour-bay-downtown' ); ?></p>

		<form method="post" action="options.php" id="hbd-explore-form">
			<?php settings_fields( 'hbd_explore_cards_settings' ); ?>

			<div class="hbd-explore-list" style="display:flex;flex-direction:column;gap:16px;margin-top:16px;max-width:900px;"></div>

			<p style="margin-top:16px;">
				<button type="button" class="button button-secondary hbd-explore-add"><?php esc_html_e( '+ Add card', 'harbour-bay-downtown' ); ?></button>
			</p>

			<input type="hidden" name="hbd_explore_cards" id="hbd-explore-data" value="<?php echo esc_attr( wp_json_encode( $resolved ) ); ?>" />

			<?php submit_button( __( 'Save cards', 'harbour-bay-downtown' ) ); ?>
		</form>
	</div>
	<?php
}
