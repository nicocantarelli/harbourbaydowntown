<?php
/**
 * Events & Promotions — a single custom post type that powers every "What's On"
 * and "Special Promotions" section, and gives each item its own detail page.
 *
 * Each item has a title, featured image (the picture), the editor body (the
 * "information"), an Event/Promotion type (taxonomy), and meta: date, time,
 * location, and a link (external URL or uploaded file).
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Events & Promotions CPT + the event_type taxonomy.
 */
function hbd_register_events() {
	register_post_type(
		'hbd_event',
		array(
			'labels'             => array(
				'name'          => __( 'Events & Promotions', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Item', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Events & Promotions', 'harbour-bay-downtown' ),
				'add_new_item'  => __( 'Add New Event / Promotion', 'harbour-bay-downtown' ),
				'edit_item'     => __( 'Edit Event / Promotion', 'harbour-bay-downtown' ),
				'new_item'      => __( 'New Event / Promotion', 'harbour-bay-downtown' ),
				'search_items'  => __( 'Search Events & Promotions', 'harbour-bay-downtown' ),
				'not_found'     => __( 'Nothing here yet.', 'harbour-bay-downtown' ),
			),
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_rest'       => true,
			'has_archive'        => false,
			'rewrite'            => array( 'slug' => 'events', 'with_front' => false ),
			'menu_icon'          => 'dashicons-megaphone',
			'menu_position'      => 24,
			'supports'           => array( 'title', 'editor', 'thumbnail' ),
		)
	);

	register_taxonomy(
		'event_type',
		'hbd_event',
		array(
			'labels'            => array(
				'name'          => __( 'Types', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Type', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Types', 'harbour-bay-downtown' ),
			),
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
		)
	);

	hbd_seed_event_types();
}
add_action( 'init', 'hbd_register_events' );

/**
 * Seed the two default event types once (guarded by an option flag).
 */
