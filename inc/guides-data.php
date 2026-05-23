<?php
/**
 * Home Guides data layer — the `audience` taxonomy, the reading-time helper,
 * and the data provider that powers the homepage Guides section
 * (patterns/home-guides.php).
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the `audience` taxonomy on posts, then seed default terms.
 */
function hbd_register_audience_taxonomy() {
	register_taxonomy(
		'audience',
		'post',
		array(
			'labels'            => array(
				'name'          => __( 'Audiences', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Audience', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Audiences', 'harbour-bay-downtown' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'audience' ),
		)
	);

	hbd_seed_default_audiences();
}
add_action( 'init', 'hbd_register_audience_taxonomy' );

/**
 * Create the three default audience terms once (guarded by an option flag so it
 * does not run on every request).
 */
function hbd_seed_default_audiences() {
	if ( get_option( 'hbd_audiences_seeded' ) ) {
		return;
	}

	$defaults = array(
		'first-time-visitor' => 'First-Time Visitor',
		'business-traveler'  => 'Business Traveler',
		'weekend-getaway'    => 'Weekend Getaway',
	);

	foreach ( $defaults as $slug => $name ) {
		if ( ! term_exists( $slug, 'audience' ) ) {
			wp_insert_term( $name, 'audience', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_audiences_seeded', 1 );
}

/**
 * Estimate reading time in minutes for a post (~200 words per minute).
 *
 * @param int|WP_Post $post Post ID or object.
 * @return int Minutes, minimum 1.
 */
function hbd_reading_time( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return 1;
	}

	$word_count = str_word_count( wp_strip_all_tags( $post->post_content ) );

	return max( 1, (int) ceil( $word_count / 200 ) );
}

/**
 * Build a presentation-ready view model for one guide post.
 *
 * @param WP_Post $post Post object.
 * @return array{title:string,permalink:string,excerpt:string,date:string,category:string,read_time:string,image:string}
 */
function hbd_guides_post_view_model( $post ) {
	$categories = get_the_category( $post->ID );
	$category   = ! empty( $categories ) ? $categories[0]->name : '';

	$image = get_the_post_thumbnail_url( $post->ID, 'large' );
	if ( ! $image ) {
		$image = get_template_directory_uri() . '/assets/images/guide-firstday.png';
	}

	$minutes   = hbd_reading_time( $post );
	$read_time = sprintf(
		/* translators: %d: number of minutes to read. */
		__( '%d min read', 'harbour-bay-downtown' ),
		$minutes
	);

	return array(
		'title'     => get_the_title( $post ),
		'permalink' => get_permalink( $post ),
		'excerpt'   => hbd_truncate_text( wp_strip_all_tags( get_the_excerpt( $post ) ), 80 ),
		'date'      => get_the_date( 'j F Y', $post ),
		'category'  => $category,
		'read_time' => $read_time,
		'image'     => $image,
	);
}

/**
 * Gather homepage Guides data grouped by audience term.
 *
 * Only audiences with at least one published post are returned. For each, the
 * newest post is the feature card and the next two (if any) are compact cards.
 *
 * @return array<string,array{term:WP_Term,feature:array,cards:array}>
 */
function hbd_get_guides_data() {
	$audiences = get_terms(
		array(
			'taxonomy'   => 'audience',
			'hide_empty' => true,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $audiences ) || empty( $audiences ) ) {
		return array();
	}

	$data = array();

	foreach ( $audiences as $term ) {
		$query = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => 3,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'tax_query'           => array(
					array(
						'taxonomy' => 'audience',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					),
				),
			)
		);

		if ( empty( $query->posts ) ) {
			continue;
		}

		$views = array_map( 'hbd_guides_post_view_model', $query->posts );

		$data[ $term->slug ] = array(
			'term'    => $term,
			'feature' => $views[0],
			'cards'   => array_slice( $views, 1 ),
		);
	}

	return $data;
}

/**
 * Register the `guide_section` taxonomy on posts — places a post into a
 * secondary page's Guides carousel (Stay / Dine / Shop / Nightlife / Wellness).
 * Separate from `audience`, which powers the homepage Guides tabs.
 */
function hbd_register_guide_section_taxonomy() {
	register_taxonomy(
		'guide_section',
		'post',
		array(
			'labels'            => array(
				'name'          => __( 'Guide Sections', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Guide Section', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Guide Sections', 'harbour-bay-downtown' ),
			),
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'hierarchical'      => true,
		)
	);

	hbd_seed_guide_sections();
}
add_action( 'init', 'hbd_register_guide_section_taxonomy' );

/**
 * Seed the default guide-section terms once (guarded by an option flag).
 */
function hbd_seed_guide_sections() {
	if ( get_option( 'hbd_guide_sections_seeded' ) ) {
		return;
	}

	$defaults = array(
		'stay'      => 'Stay',
		'dine'      => 'Dine',
		'shop'      => 'Shop',
		'nightlife' => 'Nightlife',
		'wellness'  => 'Wellness',
		'travel'    => 'Travel',
	);

	foreach ( $defaults as $slug => $name ) {
		if ( ! term_exists( $slug, 'guide_section' ) ) {
			wp_insert_term( $name, 'guide_section', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_guide_sections_seeded', 1 );
}

/**
 * Top-up — adds the "Travel" guide section to sites seeded before it existed.
 * Runs once (guarded), independent of the main guide-section seeder above.
 */
function hbd_seed_guide_section_travel() {
	if ( get_option( 'hbd_guide_section_travel_seeded' ) ) {
		return;
	}
	if ( ! term_exists( 'travel', 'guide_section' ) ) {
		wp_insert_term( 'Travel', 'guide_section', array( 'slug' => 'travel' ) );
	}
	update_option( 'hbd_guide_section_travel_seeded', 1 );
}
add_action( 'init', 'hbd_seed_guide_section_travel', 11 );

/**
 * Fetch guide posts for a secondary-page section as view models.
 *
 * @param string $section_slug The guide_section term slug.
 * @param int    $limit        Max posts to return.
 * @return array<int,array> List of hbd_guides_post_view_model() results.
 */
function hbd_get_section_guides( $section_slug, $limit = 12 ) {
	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'orderby'             => 'date',
			'order'               => 'DESC',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'tax_query'           => array(
				array(
					'taxonomy' => 'guide_section',
					'field'    => 'slug',
					'terms'    => $section_slug,
				),
			),
		)
	);

	return array_map( 'hbd_guides_post_view_model', $query->posts );
}
