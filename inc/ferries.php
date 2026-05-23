<?php
/**
 * Ferries — a custom post type for ferry operators shown on the Ferries page
 * (International / Domestic route cards). Each operator has a title (name), a
 * featured image (card photo), a logo, and meta: route, time, counter, link.
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Ferry CPT + the ferry_direction taxonomy.
 */
function hbd_register_ferries() {
	register_post_type(
		'hbd_ferry',
		array(
			'labels'             => array(
				'name'          => __( 'Ferries', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Ferry Operator', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Ferries', 'harbour-bay-downtown' ),
				'add_new_item'  => __( 'Add New Operator', 'harbour-bay-downtown' ),
				'edit_item'     => __( 'Edit Operator', 'harbour-bay-downtown' ),
				'not_found'     => __( 'No ferry operators yet.', 'harbour-bay-downtown' ),
			),
			'public'             => false,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'publicly_queryable' => false,
			'has_archive'        => false,
			'rewrite'            => false,
			'menu_icon'          => 'dashicons-tickets-alt',
			'menu_position'      => 28,
			'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'ferry_direction',
		'hbd_ferry',
		array(
			'labels'            => array(
				'name'          => __( 'Directions', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Direction', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Directions', 'harbour-bay-downtown' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
		)
	);

	hbd_seed_ferry_directions();
}
add_action( 'init', 'hbd_register_ferries' );

/**
 * Seed the International / Domestic directions once (guarded by an option flag).
 */
function hbd_seed_ferry_directions() {
	if ( get_option( 'hbd_ferry_directions_seeded' ) ) {
		return;
	}

	foreach ( array( 'international' => 'International', 'domestic' => 'Domestic' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'ferry_direction' ) ) {
			wp_insert_term( $name, 'ferry_direction', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_ferry_directions_seeded', 1 );
}

/**
 * Register the "Ferry details" meta box.
 */
function hbd_add_ferry_meta_box() {
	add_meta_box(
		'hbd_ferry_details',
		__( 'Ferry details', 'harbour-bay-downtown' ),
		'hbd_render_ferry_meta_box',
		'hbd_ferry',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'hbd_add_ferry_meta_box' );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post Current operator.
 */
function hbd_render_ferry_meta_box( $post ) {
	wp_nonce_field( 'hbd_ferry_details', 'hbd_ferry_details_nonce' );

	$route     = get_post_meta( $post->ID, '_hbd_ferry_route', true );
	$time      = get_post_meta( $post->ID, '_hbd_ferry_time', true );
	$counter   = get_post_meta( $post->ID, '_hbd_ferry_counter', true );
	$link      = get_post_meta( $post->ID, '_hbd_ferry_link', true );
	$logo_id   = (int) get_post_meta( $post->ID, '_hbd_ferry_logo', true );
	$logo_name = $logo_id ? wp_basename( (string) wp_get_attachment_url( $logo_id ) ) : '';
	?>
	<style>.hbd-meta p{margin:0 0 16px;} .hbd-meta label{display:block;font-weight:600;margin-bottom:4px;}</style>
	<div class="hbd-meta">
		<p>
			<label for="hbd_ferry_route"><?php esc_html_e( 'Route', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_ferry_route" name="hbd_ferry_route" value="<?php echo esc_attr( $route ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. HarbourFront Centre ( Singapore )', 'harbour-bay-downtown' ); ?>" />
		</p>
		<p>
			<label for="hbd_ferry_time"><?php esc_html_e( 'Time', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_ferry_time" name="hbd_ferry_time" value="<?php echo esc_attr( $time ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. 50min, or 1h - 1h 30min', 'harbour-bay-downtown' ); ?>" />
		</p>
		<p>
			<label for="hbd_ferry_counter"><?php esc_html_e( 'Counter location', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_ferry_counter" name="hbd_ferry_counter" value="<?php echo esc_attr( $counter ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Harbour Bay Ferry Terminal', 'harbour-bay-downtown' ); ?>" />
		</p>
		<p>
			<label for="hbd_ferry_link"><?php esc_html_e( 'Operator link', 'harbour-bay-downtown' ); ?></label>
			<input type="url" id="hbd_ferry_link" name="hbd_ferry_link" value="<?php echo esc_attr( $link ); ?>" class="widefat" placeholder="https://" />
			<span class="description"><?php esc_html_e( 'Where the "Visit Operator" button goes. Leave empty to hide it.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p class="hbd-file-field">
			<label><?php esc_html_e( 'Operator logo', 'harbour-bay-downtown' ); ?></label>
			<input type="hidden" class="hbd-file-id" name="hbd_ferry_logo" value="<?php echo esc_attr( $logo_id ); ?>" />
			<button type="button" class="button hbd-file-choose"><?php esc_html_e( 'Choose image', 'harbour-bay-downtown' ); ?></button>
			<button type="button" class="button-link hbd-file-clear" style="color:#b32d2e;<?php echo $logo_id ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'harbour-bay-downtown' ); ?></button>
			<span class="hbd-file-name" style="display:block;margin-top:6px;color:#646970;"><?php echo $logo_name ? esc_html( $logo_name ) : esc_html__( 'No image selected', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p class="description"><?php esc_html_e( 'The card photo is the Featured Image. Set the Direction (International / Domestic) in the Directions box. Order operators with the Order field (Page Attributes).', 'harbour-bay-downtown' ); ?></p>
	</div>
	<?php
}

/**
 * Save the meta box fields.
 *
 * @param int $post_id Operator ID.
 */
function hbd_save_ferry_meta( $post_id ) {
	if ( ! isset( $_POST['hbd_ferry_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hbd_ferry_details_nonce'] ) ), 'hbd_ferry_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_hbd_ferry_route', isset( $_POST['hbd_ferry_route'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_ferry_route'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_ferry_time', isset( $_POST['hbd_ferry_time'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_ferry_time'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_ferry_counter', isset( $_POST['hbd_ferry_counter'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_ferry_counter'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_ferry_link', isset( $_POST['hbd_ferry_link'] ) ? esc_url_raw( wp_unslash( $_POST['hbd_ferry_link'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_ferry_logo', isset( $_POST['hbd_ferry_logo'] ) ? absint( $_POST['hbd_ferry_logo'] ) : 0 );
}
add_action( 'save_post_hbd_ferry', 'hbd_save_ferry_meta' );

/**
 * Enqueue the media picker on the Ferry editor screen (reuses event-meta.js).
 *
 * @param string $hook Current admin page.
 */
function hbd_ferry_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'hbd_ferry' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'hbd-event-meta', HBD_THEME_URI . '/assets/admin/event-meta.js', array( 'jquery' ), HBD_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'hbd_ferry_admin_assets' );

/**
 * Fetch ferry operators of a direction as presentation-ready view models.
 *
 * @param string $direction Term slug: international | domestic.
 * @return array<int,array{name:string,image:string,logo:string,route:string,time:string,counter:string,link:string}>
 */
function hbd_get_ferries( $direction ) {
	$query = new WP_Query(
		array(
			'post_type'           => 'hbd_ferry',
			'post_status'         => 'publish',
			'posts_per_page'      => -1,
			'orderby'             => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'ferry_direction',
					'field'    => 'slug',
					'terms'    => $direction,
				),
			),
		)
	);

	$items = array();
	foreach ( $query->posts as $post ) {
		$image = get_the_post_thumbnail_url( $post->ID, 'large' );
		if ( ! $image ) {
			$image = HBD_THEME_URI . '/assets/images/nightlife-waterfront-1.png';
		}

		$logo_id  = (int) get_post_meta( $post->ID, '_hbd_ferry_logo', true );
		$logo_url = $logo_id ? (string) wp_get_attachment_image_url( $logo_id, 'medium' ) : '';

		$items[] = array(
			'name'    => get_the_title( $post ),
			'image'   => $image,
			'logo'    => $logo_url,
			'route'   => (string) get_post_meta( $post->ID, '_hbd_ferry_route', true ),
			'time'    => (string) get_post_meta( $post->ID, '_hbd_ferry_time', true ),
			'counter' => (string) get_post_meta( $post->ID, '_hbd_ferry_counter', true ),
			'link'    => (string) get_post_meta( $post->ID, '_hbd_ferry_link', true ),
		);
	}

	return $items;
}

/**
 * Default content for the ferry info FAQ groups (shared by the Customizer and
 * the pattern so defaults live in one place).
 *
 * @return array<int,array{0:string,1:string}> Keyed group => [ heading, "Q | A" lines ].
 */
function hbd_ferries_faq_defaults() {
	return array(
		1 => array(
			'Passenger Service',
			"Luggage Check-in | Drop your bags at the operator counter before departure. Check-in usually closes about 30 minutes before sailing.\nPorters & Trolleys | Need help with your luggage? Porters are available on request, usually near the designated drop-off zone (by KFC), and free trolleys are provided throughout the terminal.\nBusiness Class Lounge | Selected operators offer a business-class lounge with comfortable seating, refreshments, and priority boarding.",
		),
		2 => array(
			'Immigration',
			"Visa-On-Arrival | Many nationalities can buy a visa on arrival at the immigration counter. Have your passport and payment ready.\nPriority Lanes | Priority immigration lanes are available for eligible passengers to speed up clearance.\nImmigration Auto Lane (ILA) | Registered travellers can use the automated immigration lanes for faster, self-service clearance.\neBoarding Pass | Show your e-boarding pass from the operator's app or email at the gate — no printout needed.",
		),
		3 => array(
			'Other Amenities',
			"ATM & Money Changers | ATMs and licensed money changers are located inside the terminal for cash withdrawals and currency exchange.\nPortable WiFi Rental | Rent a portable WiFi device at the terminal to stay connected throughout your trip.\nFree Wifi | Complimentary WiFi is available throughout the terminal building.\nToilets & Prayer Rooms | Toilets and prayer rooms are available on each level of the terminal.",
		),
	);
}

/**
 * Parse "Question | Answer" lines into Q&A rows (for the ferry info FAQ).
 *
 * @param string $raw Textarea value, one "Q | A" per line.
 * @return array<int,array{q:string,a:string}>
 */
function hbd_parse_qa_lines( $raw ) {
	$rows  = array();
	$lines = preg_split( '/\R/', (string) $raw );
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$parts = array_map( 'trim', explode( '|', $line, 2 ) );
		$rows[] = array(
			'q' => $parts[0],
			'a' => isset( $parts[1] ) ? $parts[1] : '',
		);
	}
	return $rows;
}
