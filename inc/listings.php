<?php
/**
 * Listings — a single custom post type that powers the directory grids on the
 * secondary pages (Hotels, Restaurants, Shops, and the future Wellness page).
 *
 * Each listing has a title, a featured image, a "Type" (Restaurants / Hotels /
 * Shops / Wellness), and two custom fields: a pill label and an outbound link.
 * Section grids query by type via hbd_get_listings().
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Listing CPT + the listing_type taxonomy.
 */
function hbd_register_listings() {
	register_post_type(
		'hbd_listing',
		array(
			'labels'              => array(
				'name'               => __( 'Listings', 'harbour-bay-downtown' ),
				'singular_name'      => __( 'Listing', 'harbour-bay-downtown' ),
				'menu_name'          => __( 'Listings', 'harbour-bay-downtown' ),
				'add_new_item'       => __( 'Add New Listing', 'harbour-bay-downtown' ),
				'edit_item'          => __( 'Edit Listing', 'harbour-bay-downtown' ),
				'new_item'           => __( 'New Listing', 'harbour-bay-downtown' ),
				'search_items'       => __( 'Search Listings', 'harbour-bay-downtown' ),
				'not_found'          => __( 'No listings found.', 'harbour-bay-downtown' ),
			),
			'public'              => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'publicly_queryable'  => true,
			'has_archive'         => false,
			'rewrite'             => array( 'slug' => 'listings', 'with_front' => false ),
			'menu_icon'           => 'dashicons-store',
			'menu_position'       => 25,
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);

	register_taxonomy(
		'listing_type',
		'hbd_listing',
		array(
			'labels'            => array(
				'name'          => __( 'Types', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Type', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Types', 'harbour-bay-downtown' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
		)
	);

	// Sub-category taxonomy — powers the Dine/Shop category tabs and the
	// Nightlife "Bars & Lounges" / "Live Music" split.
	register_taxonomy(
		'listing_category',
		'hbd_listing',
		array(
			'labels'            => array(
				'name'          => __( 'Categories', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Category', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Categories', 'harbour-bay-downtown' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
		)
	);

	hbd_seed_listing_types();
	hbd_seed_listing_categories();
}
add_action( 'init', 'hbd_register_listings' );

/**
 * Seed the Nightlife listing type + the default sub-categories once. Guarded by
 * its own flag so it runs on installs that were seeded before these existed.
 */
function hbd_seed_listing_categories() {
	if ( get_option( 'hbd_listing_cats_seeded_v2' ) ) {
		return;
	}

	if ( ! term_exists( 'nightlife', 'listing_type' ) ) {
		wp_insert_term( 'Nightlife', 'listing_type', array( 'slug' => 'nightlife' ) );
	}

	// Order matters — terms display in creation order (see hbd_get_listing_tabs()).
	$cats = array(
		'breakfast-coffee'  => 'Breakfast & Coffee',
		'lunch-casual'      => 'Lunch & Casual Meals',
		'dinner-by-the-sea' => 'Dinner by the Sea',
		'late-night-eats'   => 'Late-Night Eats',
		'fashion-lifestyle' => 'Fashion & Lifestyle',
		'gifts-souvenirs'   => 'Gifts & Souvenirs',
		'daily-essentials'  => 'Daily Essentials',
		'electronics-sim'   => 'Electronics & SIM',
		'bars-lounges'      => 'Bars & Lounges',
		'live-music'        => 'Live Music',
		'spa-massage'       => 'Spa & Massage',
		'beauty-grooming'   => 'Beauty & Grooming',
	);
	foreach ( $cats as $slug => $name ) {
		if ( ! term_exists( $slug, 'listing_category' ) ) {
			wp_insert_term( $name, 'listing_category', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_listing_cats_seeded_v2', 1 );
}

/**
 * Flush rewrite rules once so the /listings/<slug> detail-page URLs resolve.
 */
function hbd_listings_maybe_flush_rewrites() {
	if ( get_option( 'hbd_listings_rewrites_flushed' ) ) {
		return;
	}
	flush_rewrite_rules();
	update_option( 'hbd_listings_rewrites_flushed', 1 );
}
add_action( 'init', 'hbd_listings_maybe_flush_rewrites', 99 );

/**
 * Seed the four default listing types once (guarded by an option flag).
 */
function hbd_seed_listing_types() {
	if ( get_option( 'hbd_listing_types_seeded' ) ) {
		return;
	}

	$defaults = array(
		'restaurants' => 'Restaurants',
		'hotels'      => 'Hotels',
		'shops'       => 'Shops',
		'wellness'    => 'Wellness',
	);

	foreach ( $defaults as $slug => $name ) {
		if ( ! term_exists( $slug, 'listing_type' ) ) {
			wp_insert_term( $name, 'listing_type', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_listing_types_seeded', 1 );
}

/**
 * Register the "Listing details" meta box (pill text + outbound link).
 */
function hbd_add_listing_meta_box() {
	add_meta_box(
		'hbd_listing_details',
		__( 'Listing details', 'harbour-bay-downtown' ),
		'hbd_render_listing_meta_box',
		'hbd_listing',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'hbd_add_listing_meta_box' );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post Current listing.
 */
function hbd_render_listing_meta_box( $post ) {
	wp_nonce_field( 'hbd_listing_details', 'hbd_listing_details_nonce' );

	$pill        = get_post_meta( $post->ID, '_hbd_listing_pill', true );
	$tags        = get_post_meta( $post->ID, '_hbd_listing_tags', true );
	$cta         = get_post_meta( $post->ID, '_hbd_listing_cta_label', true );
	$link        = get_post_meta( $post->ID, '_hbd_listing_link', true );
	$link_direct = get_post_meta( $post->ID, '_hbd_listing_link_direct', true );
	$description = get_post_meta( $post->ID, '_hbd_listing_description', true );
	$location    = get_post_meta( $post->ID, '_hbd_listing_location', true );
	$map         = get_post_meta( $post->ID, '_hbd_listing_map', true );
	$hours       = get_post_meta( $post->ID, '_hbd_listing_hours', true );
	$phone       = get_post_meta( $post->ID, '_hbd_listing_phone', true );
	?>
	<style>.hbd-meta p{margin:0 0 16px;} .hbd-meta label{display:block;font-weight:600;margin-bottom:4px;} .hbd-meta label.hbd-inline{display:inline;font-weight:600;}</style>
	<div class="hbd-meta">
		<p>
			<label for="hbd_listing_pill"><?php esc_html_e( 'Pill text', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_listing_pill" name="hbd_listing_pill" value="<?php echo esc_attr( $pill ); ?>" class="widefat" />
			<span class="description"><?php esc_html_e( 'Small label on the card, e.g. "Waterfront" or "5 min from terminal".', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_tags"><?php esc_html_e( 'Feature tags', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_listing_tags" name="hbd_listing_tags" value="<?php echo esc_attr( $tags ); ?>" class="widefat" placeholder="Massage, Facial, Body treatments" />
			<span class="description"><?php esc_html_e( 'Comma-separated. Shown on the Wellness "Spa & Massage" cards.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_cta"><?php esc_html_e( 'Card button label', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_listing_cta" name="hbd_listing_cta" value="<?php echo esc_attr( $cta ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Find out more', 'harbour-bay-downtown' ); ?>" />
			<span class="description"><?php esc_html_e( 'Text on the card button (Dine/Shop category cards). Defaults to "Find out more".', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_description"><?php esc_html_e( 'Description', 'harbour-bay-downtown' ); ?></label>
			<textarea id="hbd_listing_description" name="hbd_listing_description" rows="4" class="widefat"><?php echo esc_textarea( $description ); ?></textarea>
			<span class="description"><?php esc_html_e( 'Shown on the listing\'s detail page. Leave a blank line between paragraphs.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_location"><?php esc_html_e( 'Location', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_listing_location" name="hbd_listing_location" value="<?php echo esc_attr( $location ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'e.g. Harbour Bay, Batam', 'harbour-bay-downtown' ); ?>" />
			<span class="description"><?php esc_html_e( 'The location name shown on the detail page.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_map"><?php esc_html_e( 'Map address / coordinates', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_listing_map" name="hbd_listing_map" value="<?php echo esc_attr( $map ); ?>" class="widefat" placeholder="<?php esc_attr_e( 'Full address, or latitude,longitude (e.g. 1.1305, 104.0530)', 'harbour-bay-downtown' ); ?>" />
			<span class="description"><?php esc_html_e( 'For an exact map pin. A full street address or "lat,long" works best. Falls back to the Location text if empty.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_hours"><?php esc_html_e( 'Open hours', 'harbour-bay-downtown' ); ?></label>
			<textarea id="hbd_listing_hours" name="hbd_listing_hours" rows="3" class="widefat" placeholder="<?php esc_attr_e( "Mon–Fri: 9am–9pm\nSat–Sun: 10am–10pm", 'harbour-bay-downtown' ); ?>"><?php echo esc_textarea( $hours ); ?></textarea>
			<span class="description"><?php esc_html_e( 'One line per row.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label for="hbd_listing_phone"><?php esc_html_e( 'Phone', 'harbour-bay-downtown' ); ?></label>
			<input type="text" id="hbd_listing_phone" name="hbd_listing_phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" placeholder="+62 ..." />
		</p>
		<p>
			<label for="hbd_listing_link"><?php esc_html_e( 'External link (website)', 'harbour-bay-downtown' ); ?></label>
			<input type="url" id="hbd_listing_link" name="hbd_listing_link" value="<?php echo esc_attr( $link ); ?>" class="widefat" placeholder="https://" />
			<span class="description"><?php esc_html_e( 'Optional. Shown as a "Visit website" button on the detail page.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p>
			<label class="hbd-inline" for="hbd_listing_link_direct"><input type="checkbox" id="hbd_listing_link_direct" name="hbd_listing_link_direct" value="1" <?php checked( $link_direct, '1' ); ?> /> <?php esc_html_e( 'Open the website directly from the card', 'harbour-bay-downtown' ); ?></label>
			<span class="description" style="display:block;"><?php esc_html_e( 'When checked, clicking the card opens the website instead of the on-site detail page. Needs an External link above.', 'harbour-bay-downtown' ); ?></span>
		</p>
		<p class="description"><?php esc_html_e( 'The card image is the Featured Image. The Type (Restaurants / Hotels / Shops / Wellness) controls which page grid the listing appears in.', 'harbour-bay-downtown' ); ?></p>
	</div>
	<?php
}

/**
 * Save the meta box fields.
 *
 * @param int $post_id Listing ID.
 */
function hbd_save_listing_meta( $post_id ) {
	if ( ! isset( $_POST['hbd_listing_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hbd_listing_details_nonce'] ) ), 'hbd_listing_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$pill = isset( $_POST['hbd_listing_pill'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_listing_pill'] ) ) : '';
	$link = isset( $_POST['hbd_listing_link'] ) ? esc_url_raw( wp_unslash( $_POST['hbd_listing_link'] ) ) : '';

	update_post_meta( $post_id, '_hbd_listing_pill', $pill );
	update_post_meta( $post_id, '_hbd_listing_tags', isset( $_POST['hbd_listing_tags'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_listing_tags'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_listing_cta_label', isset( $_POST['hbd_listing_cta'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_listing_cta'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_listing_link', $link );
	update_post_meta( $post_id, '_hbd_listing_link_direct', isset( $_POST['hbd_listing_link_direct'] ) ? '1' : '' );
	update_post_meta( $post_id, '_hbd_listing_description', isset( $_POST['hbd_listing_description'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hbd_listing_description'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_listing_location', isset( $_POST['hbd_listing_location'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_listing_location'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_listing_map', isset( $_POST['hbd_listing_map'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_listing_map'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_listing_hours', isset( $_POST['hbd_listing_hours'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hbd_listing_hours'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_listing_phone', isset( $_POST['hbd_listing_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_listing_phone'] ) ) : '' );
}
add_action( 'save_post_hbd_listing', 'hbd_save_listing_meta' );

/**
 * Fetch listings of a given type as presentation-ready view models.
 *
 * @param string $type_slug     Term slug: restaurants | hotels | shops | wellness | nightlife.
 * @param int    $limit         Max items (-1 = all).
 * @param string $category_slug Optional listing_category sub-category slug to filter by.
 * @return array<int,array{title:string,pill:string,link:string,is_external:bool,image:string,description:string}>
 */
function hbd_get_listings( $type_slug, $limit = -1, $category_slug = '' ) {
	$tax_query = array(
		array(
			'taxonomy' => 'listing_type',
			'field'    => 'slug',
			'terms'    => $type_slug,
		),
	);

	if ( $category_slug ) {
		$tax_query['relation'] = 'AND';
		$tax_query[]           = array(
			'taxonomy' => 'listing_category',
			'field'    => 'slug',
			'terms'    => $category_slug,
		);
	}

	$query = new WP_Query(
		array(
			'post_type'           => 'hbd_listing',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'orderby'             => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => $tax_query, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		)
	);

	$items = array();
	foreach ( $query->posts as $post ) {
		$image = get_the_post_thumbnail_url( $post->ID, 'large' );
		if ( ! $image ) {
			$image = HBD_THEME_URI . '/assets/images/card-shop.png';
		}

		$external = (string) get_post_meta( $post->ID, '_hbd_listing_link', true );
		$direct   = '1' === (string) get_post_meta( $post->ID, '_hbd_listing_link_direct', true );

		// If the listing has a website AND is set to open it directly, the card
		// links straight out; otherwise the card opens the on-site detail page
		// (where the website appears as a "Visit website" button).
		if ( $external && $direct ) {
			$link        = $external;
			$is_external = true;
		} else {
			$link        = get_permalink( $post->ID );
			$is_external = false;
		}

		$tags_raw  = (string) get_post_meta( $post->ID, '_hbd_listing_tags', true );
		$cta_label = (string) get_post_meta( $post->ID, '_hbd_listing_cta_label', true );

		$items[] = array(
			'title'       => get_the_title( $post ),
			'pill'        => (string) get_post_meta( $post->ID, '_hbd_listing_pill', true ),
			'tags'        => array_values( array_filter( array_map( 'trim', explode( ',', $tags_raw ) ), 'strlen' ) ),
			'cta_label'   => '' !== $cta_label ? $cta_label : __( 'Find out more', 'harbour-bay-downtown' ),
			'link'        => $link,
			'is_external' => $is_external,
			'image'       => $image,
			'location'    => (string) get_post_meta( $post->ID, '_hbd_listing_location', true ),
			'description' => (string) get_post_meta( $post->ID, '_hbd_listing_description', true ),
		);
	}

	return $items;
}

/**
 * Build the category tabs for a listing type: each sub-category that actually
 * has listings of that type becomes a tab with its cards. Terms are returned in
 * creation order so the seeded sub-categories keep their intended order.
 *
 * @param string $type_slug Listing type slug.
 * @return array<int,array{term:WP_Term,cards:array}>
 */
function hbd_get_listing_tabs( $type_slug ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'listing_category',
			'hide_empty' => false,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return array();
	}

	$tabs = array();
	foreach ( $terms as $term ) {
		$cards = hbd_get_listings( $type_slug, -1, $term->slug );
		if ( ! empty( $cards ) ) {
			$tabs[] = array(
				'term'  => $term,
				'cards' => $cards,
			);
		}
	}

	return $tabs;
}
