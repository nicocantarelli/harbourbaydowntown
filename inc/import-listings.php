<?php
/**
 * One-time WP-CLI importer that creates Listings from the Harbour Bay map data
 * (inc/data/hbd-venues.json, fished from harbourbaydowntown.com/map/).
 *
 *   wp hbd import-listings              # create everything, sideloading photos
 *   wp hbd import-listings --dry-run    # preview only, creates nothing
 *   wp hbd import-listings --no-photos  # skip photo downloads (faster)
 *   wp hbd import-listings --limit=5    # only the first 5 (for a test run)
 *   wp hbd import-listings --fresh      # delete ALL existing Listings first (clears
 *                                       # the seeded placeholders), then import.
 *                                       # Add --yes to skip the confirmation prompt.
 *
 * Idempotent: a venue whose exact title already exists as a Listing is skipped,
 * so it's safe to re-run. With --fresh the slate is wiped first.
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// CLI only — never load on web requests.
if ( ! ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	return;
}

/**
 * Assign a term to a post by the term's slug.
 *
 * @param int    $post_id  Post ID.
 * @param string $slug     Term slug.
 * @param string $taxonomy Taxonomy.
 */
function hbd_cli_set_term( $post_id, $slug, $taxonomy ) {
	$term = get_term_by( 'slug', $slug, $taxonomy );
	if ( $term && ! is_wp_error( $term ) ) {
		wp_set_object_terms( $post_id, array( (int) $term->term_id ), $taxonomy, false );
	} else {
		WP_CLI::warning( "Term not found: {$taxonomy}/{$slug}" );
	}
}

/**
 * `wp hbd import-listings` — create Listings from the bundled venue data.
 *
 * @param array $args       Positional args (unused).
 * @param array $assoc_args --dry-run, --no-photos, --limit=<n>.
 */
function hbd_cli_import_listings( $args, $assoc_args ) {
	$dry       = isset( $assoc_args['dry-run'] );
	$do_photos = ! isset( $assoc_args['no-photos'] );
	$limit     = isset( $assoc_args['limit'] ) ? (int) $assoc_args['limit'] : 0;
	$fresh     = isset( $assoc_args['fresh'] );

	$file = HBD_THEME_DIR . '/inc/data/hbd-venues.json';
	if ( ! file_exists( $file ) ) {
		WP_CLI::error( "Data file not found: {$file}" );
	}

	$venues = json_decode( (string) file_get_contents( $file ), true );
	if ( ! is_array( $venues ) ) {
		WP_CLI::error( 'Could not parse the venue data file.' );
	}
	if ( $limit > 0 ) {
		$venues = array_slice( $venues, 0, $limit );
	}

	// Optional clean slate — remove existing Listings (e.g. the seeded
	// placeholders) and their featured images before importing.
	if ( $fresh ) {
		$existing_ids = get_posts(
			array(
				'post_type'      => 'hbd_listing',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		if ( empty( $existing_ids ) ) {
			WP_CLI::log( 'No existing Listings to delete.' );
		} elseif ( $dry ) {
			WP_CLI::log( '[dry-run] Would delete ' . count( $existing_ids ) . ' existing Listing(s).' );
		} else {
			WP_CLI::confirm( 'Delete ' . count( $existing_ids ) . ' existing Listing(s) (and their featured images) before importing?', $assoc_args );
			foreach ( $existing_ids as $eid ) {
				$thumb = get_post_thumbnail_id( $eid );
				if ( $thumb ) {
					wp_delete_attachment( $thumb, true );
				}
				wp_delete_post( $eid, true );
			}
			WP_CLI::log( 'Deleted ' . count( $existing_ids ) . ' existing Listing(s).' );
		}
	}

	if ( $do_photos && ! $dry ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}

	global $wpdb;
	$created    = 0;
	$skipped    = 0;
	$photos     = 0;
	$photo_fail = 0;

	$progress = WP_CLI\Utils\make_progress_bar( ( $dry ? '[dry-run] ' : '' ) . 'Importing venues', count( $venues ) );

	foreach ( $venues as $v ) {
		$name = isset( $v['name'] ) ? trim( $v['name'] ) : '';
		if ( '' === $name ) {
			$progress->tick();
			continue;
		}

		$existing = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'hbd_listing' AND post_title = %s AND post_status <> 'trash' LIMIT 1",
				$name
			)
		);
		if ( $existing ) {
			++$skipped;
			$progress->tick();
			continue;
		}

		if ( $dry ) {
			WP_CLI::log( "  would create [{$v['type']}" . ( ! empty( $v['category'] ) ? "/{$v['category']}" : '' ) . "] {$name}" );
			++$created;
			$progress->tick();
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'   => 'hbd_listing',
				'post_status' => 'publish',
				'post_title'  => $name,
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			WP_CLI::warning( "Failed to create '{$name}': " . $post_id->get_error_message() );
			$progress->tick();
			continue;
		}

		hbd_cli_set_term( $post_id, $v['type'], 'listing_type' );
		if ( ! empty( $v['category'] ) ) {
			hbd_cli_set_term( $post_id, $v['category'], 'listing_category' );
		}

		$tags = ! empty( $v['tags'] ) && is_array( $v['tags'] ) ? implode( ', ', $v['tags'] ) : '';

		update_post_meta( $post_id, '_hbd_listing_pill', (string) ( $v['pill'] ?? '' ) );
		update_post_meta( $post_id, '_hbd_listing_tags', $tags );
		update_post_meta( $post_id, '_hbd_listing_description', (string) ( $v['description'] ?? '' ) );
		update_post_meta( $post_id, '_hbd_listing_hours', (string) ( $v['open_hours'] ?? '' ) );
		update_post_meta( $post_id, '_hbd_listing_location', (string) ( $v['location'] ?? '' ) );
		update_post_meta( $post_id, '_hbd_import_source', 'harbourbay-map' );

		if ( $do_photos && ! empty( $v['photo'] ) ) {
			$att = media_sideload_image( $v['photo'], $post_id, $name, 'id' );
			if ( is_wp_error( $att ) ) {
				++$photo_fail;
				WP_CLI::warning( "Photo failed for '{$name}': " . $att->get_error_message() );
			} else {
				set_post_thumbnail( $post_id, $att );
				++$photos;
			}
		}

		++$created;
		$progress->tick();
	}

	$progress->finish();

	WP_CLI::success(
		( $dry ? '[dry-run] ' : '' ) .
		"Created: {$created}, Skipped (already exist): {$skipped}, Photos set: {$photos}" .
		( $photo_fail ? ", Photo failures: {$photo_fail}" : '' )
	);
}

WP_CLI::add_command( 'hbd import-listings', 'hbd_cli_import_listings' );
