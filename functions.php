<?php
/**
 * Harbour Bay Downtown theme functions.
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HBD_THEME_VERSION', '0.1.0' );
define( 'HBD_THEME_DIR', get_stylesheet_directory() );
define( 'HBD_THEME_URI', get_stylesheet_directory_uri() );

// Customizer + hero image helper live here.
require_once HBD_THEME_DIR . '/inc/customizer.php';
// Map Pins admin page (drag-and-drop pin editor).
require_once HBD_THEME_DIR . '/inc/map-pins-admin.php';
// Explore Cards admin page (repeater for the homepage Explore carousel).
require_once HBD_THEME_DIR . '/inc/explore-cards-admin.php';
// Events & Promotions CPT (powers "What's On" + "Special Promotions" and gives
// each item a detail page). Replaces the old events-admin / promotions-admin pages.
require_once HBD_THEME_DIR . '/inc/events.php';
// Home Guides data layer (audience taxonomy + blog-driven cards).
require_once HBD_THEME_DIR . '/inc/guides-data.php';
// Listings CPT (Hotels / Restaurants / Shops / Wellness directory grids).
require_once HBD_THEME_DIR . '/inc/listings.php';
// Buildings CPT (Live & Work page — offices / residences).
require_once HBD_THEME_DIR . '/inc/buildings.php';
// Ferries CPT (ferry operators — International / Domestic route cards).
require_once HBD_THEME_DIR . '/inc/ferries.php';
// Lead-capture forms (Contact / Advertising / Sales & Leasing / Live & Work) —
// shared AJAX handler, email routing, and the Enquiries backup post type.
require_once HBD_THEME_DIR . '/inc/forms.php';
// Floating FAQ / chat widget (rendered site-wide via wp_footer).
require_once HBD_THEME_DIR . '/inc/faq-widget.php';
// One-time CLI importer for the Harbour Bay venue list (wp hbd import-listings).
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once HBD_THEME_DIR . '/inc/import-listings.php';
}

/**
 * Theme setup.
 */
function hbd_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo', array( 'flex-height' => true, 'flex-width' => true ) );

	load_theme_textdomain( 'harbour-bay-downtown', HBD_THEME_DIR . '/languages' );

	add_editor_style( 'build/editor.css' );
}
add_action( 'after_setup_theme', 'hbd_setup' );

/**
 * Read Vite manifest and resolve a built asset path.
 *
 * @param string $entry Source entry path (e.g. "src/scss/main.scss").
 * @return string|null  Built file URL or null if not found.
 */
function hbd_vite_asset( $entry ) {
	static $manifest = null;

	if ( null === $manifest ) {
		$manifest_path = HBD_THEME_DIR . '/build/.vite/manifest.json';
		$manifest      = file_exists( $manifest_path )
			? json_decode( (string) file_get_contents( $manifest_path ), true )
			: array();
	}

	if ( empty( $manifest[ $entry ]['file'] ) ) {
		return null;
	}

	return HBD_THEME_URI . '/build/' . $manifest[ $entry ]['file'];
}

/**
 * Enqueue frontend assets.
 */
