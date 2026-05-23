<?php
/**
 * Buildings — a custom post type for the Live & Work page. Each building is a
 * post with a title, featured image, and a few meta fields (pill, body, link,
 * and a list of amenities). The page loops them via hbd_get_buildings().
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the Building CPT.
 */
function hbd_register_buildings() {
	register_post_type(
		'hbd_building',
		array(
			'labels'             => array(
				'name'          => __( 'Buildings', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Building', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Buildings', 'harbour-bay-downtown' ),
				'add_new_item'  => __( 'Add New Building', 'harbour-bay-downtown' ),
				'edit_item'     => __( 'Edit Building', 'harbour-bay-downtown' ),
				'not_found'     => __( 'No buildings yet.', 'harbour-bay-downtown' ),
			),
			'public'             => false,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'publicly_queryable' => false,
			'has_archive'        => false,
			'rewrite'            => false,
			'menu_icon'          => 'dashicons-building',
			'menu_position'      => 26,
			'supports'           => array( 'title', 'thumbnail', 'page-attributes' ),
		)
	);
}
add_action( 'init', 'hbd_register_buildings' );

/**
 * The amenity icon set (name => inline SVG). Used in the building meta box hint
 * and when rendering amenity rows.
 *
 * @return array<string,string>
 */
function hbd_amenity_icons() {
	$attrs = 'xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"';
	return array(
		'building'   => '<svg ' . $attrs . '><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4M10 10h4M10 14h4M10 18h4"/></svg>',
		'walk'       => '<svg ' . $attrs . '><circle cx="13" cy="4" r="1"/><path d="m9 20 1.5-5.5L8 12l1-5 3 1 2 2 2 1"/><path d="m9 20-1 2M14.5 14.5 16 22"/></svg>',
		'map'        => '<svg ' . $attrs . '><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.62v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.38V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0zM15 5.764v15M9 3.236v15"/></svg>',
		'navigation' => '<svg ' . $attrs . '><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>',
		'briefcase'  => '<svg ' . $attrs . '><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>',
		'ship'       => '<svg ' . $attrs . '><path d="M12 10.189V14M12 2v3"/><path d="M19 13V7a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v6"/><path d="M19.38 20A11.6 11.6 0 0 0 21 14l-8.19-3.64a2 2 0 0 0-1.62 0L3 14a11.6 11.6 0 0 0 2.81 7.76"/><path d="M2 21c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1s1.2 1 2.5 1c2.5 0 2.5-2 5-2 1.3 0 1.9.5 2.5 1"/></svg>',
		// 20×20 / stroke-width 1.4 icons (district, hotel, pin, boat, footfall, calendar)
		// — used by the Magazine and Advertising pages.
		'district'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1.66602 16.6666H3.33268M3.33268 16.6666H12.4993M3.33268 16.6666V11.9734C3.33268 11.5356 3.33268 11.3166 3.38518 11.1124C3.43171 10.9314 3.50829 10.7598 3.61182 10.6042C3.72856 10.4288 3.89196 10.2819 4.21729 9.98967L6.13527 8.26656C6.76421 7.70152 7.07892 7.41878 7.43476 7.31152C7.74846 7.21696 8.08327 7.21696 8.39697 7.31152C8.75311 7.41887 9.06824 7.70175 9.69824 8.26774L11.6149 9.98967C11.9406 10.2823 12.1031 10.4287 12.2199 10.6042C12.3234 10.7598 12.3999 10.9314 12.4465 11.1124C12.499 11.3166 12.4993 11.5356 12.4993 11.9734V16.6666M12.4993 16.6666H16.666M16.666 16.6666H18.3327M16.666 16.6666V5.99734C16.666 5.06575 16.666 4.59925 16.4845 4.24308C16.3247 3.92948 16.0691 3.6747 15.7555 3.51491C15.399 3.33325 14.9329 3.33325 13.9995 3.33325H8.49951C7.56609 3.33325 7.09903 3.33325 6.74251 3.51491C6.42891 3.6747 6.17413 3.92948 6.01434 4.24308C5.83268 4.5996 5.83268 5.06666 5.83268 6.00008V8.33341" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'hotel'      => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M1.66602 16.6667H3.33268M3.33268 16.6667H11.666M3.33268 16.6667V5.16683C3.33268 4.23341 3.33268 3.76635 3.51434 3.40983C3.67413 3.09623 3.92891 2.84144 4.24251 2.68166C4.59903 2.5 5.06609 2.5 5.99951 2.5H8.99951C9.93293 2.5 10.399 2.5 10.7555 2.68166C11.0691 2.84144 11.3247 3.09623 11.4845 3.40983C11.666 3.766 11.666 4.2325 11.666 5.16409V10M11.666 16.6667H16.666M11.666 16.6667V10M16.666 16.6667H18.3327M16.666 16.6667V10C16.666 9.22343 16.6659 8.83534 16.5391 8.52905C16.3699 8.12067 16.0458 7.79602 15.6374 7.62687C15.3311 7.5 14.9424 7.5 14.1658 7.5C13.3892 7.5 13.0009 7.5 12.6947 7.62687C12.2863 7.79602 11.962 8.12067 11.7929 8.52905C11.666 8.83534 11.666 9.22343 11.666 10M5.83268 8.33333H9.16602M5.83268 5.83333H9.16602" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'pin'        => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M4.16602 8.26904C4.16602 12.3122 7.70308 15.6558 9.26867 16.9377C9.49274 17.1211 9.60611 17.214 9.77327 17.261C9.90344 17.2977 10.095 17.2977 10.2252 17.261C10.3927 17.2139 10.5052 17.122 10.7301 16.9378C12.2957 15.6559 15.8326 12.3126 15.8326 8.26941C15.8326 6.73932 15.2181 5.27171 14.1241 4.18977C13.0301 3.10783 11.5465 2.5 9.99942 2.5C8.45232 2.5 6.96852 3.10792 5.87456 4.18986C4.7806 5.2718 4.16602 6.73895 4.16602 8.26904Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.33268 7.5C8.33268 8.42047 9.07887 9.16667 9.99935 9.16667C10.9198 9.16667 11.666 8.42047 11.666 7.5C11.666 6.57953 10.9198 5.83333 9.99935 5.83333C9.07887 5.83333 8.33268 6.57953 8.33268 7.5Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'boat'       => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3.33398 15.4166C4.16732 15 5.83398 15 7.08398 15.4166C8.33398 15.8333 11.6673 15.8333 12.9173 15.4166C14.1673 14.9999 15.834 15 16.6673 15.4166" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><path d="M5.83299 15L3.99865 10.5058C3.85271 10.1483 3.97135 9.7368 4.31862 9.56782C5.70575 8.89283 8.19537 8.30396 9.36274 8.04989C9.78359 7.9583 10.2157 7.9583 10.6366 8.04989C11.8039 8.30396 14.2936 8.89283 15.6807 9.56782C16.028 9.7368 16.1466 10.1483 16.0007 10.5058L14.1663 15" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><path d="M5.41797 8.75V7.08333C5.41797 6.6231 5.79106 6.25 6.2513 6.25H13.7513C14.2115 6.25 14.5846 6.6231 14.5846 7.08333V8.75" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/><path d="M8.33398 5.83329V4.58329C8.33398 4.35317 8.52053 4.16663 8.75065 4.16663H11.2507C11.4808 4.16663 11.6673 4.35317 11.6673 4.58329V5.83329" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>',
		'footfall'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3.75 10.8333C5 8.12493 10.4167 5.83327 11.25 7.49994M11.25 7.49994C12.0833 9.16661 8.16666 15.5 5.41667 17.9166H7.08333M11.25 7.49994C11.6667 8.95828 15.4167 9.99996 16.6667 9.16663M9.1667 7.08329C6.66667 11.6666 8.54186 11.5363 10.0001 12.0833C11.4583 12.6303 12.9167 14.5833 12.9167 17.9166H14.5833M12.5 3.33326C12.5 4.25373 11.7538 4.99994 10.8333 4.99996C9.91282 4.99998 9.16665 4.2538 9.16667 3.33333C9.16669 2.41285 9.91289 1.66665 10.8334 1.66663C11.7538 1.66661 12.5 2.41278 12.5 3.33326Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
		'calendar'   => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 7.49988H16.3333M3 7.49988V14.8334C3 15.7668 3 16.2333 3.18166 16.5898C3.34144 16.9034 3.59623 17.1586 3.90983 17.3184C4.266 17.4999 4.73249 17.4999 5.66409 17.4999H13.6692C14.6008 17.4999 15.0667 17.4999 15.4228 17.3184C15.7364 17.1586 15.9921 16.9034 16.1519 16.5898C16.3333 16.2336 16.3333 15.7678 16.3333 14.8362V7.49988M3 7.49988V6.83337C3 5.89995 3 5.43289 3.18166 5.07638C3.34144 4.76277 3.59623 4.50799 3.90983 4.3482C4.26635 4.16654 4.73341 4.16654 5.66683 4.16654H6.33333M16.3333 7.49988V6.83064C16.3333 5.89904 16.3333 5.43255 16.1519 5.07638C15.9921 4.76277 15.7364 4.50799 15.4228 4.3482C15.0663 4.16654 14.6003 4.16654 13.6668 4.16654H13M13 2.49988V4.16654M13 4.16654H6.33333M6.33333 2.49988V4.16654" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>',
	);
}