function hbd_seed_event_types() {
	if ( get_option( 'hbd_event_types_seeded' ) ) {
		return;
	}

	foreach ( array( 'event' => 'Event', 'promotion' => 'Promotion' ) as $slug => $name ) {
		if ( ! term_exists( $slug, 'event_type' ) ) {
			wp_insert_term( $name, 'event_type', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_event_types_seeded', 1 );
}

/**
 * Flush rewrite rules once so the /events/<slug> detail-page URLs resolve.
 */
function hbd_events_maybe_flush_rewrites() {
	if ( get_option( 'hbd_events_rewrites_flushed' ) ) {
		return;
	}
	flush_rewrite_rules();
	update_option( 'hbd_events_rewrites_flushed', 1 );
}
add_action( 'init', 'hbd_events_maybe_flush_rewrites', 99 );

/**
 * Register the "Event details" meta box.
 */
function hbd_add_event_meta_box() {
	add_meta_box(
		'hbd_event_details',
		__( 'Event details', 'harbour-bay-downtown' ),
		'hbd_render_event_meta_box',
		'hbd_event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'hbd_add_event_meta_box' );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post Current item.
 */
function hbd_render_event_meta_box( $post ) {
	wp_nonce_field( 'hbd_event_details', 'hbd_event_details_nonce' );

	$featured = get_post_meta( $post->ID, '_hbd_event_featured', true );
	$date     = get_post_meta( $post->ID, '_hbd_event_date', true );
	$time     = get_post_meta( $post->ID, '_hbd_event_time', true );
	$location = get_post_meta( $post->ID, '_hbd_event_location', true );
	$map      = get_post_meta( $post->ID, '_hbd_event_map', true );
	$link_url = get_post_meta( $post->ID, '_hbd_event_link_url', true );
	$file_id  = (int) get_post_meta( $post->ID, '_hbd_event_link_file', true );
	$label    = get_post_meta( $post->ID, '_hbd_event_link_label', true );
	$file_name = $file_id ? wp_basename( (string) wp_get_attachment_url( $file_id ) ) : '';
	?>
	<style>.hbd-meta p{margin:0 0 16px;} .hbd-meta label{display:block;font-weight:600;margin-bottom:4px;} .hbd-meta label.hbd-inline{display:inline;font-weight:600;}</style>
	<div class="hbd-meta">
		<p>
			<label class="hbd-inline" for="hbd_event_featured"><input type="checkbox" id="hbd_event_featured" name="hbd_event_featured" value="1" <?php checked( $featured, '1' ); ?> /> <?php esc_html_e( 'Feature on the What\'s On page', 'harbour-bay-downtown' ); ?></label>
			<span class="description" style="display:block;"><?php esc_html_e( 'The "Featured Events" section on the What\'s On page shows up to 4 featured events.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_event_date"><?php esc_html_e( 'Date', 'harbour-bay-downtown' ); ?></label>
			<input type="date" id="hbd_event_date" name="hbd_event_date" value="<?php echo esc_attr( $date ); ?>" />
		</p>
		<p>
			<label for="hbd_event_time"><?php esc_html_e( 'Time', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_event_time" name="hbd_event_time" value="<?php echo esc_attr( $time ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. 7:00 PM, or Fri–Sat, 9 PM', 'harbour-bay-downtown' ); ?>" />
		</p>
		<p>
			<label for="hbd_event_location"><?php esc_html_e( 'Location', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_event_location" name="hbd_event_location" value="<?php echo esc_attr( $location ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Bayfront Plaza, Harbour Bay', 'harbour-bay-downtown' ); ?>" />
			<span class="description"><?php esc_html_e( 'The location name shown on the detail page.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_event_map"><?php esc_html_e( 'Map address / coordinates', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_event_map" name="hbd_event_map" value="<?php echo esc_attr( $map ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Full address, or latitude,longitude (e.g. 1.1305, 104.0530)', 'harbour-bay-downtown' ); ?>" />
			<span class="description"><?php esc_html_e( 'For an exact map pin. A full street address or "lat,long" works best. Falls back to the Location text if empty.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_event_link_url"><?php esc_html_e( 'Link URL', 'harbour-bay-downtown' ); ?></label>
			<input type="url" id="hbd_event_link_url" name="hbd_event_link_url" value="<?php echo esc_attr( $link_url ); ?>" class="widefat" placeholder="https://" />
			<span class="description"><?php esc_html_e( 'External link for the detail-page button. Leave empty to use an uploaded file instead.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p class="hbd-file-field">
			<label><?php esc_html_e( 'Or link a file', 'harbour-bay-downtown' ); ?></label>
			<input type="hidden" class="hbd-file-id" name="hbd_event_link_file" value="<?php echo esc_attr( $file_id ); ?>" />
			<button type="button" class="button hbd-file-choose"><?php esc_html_e( 'Choose file', 'harbour-bay-downtown' ); ?></button>
			<button type="button" class="button-link hbd-file-clear" style="color:#b32d2e;<?php echo $file_id ? '' : 'display:none;'; ?>"><?php esc_html_e( 'Remove', 'harbour-bay-downtown' ); ?></button>
			<span class="hbd-file-name" style="display:block;margin-top:6px;color:#646970;"><?php echo $file_name ? esc_html( $file_name ) : esc_html__( 'No file selected', 'harbour-bay-downtown' ); ?></span>
			<span class="description"><?php esc_html_e( 'A file (e.g. PDF) to download. Used only when no Link URL is set.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_event_link_label"><?php esc_html_e( 'Button label', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_event_link_label" name="hbd_event_link_label" value="<?php echo esc_attr( $label ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Find out more', 'harbour-bay-downtown' ); ?>" />
		</p>
		<p class="description"><?php esc_html_e( 'The picture is the Featured Image. The information is the main editor above. Set the Type (Event or Promotion) in the Types box.', 'harbour-bay-downtown' ); ?></p>
	</div>
	<?php
}

/**
 * Save the meta box fields.
 *
 * @param int $post_id Item ID.
 */
function hbd_save_event_meta( $post_id ) {
	if ( ! isset( $_POST['hbd_event_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hbd_event_details_nonce'] ) ), 'hbd_event_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$date = isset( $_POST['hbd_event_date'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_event_date'] ) ) : '';
	// Keep only a valid YYYY-MM-DD value so meta-date sorting stays correct.
	if ( $date && ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ) {
		$date = '';
	}

	update_post_meta( $post_id, '_hbd_event_featured', isset( $_POST['hbd_event_featured'] ) ? '1' : '' );
	update_post_meta( $post_id, '_hbd_event_date', $date );
	update_post_meta( $post_id, '_hbd_event_time', isset( $_POST['hbd_event_time'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_event_time'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_event_location', isset( $_POST['hbd_event_location'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_event_location'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_event_map', isset( $_POST['hbd_event_map'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_event_map'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_event_link_url', isset( $_POST['hbd_event_link_url'] ) ? esc_url_raw( wp_unslash( $_POST['hbd_event_link_url'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_event_link_file', isset( $_POST['hbd_event_link_file'] ) ? absint( $_POST['hbd_event_link_file'] ) : 0 );
	update_post_meta( $post_id, '_hbd_event_link_label', isset( $_POST['hbd_event_link_label'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_event_link_label'] ) ) : '' );
}
add_action( 'save_post_hbd_event', 'hbd_save_event_meta' );

/**
 * Enqueue the media picker on the Event editor screen.
 *
 * @param string $hook Current admin page.
 */
function hbd_event_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}
	$screen = get_current_screen();
	if ( ! $screen || 'hbd_event' !== $screen->post_type ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'hbd-event-meta', HBD_THEME_URI . '/assets/admin/event-meta.js', array( 'jquery' ), HBD_THEME_VERSION, true );
}
add_action( 'admin_enqueue_scripts', 'hbd_event_admin_assets' );

/**
 * Build a presentation-ready view model for an event/promotion post.
 *
 * @param WP_Post $post Item.
 * @return array{id:int,title:string,permalink:string,image:string,excerpt:string,date_raw:string,date_display:string,time:string,location:string,type:string,type_name:string}
 */
function hbd_event_view_model( $post ) {
	$id    = $post->ID;
	$terms = get_the_terms( $id, 'event_type' );
	$type  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->slug : '';
	$name  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';

	$image = get_the_post_thumbnail_url( $id, 'large' );
	if ( ! $image ) {
		$fallback = ( 'promotion' === $type ) ? 'promo-dining.png' : 'event-livemusic.png';
		$image    = HBD_THEME_URI . '/assets/images/' . $fallback;
	}

	$date_raw = (string) get_post_meta( $id, '_hbd_event_date', true );
	$summary  = $post->post_excerpt ? $post->post_excerpt : wp_strip_all_tags( $post->post_content );

	return array(
		'id'           => $id,
		'title'        => get_the_title( $post ),
		'permalink'    => get_permalink( $post ),
		'image'        => $image,
		'excerpt'      => hbd_truncate_text( $summary, 120 ),
		'date_raw'     => $date_raw,
		'date_display' => $date_raw ? date_i18n( get_option( 'date_format' ), strtotime( $date_raw ) ) : '',
		'time'         => (string) get_post_meta( $id, '_hbd_event_time', true ),
		'location'     => (string) get_post_meta( $id, '_hbd_event_location', true ),
		'map'          => (string) get_post_meta( $id, '_hbd_event_map', true ),
		'featured'     => '1' === (string) get_post_meta( $id, '_hbd_event_featured', true ),
		'type'         => $type,
		'type_name'    => $name,
	);
}

/**
 * Fetch events/promotions as view models, ordered by their date.
 *
 * @param array $args { type: 'event'|'promotion'|'', number: int, order: 'ASC'|'DESC' }.
 * @return array<int,array>
 */
function hbd_get_events( $args = array() ) {
	$args = wp_parse_args(
		$args,
		array(
			'type'     => '',
			'number'   => -1,
			'order'    => 'DESC',
			'featured' => false,
		)
	);

	// Order by the event date; a named clause lets us also filter by other meta.
	$meta_query = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
		'event_date' => array(
			'key'     => '_hbd_event_date',
			'compare' => 'EXISTS',
			'type'    => 'DATE',
		),
	);

	if ( $args['featured'] ) {
		$meta_query['featured'] = array(
			'key'   => '_hbd_event_featured',
			'value' => '1',
		);
	}

	$query_args = array(
		'post_type'           => 'hbd_event',
		'post_status'         => 'publish',
		'posts_per_page'      => (int) $args['number'],
		'meta_query'          => $meta_query,
		'orderby'             => array( 'event_date' => ( 'ASC' === strtoupper( $args['order'] ) ) ? 'ASC' : 'DESC' ),
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( $args['type'] ) {
		$query_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'event_type',
				'field'    => 'slug',
				'terms'    => $args['type'],
			),
		);
	}

	$query = new WP_Query( $query_args );

	$items = array();
	foreach ( $query->posts as $post ) {
		$items[] = hbd_event_view_model( $post );
	}

	return $items;
}

/**
 * Placeholder events shown until the client adds real ones, so the "What's On"
 * sections never render empty. View models match hbd_event_view_model().
 *
 * @return array<int,array>
 */
function hbd_placeholder_events() {
	$img      = HBD_THEME_URI . '/assets/images/';
	$defaults = array(
		array( 'Sunset Live Music Nights', 'Cozy evenings with live music, great food, and a vibrant waterfront atmosphere.', 'event-livemusic.png', 'Fridays, 6:00 PM – 8:00 PM', 'The Promenade' ),
		array( 'Weekend Artisan Market', 'Local crafts, street food, and live music every weekend by the water.', 'event-market.png', 'Sat–Sun, 10:00 AM – 5:00 PM', 'Harbour Bay Plaza' ),
		array( 'Fun for the Whole Family', 'Activities and entertainment for all ages across the district.', 'event-family.png', 'Daily, 10:00 AM – 7:00 PM', 'Bayfront Area' ),
		array( 'Seasonal Dining Specials', 'Limited-time menus and chef specials at waterfront restaurants.', 'event-dining.png', 'Sat–Sun, 10:00 AM – 5:00 PM', 'Harbour Bay Plaza' ),
	);

	$items = array();
	foreach ( $defaults as $d ) {
		$items[] = array(
			'id'           => 0,
			'title'        => $d[0],
			'permalink'    => '#',
			'image'        => $img . $d[2],
			'excerpt'      => $d[1],
			'date_raw'     => '',
			'date_display' => '',
			'time'         => $d[3],
			'location'     => $d[4],
			'map'          => '',
			'featured'     => true,
			'type'         => 'event',
			'type_name'    => __( 'Event', 'harbour-bay-downtown' ),
		);
	}
	return $items;
}

/**
 * Placeholder promotions shown until the client adds real ones, so the
 * "Special Promotions" sections never render empty.
 *
 * @return array<int,array>
 */
function hbd_placeholder_promotions() {
	$img      = HBD_THEME_URI . '/assets/images/';
	$defaults = array(
		array( 'Sunset Dining Offer', '1–30 April 2026', 'promo-dining.png' ),
		array( 'Weekend Surf Basics', '12–13 April 2026', 'promo-surf.png' ),
		array( 'Friday Soundwaves', 'Every Friday, 7 PM', 'promo-friday.png' ),
	);

	$items = array();
	foreach ( $defaults as $d ) {
		$items[] = array(
			'id'           => 0,
			'title'        => $d[0],
			'permalink'    => '#',
			'image'        => $img . $d[2],
			'excerpt'      => '',
			'date_raw'     => '',
			'date_display' => $d[1],
			'time'         => '',
			'location'     => '',
			'map'          => '',
			'featured'     => false,
			'type'         => 'promotion',
			'type_name'    => __( 'Promotion', 'harbour-bay-downtown' ),
		);
	}
	return $items;
}

/**
 * Resolve an item's call-to-action (external URL or downloadable file).
 *
 * @param int $id Item ID.
 * @return array{url:string,label:string,is_file:bool} Empty array when no link is set.
 */
function hbd_event_cta( $id ) {
	$label = (string) get_post_meta( $id, '_hbd_event_link_label', true );
	if ( '' === $label ) {
		$label = __( 'Find out more', 'harbour-bay-downtown' );
	}

	$url = (string) get_post_meta( $id, '_hbd_event_link_url', true );
	if ( $url ) {
		return array( 'url' => $url, 'label' => $label, 'is_file' => false );
	}

	$file_id = (int) get_post_meta( $id, '_hbd_event_link_file', true );
	if ( $file_id ) {
		$file_url = wp_get_attachment_url( $file_id );
		if ( $file_url ) {
			return array( 'url' => $file_url, 'label' => $label, 'is_file' => true );
		}
	}

	return array();
}

/**
 * Build a Google-map embed iframe from a free-text location query.
 * Uses the Maps Embed API when the Customizer key is set, else a keyless embed.
 * Shared by the Contact page and the event detail page.
 *
 * @param string $query Location query (address / place name).
 * @param string $title Iframe title attribute.
 * @return string Iframe HTML, or '' when no query.
 */
function hbd_map_embed( $query, $title = '' ) {
	$query = trim( (string) $query );
	if ( '' === $query ) {
		return '';
	}

	$key = get_theme_mod( 'hbd_contact_map_key', '' );
	if ( $key ) {
		$src = 'https://www.google.com/maps/embed/v1/place?key=' . rawurlencode( $key ) . '&q=' . rawurlencode( $query );
	} else {
		$src = 'https://maps.google.com/maps?q=' . rawurlencode( $query ) . '&z=15&output=embed';
	}

	return '<iframe src="' . esc_url( $src ) . '" title="' . esc_attr( $title ? $title : $query ) . '" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>';
}