function hbd_enqueue_assets() {
	$css = hbd_vite_asset( 'src/scss/main.scss' );
	$js  = hbd_vite_asset( 'src/js/main.js' );

	if ( $css ) {
		wp_enqueue_style( 'hbd-main', $css, array(), HBD_THEME_VERSION );
	}

	if ( $js ) {
		wp_enqueue_script( 'hbd-main', $js, array(), HBD_THEME_VERSION, true );

		// Endpoint + nonce for the enquiry forms (see inc/forms.php). Localized
		// here rather than in the form markup so page caching can't stale them.
		wp_localize_script(
			'hbd-main',
			'hbdForms',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'hbd_form' ),
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'hbd_enqueue_assets' );

/**
 * Enqueue editor assets (used when editing pages/posts in Gutenberg).
 */
function hbd_enqueue_editor_assets() {
	$css = hbd_vite_asset( 'src/scss/editor.scss' );

	if ( $css ) {
		wp_enqueue_style( 'hbd-editor', $css, array(), HBD_THEME_VERSION );
	}
}
add_action( 'enqueue_block_editor_assets', 'hbd_enqueue_editor_assets' );

/**
 * Register block pattern categories — patterns still appear in the Gutenberg
 * inserter so the client can drop sections into Pages if needed.
 */
function hbd_register_pattern_categories() {
	register_block_pattern_category(
		'harbour-bay-downtown',
		array(
			'label'       => __( 'Harbour Bay Downtown', 'harbour-bay-downtown' ),
			'description' => __( 'Custom patterns for the Harbour Bay Downtown theme.', 'harbour-bay-downtown' ),
		)
	);
}
add_action( 'init', 'hbd_register_pattern_categories' );

/**
 * Register custom block styles for Button and Group blocks used inside patterns.
 */
function hbd_register_block_styles() {
	register_block_style(
		'core/button',
		array(
			'name'  => 'pill-big',
			'label' => __( 'Pill Big', 'harbour-bay-downtown' ),
		)
	);

	register_block_style(
		'core/button',
		array(
			'name'  => 'pill-big-dark',
			'label' => __( 'Pill Big (Dark)', 'harbour-bay-downtown' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'rounded-card',
			'label' => __( 'Rounded Card', 'harbour-bay-downtown' ),
		)
	);

	register_block_style(
		'core/group',
		array(
			'name'  => 'dark-card',
			'label' => __( 'Dark Card', 'harbour-bay-downtown' ),
		)
	);
}
add_action( 'init', 'hbd_register_block_styles' );

/**
 * Preload the primary font so the 128px hero title avoids FOUT.
 */
function hbd_preload_font() {
	$href = HBD_THEME_URI . '/assets/fonts/questrial-regular.woff2';
	printf(
		'<link rel="preload" as="font" type="font/woff2" href="%s" crossorigin>' . "\n",
		esc_url( $href )
	);
}
add_action( 'wp_head', 'hbd_preload_font', 1 );

/**
 * Disable default block patterns from WordPress.org.
 */
remove_theme_support( 'core-block-patterns' );

/**
 * Disable WordPress's automatic downscaling of large image uploads.
 * Default behavior: any image wider than 2560px gets a `-scaled` copy and the
 * "full" size becomes that scaled copy. On Retina displays the hero needs the
 * original pixels — this filter keeps every upload at its native resolution.
 */
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Maximum image quality (the "master" setting) — overrides WordPress's default
 * JPEG quality of 82. Applied to both jpeg_quality (legacy) and
 * wp_editor_set_quality (modern image editor pipeline). Affects newly
 * generated thumbnails AND any re-encoding of the uploaded original.
 *
 * Note: existing uploads keep their old compression — re-upload (or run a
 * Regenerate Thumbnails plugin) to apply this to images already in the
 * media library.
 */
add_filter( 'jpeg_quality', function () { return 100; } );
add_filter( 'wp_editor_set_quality', function () { return 100; } );

/**
 * Helper: resolve a hero image URL — back-compat wrapper around the new
 * Customizer-aware resolver. Existing pattern code calls this function name.
 *
 * @param string $option_key   Theme_mod key (also matched against the legacy option).
 * @param string $fallback_png Filename inside assets/images/.
 * @return string Image URL.
 */
function hbd_hero_image_url( $option_key, $fallback_png ) {
	return hbd_resolve_hero_image( $option_key, $fallback_png );
}

/**
 * Render a section template by slug from /patterns/. The pattern file emits block
 * markup; we capture it and run it through do_blocks() so blocks render as HTML.
 *
 * Used by the secondary-page templates (page-about.php, etc.) to assemble shared
 * and page-specific sections. Mirrors the local helper in front-page.php so the
 * working homepage is left untouched.
 *
 * @param string $relative_path Path under /patterns/ (no extension).
 */
function hbd_render_section( $relative_path ) {
	$file = get_template_directory() . '/patterns/' . $relative_path . '.php';
	if ( ! file_exists( $file ) ) {
		return;
	}
	ob_start();
	include $file;
	echo do_blocks( ob_get_clean() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Truncate text to a maximum length on a word boundary, appending an ellipsis.
 * Used for card descriptions so any content (including future dynamic content)
 * cuts cleanly at whole words instead of relying on width-dependent CSS.
 *
 * @param string $text      The text to truncate.
 * @param int    $max_chars Maximum length before truncating.
 * @return string Truncated text with a trailing ellipsis, or the original if short enough.
 */
function hbd_truncate_text( $text, $max_chars = 75 ) {
	$text = trim( wp_strip_all_tags( $text ) );
	if ( mb_strlen( $text ) <= $max_chars ) {
		return $text;
	}
	$truncated  = mb_substr( $text, 0, $max_chars );
	$last_space = mb_strrpos( $truncated, ' ' );
	if ( false !== $last_space ) {
		$truncated = mb_substr( $truncated, 0, $last_space );
	}
	return rtrim( $truncated, " ,.;:!?-" ) . '…';
}

// ============================================================================
// CLASSIC NAVIGATION MENUS
// ============================================================================

/**
 * Register classic menu locations. Calling this also re-exposes the classic
 * "Menus" admin page (Appearance → Menus) which block themes hide by default.
 */
function hbd_register_menus() {
	register_nav_menus(
		array(
			'header'             => __( 'Header navigation', 'harbour-bay-downtown' ),
			'footer_explore'     => __( 'Footer: Explore', 'harbour-bay-downtown' ),
			'footer_quick_links' => __( 'Footer: Quick Links', 'harbour-bay-downtown' ),
			'footer_others'      => __( 'Footer: Others', 'harbour-bay-downtown' ),
		)
	);
}
add_action( 'after_setup_theme', 'hbd_register_menus' );

/**
 * Minimal walker — emits `<li class="hbd-menu__item"><a class="hbd-menu__link" href="…">Label</a></li>`
 * with no WordPress noise.
 */
class HBD_Menu_Walker extends Walker_Nav_Menu {
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '<ul class="hbd-menu__submenu">';
	}
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		$output .= '</ul>';
	}
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes    = array( 'hbd-menu__item' );
		$wp_classes = empty( $item->classes ) ? array() : (array) $item->classes;
		if ( in_array( 'menu-item-has-children', $wp_classes, true ) ) {
			$classes[] = 'hbd-menu__item--has-children';
		}

		// Flag the current page — and any parent/ancestor of it — so the navbar
		// can show which tab is active (WordPress sets these context classes when
		// it builds the menu; our walker would otherwise discard them).
		$current_classes = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor', 'current_page_item', 'current_page_parent', 'current_page_ancestor' );
		if ( array_intersect( $current_classes, $wp_classes ) ) {
			$classes[] = 'hbd-menu__item--active';
		}

		// Mark only the exact current item for assistive tech.
		$is_exact = in_array( 'current-menu-item', $wp_classes, true ) || in_array( 'current_page_item', $wp_classes, true );
		$aria     = $is_exact ? ' aria-current="page"' : '';

		$output .= '<li class="' . esc_attr( implode( ' ', $classes ) ) . '">';
		$output .= '<a class="hbd-menu__link" href="' . esc_url( $item->url ) . '"' . $aria . '>' . esc_html( $item->title ) . '</a>';
	}
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '</li>';
	}
}

/**
 * [hbd_menu location="header"] — render the classic menu assigned to a theme
 * location.
 *
 * @param array $atts Shortcode attributes.
 * @return string Rendered HTML or empty string if no menu is assigned.
 */
function hbd_render_menu_shortcode( $atts ) {
	$atts     = shortcode_atts( array( 'location' => 'header' ), $atts );
	$location = sanitize_key( $atts['location'] );
	$modifier = str_replace( '_', '-', $location );

	$output = wp_nav_menu(
		array(
			'theme_location' => $location,
			'echo'           => false,
			'container'      => false,
			'items_wrap'     => '<ul class="hbd-menu hbd-menu--' . esc_attr( $modifier ) . '">%3$s</ul>',
			'walker'         => new HBD_Menu_Walker(),
			'fallback_cb'    => '__return_empty_string',
		)
	);

	return $output ? $output : '';
}
add_shortcode( 'hbd_menu', 'hbd_render_menu_shortcode' );