/**
 * Get the SVG markup for an amenity icon by name (falls back to "building").
 *
 * @param string $name Icon name.
 * @return string Inline SVG.
 */
function hbd_amenity_icon_svg( $name ) {
	$icons = hbd_amenity_icons();
	$name  = $name && isset( $icons[ $name ] ) ? $name : 'building';
	return $icons[ $name ];
}

/**
 * Parse an amenities textarea ("icon: text" per line) into rows.
 *
 * @param string $text Raw textarea value.
 * @return array<int,array{icon:string,text:string}>
 */
function hbd_parse_amenities( $text ) {
	$rows  = array();
	$lines = preg_split( '/\R/', (string) $text );
	foreach ( $lines as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		if ( false !== strpos( $line, ':' ) ) {
			list( $icon, $label ) = explode( ':', $line, 2 );
			$rows[] = array( 'icon' => sanitize_key( trim( $icon ) ), 'text' => trim( $label ) );
		} else {
			$rows[] = array( 'icon' => 'building', 'text' => $line );
		}
	}
	return $rows;
}

/**
 * Echo the two-column amenities block.
 *
 * @param array<int,array{icon:string,text:string}> $amenities Amenity rows.
 */
function hbd_render_amenities( $amenities ) {
	if ( empty( $amenities ) ) {
		return;
	}
	$half = (int) ceil( count( $amenities ) / 2 );
	$cols = array( array_slice( $amenities, 0, $half ), array_slice( $amenities, $half ) );
	echo '<div class="lw-amenities">';
	foreach ( $cols as $col ) {
		if ( empty( $col ) ) {
			continue;
		}
		echo '<div class="lw-amenities__col">';
		foreach ( $col as $row ) {
			echo '<div class="lw-amenity">';
			echo '<span class="lw-amenity__icon" aria-hidden="true">' . hbd_amenity_icon_svg( $row['icon'] ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<span class="lw-amenity__text">' . esc_html( $row['text'] ) . '</span>';
			echo '</div>';
		}
		echo '</div>';
	}
	echo '</div>';
}

/**
 * Register the "Building details" meta box.
 */
function hbd_add_building_meta_box() {
	add_meta_box(
		'hbd_building_details',
		__( 'Building details', 'harbour-bay-downtown' ),
		'hbd_render_building_meta_box',
		'hbd_building',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'hbd_add_building_meta_box' );

/**
 * Render the meta box fields.
 *
 * @param WP_Post $post Current building.
 */
function hbd_render_building_meta_box( $post ) {
	wp_nonce_field( 'hbd_building_details', 'hbd_building_details_nonce' );

	$tag       = get_post_meta( $post->ID, '_hbd_building_tag', true );
	$body      = get_post_meta( $post->ID, '_hbd_building_body', true );
	$link      = get_post_meta( $post->ID, '_hbd_building_link', true );
	$amenities = get_post_meta( $post->ID, '_hbd_building_amenities', true );
	$icons     = implode( ', ', array_keys( hbd_amenity_icons() ) );
	?>
	<p>
		<label for="hbd_building_tag" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Pill label', 'harbour-bay-downtown' ); ?></label>
		<input type="text" id="hbd_building_tag" name="hbd_building_tag" value="<?php echo esc_attr( $tag ); ?>" class="widefat" placeholder="Office Space" />
	</p>
	<p>
		<label for="hbd_building_body" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Body text', 'harbour-bay-downtown' ); ?></label>
		<textarea id="hbd_building_body" name="hbd_building_body" rows="4" class="widefat"><?php echo esc_textarea( $body ); ?></textarea>
		<span class="description"><?php esc_html_e( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ); ?></span>
	</p>
	<p>
		<label for="hbd_building_link" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Link URL', 'harbour-bay-downtown' ); ?></label>
		<input type="url" id="hbd_building_link" name="hbd_building_link" value="<?php echo esc_attr( $link ); ?>" class="widefat" placeholder="https://" />
		<span class="description"><?php esc_html_e( 'Where the corner arrow links to. Leave empty to hide the arrow.', 'harbour-bay-downtown' ); ?></span>
	</p>
	<p>
		<label for="hbd_building_amenities" style="display:block;font-weight:600;margin-bottom:4px;"><?php esc_html_e( 'Amenities', 'harbour-bay-downtown' ); ?></label>
		<textarea id="hbd_building_amenities" name="hbd_building_amenities" rows="6" class="widefat" placeholder="building: Office spaces in a strategic business location&#10;walk: Walking distance to the ferry terminal"><?php echo esc_textarea( $amenities ); ?></textarea>
		<span class="description">
			<?php
			printf(
				/* translators: %s: comma-separated list of icon names. */
				esc_html__( 'One per line, as “icon: text”. Available icons: %s.', 'harbour-bay-downtown' ),
				esc_html( $icons )
			);
			?>
		</span>
	</p>
	<p class="description"><?php esc_html_e( 'The building image is the Featured Image. Order buildings with the Order field (Page Attributes).', 'harbour-bay-downtown' ); ?></p>
	<?php
}

/**
 * Save the meta box fields.
 *
 * @param int $post_id Building ID.
 */
function hbd_save_building_meta( $post_id ) {
	if ( ! isset( $_POST['hbd_building_details_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hbd_building_details_nonce'] ) ), 'hbd_building_details' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_hbd_building_tag', isset( $_POST['hbd_building_tag'] ) ? sanitize_text_field( wp_unslash( $_POST['hbd_building_tag'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_building_body', isset( $_POST['hbd_building_body'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hbd_building_body'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_building_link', isset( $_POST['hbd_building_link'] ) ? esc_url_raw( wp_unslash( $_POST['hbd_building_link'] ) ) : '' );
	update_post_meta( $post_id, '_hbd_building_amenities', isset( $_POST['hbd_building_amenities'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hbd_building_amenities'] ) ) : '' );
}
add_action( 'save_post_hbd_building', 'hbd_save_building_meta' );

/**
 * Fetch buildings as presentation-ready view models.
 *
 * @param int $limit Max items (-1 = all).
 * @return array<int,array{title:string,image:string,tag:string,body:string,link:string,amenities:array}>
 */
function hbd_get_buildings( $limit = -1 ) {
	$query = new WP_Query(
		array(
			'post_type'           => 'hbd_building',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'orderby'             => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	$items = array();
	foreach ( $query->posts as $post ) {
		$image = get_the_post_thumbnail_url( $post->ID, 'large' );
		if ( ! $image ) {
			$image = HBD_THEME_URI . '/assets/images/livework-building-1.png';
		}
		$items[] = array(
			'title'     => get_the_title( $post ),
			'image'     => $image,
			'tag'       => (string) get_post_meta( $post->ID, '_hbd_building_tag', true ),
			'body'      => (string) get_post_meta( $post->ID, '_hbd_building_body', true ),
			'link'      => (string) get_post_meta( $post->ID, '_hbd_building_link', true ),
			'amenities' => hbd_parse_amenities( (string) get_post_meta( $post->ID, '_hbd_building_amenities', true ) ),
		);
	}

	return $items;
}
