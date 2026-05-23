<?php
/**
 * Customizer settings — site-wide options for the Harbour Bay Downtown theme.
 *
 * Settings are grouped into top-level Customizer panels (WordPress doesn't
 * support panels nested inside panels, so each group is its own top-level panel):
 *   - Homepage   — Hero, Map & Highlights, Explore, Guides, Events, Promotions
 *   - About Page — the four "About — …" sections
 *   - Site-wide  — FAQ / Chat widget, Footer
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer panel, sections, settings, and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function hbd_customize_register( $wp_customize ) {

	// Top-level panels — one per content area. (WordPress can't nest a panel
	// inside another panel, so these sit at the Customizer root rather than under
	// a single "Theme Options" parent.)
	$wp_customize->add_panel(
		'hbd_panel_homepage',
		array(
			'title'    => __( 'Homepage', 'harbour-bay-downtown' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_about',
		array(
			'title'    => __( 'About Page', 'harbour-bay-downtown' ),
			'priority' => 31,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_nightlife',
		array(
			'title'    => __( 'Nightlife Page', 'harbour-bay-downtown' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_stay',
		array(
			'title'    => __( 'Stay Page', 'harbour-bay-downtown' ),
			'priority' => 33,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_dine',
		array(
			'title'    => __( 'Dine Page', 'harbour-bay-downtown' ),
			'priority' => 34,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_shop',
		array(
			'title'    => __( 'Shop Page', 'harbour-bay-downtown' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_wellness',
		array(
			'title'    => __( 'Wellness & Spa Page', 'harbour-bay-downtown' ),
			'priority' => 36,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_whatson',
		array(
			'title'    => __( "What's On Page", 'harbour-bay-downtown' ),
			'priority' => 37,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_ferries',
		array(
			'title'    => __( 'Ferries Page', 'harbour-bay-downtown' ),
			'priority' => 38,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_ksquare',
		array(
			'title'    => __( 'K Square Mall Page', 'harbour-bay-downtown' ),
			'priority' => 39,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_livework',
		array(
			'title'    => __( 'Live & Work Page', 'harbour-bay-downtown' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_map',
		array(
			'title'    => __( 'Map Page', 'harbour-bay-downtown' ),
			'priority' => 41,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_magazine',
		array(
			'title'    => __( 'Magazine Page', 'harbour-bay-downtown' ),
			'priority' => 42,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_contact',
		array(
			'title'    => __( 'Contact Page', 'harbour-bay-downtown' ),
			'priority' => 43,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_advertising',
		array(
			'title'    => __( 'Advertising Page', 'harbour-bay-downtown' ),
			'priority' => 44,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_sales',
		array(
			'title'    => __( 'Sales & Leasing Page', 'harbour-bay-downtown' ),
			'priority' => 45,
		)
	);

	$wp_customize->add_panel(
		'hbd_panel_global',
		array(
			'title'    => __( 'Site-wide', 'harbour-bay-downtown' ),
			'priority' => 46,
		)
	);

	// -------------------------------------------------------------------------
	// Section: Hero — heading, tagline, CTA, and the two stacked images.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_hero',
		array(
			'title'       => __( 'Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_homepage',
			'description' => __( 'The big homepage hero — heading, tagline, call-to-action button, and the two stacked images that sandwich the title.', 'harbour-bay-downtown' ),
			'priority'    => 10,
		)
	);

	// --- Heading -------------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_hero_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Harbour Bay\nDowntown",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_hero_heading',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_hero',
			'type'        => 'textarea',
		)
	);

	// --- Tagline -------------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_hero_tagline',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Stay. Dine. Stroll. Relax.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_hero_tagline',
		array(
			'label'       => __( 'Tagline', 'harbour-bay-downtown' ),
			'description' => __( 'Short line shown next to the decorative dash in the upper-right of the hero.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_hero',
			'type'        => 'text',
		)
	);

	// --- CTA label + URL ----------------------------------------------------
	$wp_customize->add_setting(
		'hbd_hero_cta_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Explore',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_hero_cta_label',
		array(
			'label'   => __( 'Button label', 'harbour-bay-downtown' ),
			'section' => 'hbd_hero',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_hero_cta_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '#explore',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_hero_cta_url',
		array(
			'label'       => __( 'Button link', 'harbour-bay-downtown' ),
			'description' => __( 'Anchor (e.g. "#explore") or full URL.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_hero',
			'type'        => 'url',
		)
	);

	// --- Background image ----------------------------------------------------
	$wp_customize->add_setting(
		'hbd_hero_background_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_hero_background_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Sky / horizon image. Sits behind the title.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// --- Foreground image ---------------------------------------------------
	$wp_customize->add_setting(
		'hbd_hero_foreground_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_hero_foreground_id',
			array(
				'label'       => __( 'Foreground image', 'harbour-bay-downtown' ),
				'description' => __( 'Buildings / city image that overlaps the title. Use a PNG with a transparent top so the title shows through.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Map & Highlights — the "Everything Within Walking Distance"
	// section with the highlights pill, intro copy, and the map image.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_map',
		array(
			'title'       => __( 'Map & Highlights', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_homepage',
			'description' => __( 'The walking-distance highlights section — title, pill chip, sub-heading, body copy, and the map placeholder image.', 'harbour-bay-downtown' ),
			'priority'    => 20,
		)
	);

	// --- Section title ------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_map_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Everything Within\nWalking Distance",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_map_title',
		array(
			'label'       => __( 'Section title', 'harbour-bay-downtown' ),
			'description' => __( 'The big centered headline. Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_map',
			'type'        => 'textarea',
		)
	);

	// --- Pill ---------------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_map_pill',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Highlights',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_map_pill',
		array(
			'label'   => __( 'Pill text', 'harbour-bay-downtown' ),
			'section' => 'hbd_map',
			'type'    => 'text',
		)
	);

	// --- Sub-heading --------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_map_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Your Seaside Stay\nStarts Here",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_map_heading',
		array(
			'label'       => __( 'Sub-heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_map',
			'type'        => 'textarea',
		)
	);

	// --- Body text ----------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_map_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Harbour Bay includes a walkable waterfront area, spa and wellness services, and an international ferry terminal.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_map_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_map',
			'type'    => 'textarea',
		)
	);

	// --- Map image ----------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_map_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_map_image_id',
			array(
				'label'       => __( 'Map image', 'harbour-bay-downtown' ),
				'description' => __( 'The map placeholder image. The location pins are rendered on top via CSS.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_map',
				'mime_type'   => 'image',
			)
		)
	);

	// --- Stats (3× number + label) ------------------------------------------
	$map_stats = array(
		1 => array( '7', "International\nHotels" ),
		2 => array( '10', "Minutes to\nNagoya City" ),
		3 => array( '64+', "Restaurants\n& Cafés" ),
	);

	foreach ( $map_stats as $i => $stat ) {
		$wp_customize->add_setting(
			"hbd_map_stat{$i}_number",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => $stat[0],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"hbd_map_stat{$i}_number",
			array(
				/* translators: %d: stat number (1–3). */
				'label'   => sprintf( __( 'Stat %d — number', 'harbour-bay-downtown' ), $i ),
				'section' => 'hbd_map',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"hbd_map_stat{$i}_label",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_textarea_field',
				'default'           => $stat[1],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"hbd_map_stat{$i}_label",
			array(
				/* translators: %d: stat number (1–3). */
				'label'       => sprintf( __( 'Stat %d — label', 'harbour-bay-downtown' ), $i ),
				'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_map',
				'type'        => 'textarea',
			)
		);
	}

	// -------------------------------------------------------------------------
	// Section: Explore — the section title and decorative background word.
	// (The cards themselves are managed in Appearance → Explore Cards.)
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_explore',
		array(
			'title'       => __( 'Explore', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_homepage',
			'description' => __( 'The Explore section heading and the faint background word behind the cards. The cards are edited in Appearance → Explore Cards.', 'harbour-bay-downtown' ),
			'priority'    => 22,
		)
	);

	$wp_customize->add_setting(
		'hbd_explore_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Explore',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_explore_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_explore',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_explore_decor',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'downtown',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_explore_decor',
		array(
			'label'       => __( 'Background word', 'harbour-bay-downtown' ),
			'description' => __( 'The large faint word shown behind the cards.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_explore',
			'type'        => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Events / What's On — the section title and decorative word.
	// (The cards themselves are managed in Appearance → Events.)
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_events',
		array(
			'title'       => __( "Events / What's On", 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_homepage',
			'description' => __( 'The "What\'s On" heading and the faint background word. The cards are edited in Appearance → Events.', 'harbour-bay-downtown' ),
			'priority'    => 24,
		)
	);

	$wp_customize->add_setting(
		'hbd_events_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "What's On",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_events_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_events',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_events_decor',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'at Harbour Bay',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_events_decor',
		array(
			'label'       => __( 'Background word', 'harbour-bay-downtown' ),
			'description' => __( 'The large faint word shown behind the cards.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_events',
			'type'        => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Special Promotions — intro title and lede for the promo carousel.
	// (The cards themselves are managed in Appearance → Promotions.)
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_promotions',
		array(
			'title'       => __( 'Special Promotions', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_homepage',
			'description' => __( 'The intro title and text beside the promotions carousel. The cards are edited in Appearance → Promotions.', 'harbour-bay-downtown' ),
			'priority'    => 25,
		)
	);

	// --- Title --------------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_promotions_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Special\npromotions",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_promotions_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_promotions',
			'type'        => 'textarea',
		)
	);

	// --- Lede / body text ---------------------------------------------------
	$wp_customize->add_setting(
		'hbd_promotions_text',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Stay updated with what's happening around Harbour Bay Downtown — from seasonal promotions to local events and new openings.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_promotions_text',
		array(
			'label'   => __( 'Text', 'harbour-bay-downtown' ),
			'section' => 'hbd_promotions',
			'type'    => 'textarea',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Guides — the "Read More" button beside the guide tabs.
	// (The cards themselves are blog posts grouped by the Audience taxonomy.)
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_guides',
		array(
			'title'       => __( 'Guides', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_homepage',
			'description' => __( 'The "Read More" button shown beside the guide tabs. The cards are blog posts, grouped by their Audience.', 'harbour-bay-downtown' ),
			'priority'    => 23,
		)
	);

	// --- Read More label ----------------------------------------------------
	$wp_customize->add_setting(
		'hbd_guides_readmore_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Read More',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_guides_readmore_label',
		array(
			'label'   => __( 'Button label', 'harbour-bay-downtown' ),
			'section' => 'hbd_guides',
			'type'    => 'text',
		)
	);

	// --- Read More URL ------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_guides_readmore_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_guides_readmore_url',
		array(
			'label'       => __( 'Button link', 'harbour-bay-downtown' ),
			'description' => __( 'Anchor (e.g. "#guides") or full URL. Leave blank to link to the blog page.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_guides',
			'type'        => 'url',
		)
	);

	// -------------------------------------------------------------------------
	// Section: FAQ / Chat widget — the floating bottom-right help button.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_faq',
		array(
			'title'       => __( 'FAQ / Chat widget', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_global',
			'description' => __( 'The floating button at the bottom-right of every page. It opens an FAQ accordion and a "Chat on WhatsApp" button (set its link below).', 'harbour-bay-downtown' ),
			'priority'    => 27,
		)
	);

	// --- Enable -------------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_faq_enable',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'rest_sanitize_boolean',
			'default'           => true,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_faq_enable',
		array(
			'label'   => __( 'Show the floating FAQ / chat button', 'harbour-bay-downtown' ),
			'section' => 'hbd_faq',
			'type'    => 'checkbox',
		)
	);

	// --- FAQ heading --------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_faq_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'FAQ',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_faq_heading',
		array(
			'label'   => __( 'FAQ heading', 'harbour-bay-downtown' ),
			'section' => 'hbd_faq',
			'type'    => 'text',
		)
	);

	// --- Question / answer pairs -------------------------------------------
	foreach ( hbd_faq_defaults() as $i => $qa ) {
		$n = $i + 1;

		$wp_customize->add_setting(
			"hbd_faq_q{$n}",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => $qa['q'],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"hbd_faq_q{$n}",
			array(
				/* translators: %d: FAQ item number. */
				'label'       => sprintf( __( 'Question %d', 'harbour-bay-downtown' ), $n ),
				'description' => __( 'Leave empty to hide this question.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_faq',
				'type'        => 'text',
			)
		);

		$wp_customize->add_setting(
			"hbd_faq_a{$n}",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_textarea_field',
				'default'           => $qa['a'],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"hbd_faq_a{$n}",
			array(
				/* translators: %d: FAQ item number. */
				'label'   => sprintf( __( 'Answer %d', 'harbour-bay-downtown' ), $n ),
				'section' => 'hbd_faq',
				'type'    => 'textarea',
			)
		);
	}

	// --- CTA heading + button label ----------------------------------------
	$wp_customize->add_setting(
		'hbd_faq_cta_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Do you have any questions?',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_faq_cta_heading',
		array(
			'label'   => __( 'Chat heading', 'harbour-bay-downtown' ),
			'section' => 'hbd_faq',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_faq_cta_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Chat on WhatsApp',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_faq_cta_label',
		array(
			'label'   => __( 'Chat button label', 'harbour-bay-downtown' ),
			'section' => 'hbd_faq',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_faq_cta_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_faq_cta_url',
		array(
			'label'       => __( 'Chat button link', 'harbour-bay-downtown' ),
			'description' => __( 'Where the chat button goes — e.g. a wa.me WhatsApp link. Leave blank to use the Footer → WhatsApp URL.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_faq',
			'type'        => 'url',
		)
	);

	// =========================================================================
	// ABOUT PAGE — content for the secondary "About" page (slug: about).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: About — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_about_hero',
		array(
			'title'       => __( 'About — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_about',
			'description' => __( 'The full-screen hero on the About page — title, CTA button, and background image.', 'harbour-bay-downtown' ),
			'priority'    => 40,
		)
	);

	$wp_customize->add_setting(
		'hbd_about_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Where City Life Flows by the Sea',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_hero_cta_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Explore the District',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_hero_cta_label',
		array(
			'label'       => __( 'Button label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the button.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_hero',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_hero_cta_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '#',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_hero_cta_url',
		array(
			'label'       => __( 'Button link', 'harbour-bay-downtown' ),
			'description' => __( 'Anchor (e.g. "#our-story") or full URL.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_hero',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_about_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied at the bottom for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_about_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: About — Easy Reach (intro beside the Explore-cards carousel).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_about_reach',
		array(
			'title'       => __( 'About — Easy Reach', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_about',
			'description' => __( 'The "Everything Within Easy Reach" intro. The cards are the Explore Cards, edited in Appearance → Explore Cards.', 'harbour-bay-downtown' ),
			'priority'    => 41,
		)
	);

	$wp_customize->add_setting(
		'hbd_about_reach_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Everything Within Easy Reach',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_reach_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_reach',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_reach_text',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Hotels, residences, offices, dining spots, and shops are all in one connected area. With sheltered walkways and a waterfront path linking everything together, it's easy to move around from morning to night without needing a car or taxi.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_reach_text',
		array(
			'label'   => __( 'Text', 'harbour-bay-downtown' ),
			'section' => 'hbd_about_reach',
			'type'    => 'textarea',
		)
	);

	// -------------------------------------------------------------------------
	// Section: About — Live & Work ("A Place for Visits, Living, and Work").
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_about_place',
		array(
			'title'       => __( 'About — Live & Work', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_about',
			'description' => __( 'The "A Place for Visits, Living, and Work" section — title, tag, copy, the three collage images, and their captions.', 'harbour-bay-downtown' ),
			'priority'    => 42,
		)
	);

	$wp_customize->add_setting(
		'hbd_about_place_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "A Place for Visits,\nLiving, and Work",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_place_title',
		array(
			'label'       => __( 'Section title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_place',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_place_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Live & Work',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_place_tag',
		array(
			'label'   => __( 'Tag chip', 'harbour-bay-downtown' ),
			'section' => 'hbd_about_place',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_place_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Where stays, work, and daily life meet',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_place_heading',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_place',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_place_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Harbour Bay Downtown brings together lifestyle spaces, homes, and offices in one connected district.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_place_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_about_place',
			'type'    => 'textarea',
		)
	);

	$about_place_images = array(
		1 => __( 'Collage image 1 (tall, left)', 'harbour-bay-downtown' ),
		2 => __( 'Collage image 2 (center)', 'harbour-bay-downtown' ),
		3 => __( 'Collage image 3 (right)', 'harbour-bay-downtown' ),
	);
	foreach ( $about_place_images as $i => $label ) {
		$wp_customize->add_setting(
			"hbd_about_place_image{$i}_id",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
				'default'           => 0,
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				"hbd_about_place_image{$i}_id",
				array(
					'label'     => $label,
					'section'   => 'hbd_about_place',
					'mime_type' => 'image',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'hbd_about_place_caption1',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'HBB Residences',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_place_caption1',
		array(
			'label'       => __( 'Caption 1 (under image 1)', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_place',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_place_caption2',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Menara Aria',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_place_caption2',
		array(
			'label'       => __( 'Caption 2 (above image 3)', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_place',
			'type'        => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: About — Our Story.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_about_story',
		array(
			'title'       => __( 'About — Our Story', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_about',
			'description' => __( 'The "Our Story" section — title, tag, body copy, and the card image.', 'harbour-bay-downtown' ),
			'priority'    => 43,
		)
	);

	$wp_customize->add_setting(
		'hbd_about_story_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Our Story',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_story_title',
		array(
			'label'       => __( 'Section title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_story',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_story_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Waterfront District',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_story_tag',
		array(
			'label'   => __( 'Tag chip', 'harbour-bay-downtown' ),
			'section' => 'hbd_about_story',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_story_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Harbour Bay Downtown was developed as a waterfront district that brings together travel, leisure, and everyday needs in one connected area.\n\nWith direct access to the international ferry terminal, Harbour Bay Downtown welcomes visitors arriving in Batam while also serving residents and professionals who spend their days here.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_story_body',
		array(
			'label'       => __( 'Body text', 'harbour-bay-downtown' ),
			'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_story',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_story_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_about_story_image_id',
			array(
				'label'     => __( 'Card image', 'harbour-bay-downtown' ),
				'section'   => 'hbd_about_story',
				'mime_type' => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: About — Walking Distance (independent copy of the homepage map).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_about_map',
		array(
			'title'       => __( 'About — Walking Distance', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_about',
			'description' => __( 'The walking-distance copy on the About page (title, pill, headings, body, stats). The map image and pins are shared with the homepage map.', 'harbour-bay-downtown' ),
			'priority'    => 44,
		)
	);

	$wp_customize->add_setting(
		'hbd_about_map_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Everything Within\nWalking Distance",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_map_title',
		array(
			'label'       => __( 'Section title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_map',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_map_pill',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Highlights',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_map_pill',
		array(
			'label'   => __( 'Pill text', 'harbour-bay-downtown' ),
			'section' => 'hbd_about_map',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_map_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Your Seaside Stay\nStarts Here",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_map_heading',
		array(
			'label'       => __( 'Sub-heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_about_map',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_about_map_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Harbour Bay includes a walkable waterfront area, spa and wellness services, and an international ferry terminal.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_about_map_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_about_map',
			'type'    => 'textarea',
		)
	);

	$about_map_stats = array(
		1 => array( '7', "International\nHotels" ),
		2 => array( '10', "Minutes to\nNagoya City" ),
		3 => array( '64+', "Restaurants\n& Cafés" ),
	);
	foreach ( $about_map_stats as $i => $stat ) {
		$wp_customize->add_setting(
			"hbd_about_map_stat{$i}_number",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
				'default'           => $stat[0],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"hbd_about_map_stat{$i}_number",
			array(
				/* translators: %d: stat number (1–3). */
				'label'   => sprintf( __( 'Stat %d — number', 'harbour-bay-downtown' ), $i ),
				'section' => 'hbd_about_map',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"hbd_about_map_stat{$i}_label",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_textarea_field',
				'default'           => $stat[1],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			"hbd_about_map_stat{$i}_label",
			array(
				/* translators: %d: stat number (1–3). */
				'label'       => sprintf( __( 'Stat %d — label', 'harbour-bay-downtown' ), $i ),
				'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_about_map',
				'type'        => 'textarea',
			)
		);
	}

	// =========================================================================
	// NIGHTLIFE PAGE — content for the secondary "Nightlife" page (slug: nightlife).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Nightlife — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_nightlife_hero',
		array(
			'title'       => __( 'Nightlife — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_nightlife',
			'description' => __( 'The full-screen hero — centered title, subtitle, and background image.', 'harbour-bay-downtown' ),
			'priority'    => 50,
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Evenings at Harbour Bay',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_hero_subtitle',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "As the sun sets, Harbour Bay Downtown settles into a different rhythm. The waterfront cools down, lights reflect off the sea, and the area becomes an easy place to spend the night.\n\nBars, lounges, and restaurants are all within walking distance — so your evening can unfold naturally, without planning transport or moving across town.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_hero_subtitle',
		array(
			'label'       => __( 'Subtitle', 'harbour-bay-downtown' ),
			'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_nightlife_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_nightlife_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Nightlife — By the Waterfront (reuses the .about-place layout).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_nightlife_waterfront',
		array(
			'title'       => __( 'Nightlife — By the Waterfront', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_nightlife',
			'description' => __( 'Title, tag, optional heading, body, the three collage images, and their captions.', 'harbour-bay-downtown' ),
			'priority'    => 51,
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_waterfront_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'By the Waterfront',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_waterfront_title',
		array(
			'label'       => __( 'Section title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line (line 2+ is indented).', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_waterfront',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_waterfront_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Night Strolls',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_waterfront_tag',
		array(
			'label'   => __( 'Tag chip', 'harbour-bay-downtown' ),
			'section' => 'hbd_nightlife_waterfront',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_waterfront_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => '',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_waterfront_heading',
		array(
			'label'       => __( 'Heading (optional)', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to show only the body text.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_waterfront',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_waterfront_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "After dinner, many visitors take a walk along the promenade. It's open, comfortable, and easy to navigate. Some stop for a drink by the water.\n\nOthers simply enjoy the view and the atmosphere. It's relaxed, but not quiet. Social, but not overwhelming.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_waterfront_body',
		array(
			'label'       => __( 'Body text', 'harbour-bay-downtown' ),
			'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_waterfront',
			'type'        => 'textarea',
		)
	);

	$nightlife_wf_images = array(
		1 => __( 'Collage image 1 (tall, left)', 'harbour-bay-downtown' ),
		2 => __( 'Collage image 2 (center)', 'harbour-bay-downtown' ),
		3 => __( 'Collage image 3 (right)', 'harbour-bay-downtown' ),
	);
	foreach ( $nightlife_wf_images as $i => $label ) {
		$wp_customize->add_setting(
			"hbd_nightlife_waterfront_image{$i}_id",
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'absint',
				'default'           => 0,
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				"hbd_nightlife_waterfront_image{$i}_id",
				array(
					'label'     => $label,
					'section'   => 'hbd_nightlife_waterfront',
					'mime_type' => 'image',
				)
			)
		);
	}

	$wp_customize->add_setting(
		'hbd_nightlife_waterfront_caption1',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Promenade',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_waterfront_caption1',
		array(
			'label'       => __( 'Caption 1 (under image 1)', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_waterfront',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_waterfront_caption2',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Altitude Rooftop',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_waterfront_caption2',
		array(
			'label'       => __( 'Caption 2 (above image 3)', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_waterfront',
			'type'        => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Nightlife — Bars & Lounges (intro copy; cards are static for now).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_nightlife_bars',
		array(
			'title'       => __( 'Nightlife — Bars & Lounges', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_nightlife',
			'description' => __( 'The pill, heading, and body beside the cards. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 52,
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_bars_pill',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Bay Evenings',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_bars_pill',
		array(
			'label'   => __( 'Pill text', 'harbour-bay-downtown' ),
			'section' => 'hbd_nightlife_bars',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_bars_heading',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Bars &\nlounges",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_bars_heading',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_bars',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_bars_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Whether you're meeting friends, on a casual date, or extending dinner into drinks, there are nearby spots that suit different moods.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_bars_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_nightlife_bars',
			'type'    => 'textarea',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Nightlife — Live Music (title + background word; cards static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_nightlife_livemusic',
		array(
			'title'       => __( 'Nightlife — Live Music', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_nightlife',
			'description' => __( 'The heading and faint background word behind the cards. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 53,
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_livemusic_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Live Music',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_livemusic_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_livemusic',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_livemusic_decor',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => '& Late Nights',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_livemusic_decor',
		array(
			'label'       => __( 'Background word', 'harbour-bay-downtown' ),
			'description' => __( 'The large faint word shown behind the cards.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_livemusic',
			'type'        => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Nightlife — A Smarter Way (reuses Our Story + offset title).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_nightlife_evening',
		array(
			'title'       => __( 'Nightlife — A Smarter Way', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_nightlife',
			'description' => __( 'The closing card — offset title, tag, body copy, and the card image.', 'harbour-bay-downtown' ),
			'priority'    => 54,
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_evening_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "A Smarter Way to\nSpend the Evening",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_evening_title',
		array(
			'label'       => __( 'Section title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line (line 2+ is indented).', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_evening',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_evening_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Night Strolls',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_evening_tag',
		array(
			'label'   => __( 'Tag chip', 'harbour-bay-downtown' ),
			'section' => 'hbd_nightlife_evening',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_evening_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Nightlife at Harbour Bay works because of its simplicity. Dining, drinks, hotels, and the ferry terminal are all connected in one district.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_nightlife_evening_body',
		array(
			'label'       => __( 'Body text', 'harbour-bay-downtown' ),
			'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_nightlife_evening',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_nightlife_evening_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_nightlife_evening_image_id',
			array(
				'label'     => __( 'Card image', 'harbour-bay-downtown' ),
				'section'   => 'hbd_nightlife_evening',
				'mime_type' => 'image',
			)
		)
	);

	// =========================================================================
	// STAY PAGE — content for the secondary "Stay" page (slug: stay).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Stay — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_stay_hero',
		array(
			'title'       => __( 'Stay — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_stay',
			'description' => __( 'The full-screen hero — centered title and background image.', 'harbour-bay-downtown' ),
			'priority'    => 60,
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Stay by the\nWaterfront",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_stay_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_stay_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_stay_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_stay_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Stay — Stay Guides (intro copy + button; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_stay_guides',
		array(
			'title'       => __( 'Stay — Stay Guides', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_stay',
			'description' => __( 'The title, body, and button beside the cards. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 61,
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_guides_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Stay Guides',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_stay_guides_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_stay_guides',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_guides_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'From short business trips to relaxed weekend escapes, Harbour Bay Downtown offers a range of hotels and serviced residences designed for convenience and comfort — steps away from everything you need.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_stay_guides_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_stay_guides',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_guides_button_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Read More',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_stay_guides_button_label',
		array(
			'label'       => __( 'Button label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the button.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_stay_guides',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_guides_button_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '#',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_stay_guides_button_url',
		array(
			'label'   => __( 'Button link', 'harbour-bay-downtown' ),
			'section' => 'hbd_stay_guides',
			'type'    => 'url',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Stay — Hotels (heading; cards are static for now).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_stay_hotels',
		array(
			'title'       => __( 'Stay — Hotels', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_stay',
			'description' => __( 'The section heading. The hotel cards are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 62,
		)
	);

	$wp_customize->add_setting(
		'hbd_stay_hotels_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Hotels',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_stay_hotels_title',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_stay_hotels',
			'type'        => 'textarea',
		)
	);

	// =========================================================================
	// DINE PAGE — content for the secondary "Dine" page (slug: dine).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Dine — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_dine_hero',
		array(
			'title'       => __( 'Dine — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_dine',
			'description' => __( 'The full-screen hero — centered title and background image.', 'harbour-bay-downtown' ),
			'priority'    => 70,
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "A Taste of\nthe Coast",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_dine_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_dine_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_dine_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Dine — Dine Guides (intro copy + button; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_dine_guides',
		array(
			'title'       => __( 'Dine — Dine Guides', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_dine',
			'description' => __( 'The title, body, and button beside the cards. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 71,
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_guides_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Dine Guides',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_guides_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_dine_guides',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_guides_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'From easy breakfasts to relaxed dinners by the sea, dining at Harbour Bay Downtown is simple and convenient. Cafés, restaurants, and hotel dining spots are all within walking distance, making it easy to enjoy good food at a comfortable pace.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_guides_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_dine_guides',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_guides_button_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Read More',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_guides_button_label',
		array(
			'label'       => __( 'Button label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the button.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_dine_guides',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_guides_button_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '#',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_guides_button_url',
		array(
			'label'   => __( 'Button link', 'harbour-bay-downtown' ),
			'section' => 'hbd_dine_guides',
			'type'    => 'url',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Dine — Special Promotions (intro copy; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_dine_promotions',
		array(
			'title'       => __( 'Dine — Special Promotions', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_dine',
			'description' => __( 'The intro title and text beside the promo carousel. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 72,
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_promotions_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Special\npromotions",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_promotions_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_dine_promotions',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_promotions_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Seasonal offers, dining deals, and limited-time experiences around Harbour Bay.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_promotions_body',
		array(
			'label'   => __( 'Text', 'harbour-bay-downtown' ),
			'section' => 'hbd_dine_promotions',
			'type'    => 'textarea',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Dine — Restaurants (heading; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_dine_restaurants',
		array(
			'title'       => __( 'Dine — Restaurants', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_dine',
			'description' => __( 'The section heading. The restaurant cards are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 73,
		)
	);

	$wp_customize->add_setting(
		'hbd_dine_restaurants_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Restaurants',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_dine_restaurants_title',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_dine_restaurants',
			'type'        => 'textarea',
		)
	);

	// =========================================================================
	// SHOP PAGE — content for the secondary "Shop" page (slug: shop).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Shop — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_shop_hero',
		array(
			'title'       => __( 'Shop — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_shop',
			'description' => __( 'The full-screen hero — centered title and background image.', 'harbour-bay-downtown' ),
			'priority'    => 80,
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Shop Along\nthe Bay",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_shop_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_shop_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_shop_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Shop — Shop Guides (intro copy + button; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_shop_guides',
		array(
			'title'       => __( 'Shop — Shop Guides', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_shop',
			'description' => __( 'The title, body, and button beside the cards. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 81,
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_guides_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Shop Guides',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_guides_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_shop_guides',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_guides_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Shopping at Harbour Bay Downtown is centered at Bayfront Mall, located right by the ferry terminal. From local snacks and souvenirs to SIM cards and everyday needs, everything is easy to find in one comfortable indoor space, making it a natural stop on arrival or anytime during the day.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_guides_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_shop_guides',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_guides_button_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Read More',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_guides_button_label',
		array(
			'label'       => __( 'Button label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the button.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_shop_guides',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_guides_button_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '#',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_guides_button_url',
		array(
			'label'   => __( 'Button link', 'harbour-bay-downtown' ),
			'section' => 'hbd_shop_guides',
			'type'    => 'url',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Shop — Special Promotions (intro copy; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_shop_promotions',
		array(
			'title'       => __( 'Shop — Special Promotions', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_shop',
			'description' => __( 'The intro title and text beside the promo carousel. The cards themselves are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 82,
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_promotions_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Special\npromotions",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_promotions_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_shop_promotions',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_promotions_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Seasonal offers, shopping deals, and limited-time experiences around Harbour Bay.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_promotions_body',
		array(
			'label'   => __( 'Text', 'harbour-bay-downtown' ),
			'section' => 'hbd_shop_promotions',
			'type'    => 'textarea',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Shop — Shops (heading; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_shop_shops',
		array(
			'title'       => __( 'Shop — Shops', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_shop',
			'description' => __( 'The section heading. The shop cards are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 83,
		)
	);

	$wp_customize->add_setting(
		'hbd_shop_shops_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Shops',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_shop_shops_title',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_shop_shops',
			'type'        => 'textarea',
		)
	);

	// =========================================================================
	// WELLNESS & SPA PAGE — content for the secondary page (slug: wellness-spa).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Wellness — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_wellness_hero',
		array(
			'title'       => __( 'Wellness — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_wellness',
			'description' => __( 'The full-screen hero — centered title, subtitle, and background image.', 'harbour-bay-downtown' ),
			'priority'    => 90,
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Wellness & Spa',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_hero_subtitle',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Wellness at Harbour Bay Downtown is about slowing down and feeling good without going far. From full spa treatments to quick massages and beauty services, everything is close by and easy to fit into your day.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_hero_subtitle',
		array(
			'label'       => __( 'Subtitle', 'harbour-bay-downtown' ),
			'description' => __( 'Shown under the title, beside the line decoration. Leave empty to hide.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_wellness_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_wellness_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Wellness — Easy to Fit (title + decor word + the text/image card).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_wellness_easyfit',
		array(
			'title'       => __( 'Wellness — Easy to Fit', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_wellness',
			'description' => __( 'The centered title, the faint background word, and the card (tag + body on the left, image on the right).', 'harbour-bay-downtown' ),
			'priority'    => 91,
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_easyfit_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Easy to Fit',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_easyfit_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_easyfit',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_easyfit_decor',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'into your day',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_easyfit_decor',
		array(
			'label'       => __( 'Background word', 'harbour-bay-downtown' ),
			'description' => __( 'The large faint word behind the title.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_easyfit',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_easyfit_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Walkable Wellness',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_easyfit_tag',
		array(
			'label'   => __( 'Pill label', 'harbour-bay-downtown' ),
			'section' => 'hbd_wellness_easyfit',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_easyfit_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Most wellness and spa spots at Harbour Bay Downtown are within walking distance of hotels, dining, and the ferry.\nWhether you're planning a longer spa session or just a quick massage, it's easy to fit in without changing your plans.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_easyfit_body',
		array(
			'label'       => __( 'Body text', 'harbour-bay-downtown' ),
			'description' => __( 'Each line break starts a new paragraph.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_easyfit',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_easyfit_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_wellness_easyfit_image_id',
			array(
				'label'     => __( 'Image', 'harbour-bay-downtown' ),
				'section'   => 'hbd_wellness_easyfit',
				'mime_type' => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Wellness — Spa & Massage (heading + pill; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_wellness_spa',
		array(
			'title'       => __( 'Wellness — Spa & Massage', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_wellness',
			'description' => __( 'The section heading and the pill beside it. The spa cards are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 92,
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_spa_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Spa & Massage',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_spa_title',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_spa',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_spa_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Relax & Recharge',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_spa_tag',
		array(
			'label'       => __( 'Pill label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the pill.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_spa',
			'type'        => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Wellness — Beauty & Grooming (heading; cards come from Listings).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_wellness_beauty',
		array(
			'title'       => __( 'Wellness — Beauty & Grooming', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_wellness',
			'description' => __( 'The section heading. The cards come from Listings with the Type "Wellness".', 'harbour-bay-downtown' ),
			'priority'    => 93,
		)
	);

	$wp_customize->add_setting(
		'hbd_wellness_beauty_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Beauty & Grooming',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_wellness_beauty_title',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_wellness_beauty',
			'type'        => 'textarea',
		)
	);

	// =========================================================================
	// WHAT'S ON PAGE — content for the secondary page (slug: whats-on).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: What's On — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_whatson_hero',
		array(
			'title'       => __( "What's On — Hero", 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_whatson',
			'description' => __( 'The full-screen hero — centered title, subtitle, and background image.', 'harbour-bay-downtown' ),
			'priority'    => 100,
		)
	);

	$wp_customize->add_setting(
		'hbd_whatson_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "What's On",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_whatson_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_whatson_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_whatson_hero_subtitle',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => "Discover upcoming events, seasonal activities, and special promotions happening across Harbour Bay Downtown. From community gatherings to dining offers, explore what's on during your visit.",
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_whatson_hero_subtitle',
		array(
			'label'       => __( 'Subtitle', 'harbour-bay-downtown' ),
			'description' => __( 'Shown under the title, beside the line decoration. Leave empty to hide.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_whatson_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_whatson_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_whatson_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_whatson_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: What's On — Featured Events (placeholder heading + note).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_whatson_events',
		array(
			'title'       => __( "What's On — Featured Events", 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_whatson',
			'description' => __( 'Placeholder section — the events listing is not built yet. Edit the heading and the placeholder note here.', 'harbour-bay-downtown' ),
			'priority'    => 101,
		)
	);

	$wp_customize->add_setting(
		'hbd_whatson_events_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Upcoming Events',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_whatson_events_tag',
		array(
			'label'       => __( 'Pill label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the pill.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_whatson_events',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_whatson_events_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Featured Events',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_whatson_events_title',
		array(
			'label'       => __( 'Heading', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_whatson_events',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_whatson_events_note',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Featured events will appear here.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_whatson_events_note',
		array(
			'label'       => __( 'Placeholder note', 'harbour-bay-downtown' ),
			'description' => __( 'Text shown inside the empty placeholder box.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_whatson_events',
			'type'        => 'text',
		)
	);

	// =========================================================================
	// FERRIES PAGE — content for the secondary page (slug: ferries).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Ferries — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ferries_hero',
		array(
			'title'       => __( 'Ferries — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ferries',
			'description' => __( 'The full-screen hero — centered title and background image.', 'harbour-bay-downtown' ),
			'priority'    => 110,
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Ferry Services',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_ferries_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_ferries_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_ferries_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: Ferries — Travel Guides (intro copy + button; cards from posts).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ferries_guides',
		array(
			'title'       => __( 'Ferries — Travel Guides', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ferries',
			'description' => __( 'The title, body, and button beside the cards. Cards come from blog posts in the "Travel" Guide Section.', 'harbour-bay-downtown' ),
			'priority'    => 111,
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_guides_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Travel Guides',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_guides_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_ferries_guides',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_guides_body',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Harbour Bay International Ferry Terminal connects Batam with nearby international and domestic destinations. Below is a list of ferry operators, routes, and useful information to help you plan your journey.',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_guides_body',
		array(
			'label'   => __( 'Body text', 'harbour-bay-downtown' ),
			'section' => 'hbd_ferries_guides',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_guides_button_label',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Read More',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_guides_button_label',
		array(
			'label'       => __( 'Button label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the button.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_ferries_guides',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_guides_button_url',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'esc_url_raw',
			'default'           => '#',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_guides_button_url',
		array(
			'label'   => __( 'Button link', 'harbour-bay-downtown' ),
			'section' => 'hbd_ferries_guides',
			'type'    => 'url',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Ferries — Ferry Routes (section headings; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ferries_routes',
		array(
			'title'       => __( 'Ferries — Ferry Routes', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ferries',
			'description' => __( 'Headings for the International / Domestic route sections and the card button label. The ferry cards are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 112,
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_intl_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'International Ferry Routes',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_intl_title',
		array(
			'label'   => __( 'International heading', 'harbour-bay-downtown' ),
			'section' => 'hbd_ferries_routes',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_domestic_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Domestic Ferry Routes',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_domestic_title',
		array(
			'label'   => __( 'Domestic heading', 'harbour-bay-downtown' ),
			'section' => 'hbd_ferries_routes',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_card_button',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Visit Operator',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_card_button',
		array(
			'label'   => __( 'Card button label', 'harbour-bay-downtown' ),
			'section' => 'hbd_ferries_routes',
			'type'    => 'text',
		)
	);

	// -------------------------------------------------------------------------
	// Section: Ferries — Immigration & Passenger Info (heading; FAQ is static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ferries_info',
		array(
			'title'       => __( 'Ferries — Immigration & Info', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ferries',
			'description' => __( 'The pill and title beside the FAQ, plus the three FAQ groups (heading + Question | Answer lines).', 'harbour-bay-downtown' ),
			'priority'    => 113,
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_info_tag',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'Ferry Terminal',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_info_tag',
		array(
			'label'       => __( 'Pill label', 'harbour-bay-downtown' ),
			'description' => __( 'Leave empty to hide the pill.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_ferries_info',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'hbd_ferries_info_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'Immigration & Passenger Information',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ferries_info_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_ferries_info',
			'type'        => 'textarea',
		)
	);

	// --- FAQ groups (3 × heading + "Question | Answer" lines) ---------------
	// Defaults live in hbd_ferries_faq_defaults() (inc/ferries.php) so the
	// Customizer and the pattern stay in sync.
	foreach ( hbd_ferries_faq_defaults() as $n => $g ) {
		$wp_customize->add_setting( "hbd_ferries_faq{$n}_title", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $g[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_ferries_faq{$n}_title", array( /* translators: %d: FAQ group number. */ 'label' => sprintf( __( 'FAQ group %d — heading', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_ferries_info', 'type' => 'text' ) );

		$wp_customize->add_setting( "hbd_ferries_faq{$n}_items", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => $g[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_ferries_faq{$n}_items", array( /* translators: %d: FAQ group number. */ 'label' => sprintf( __( 'FAQ group %d — items', 'harbour-bay-downtown' ), $n ), 'description' => __( 'One per line, as "Question | Answer". Leave the heading empty to hide a group.', 'harbour-bay-downtown' ), 'section' => 'hbd_ferries_info', 'type' => 'textarea' ) );
	}

	// =========================================================================
	// K SQUARE MALL PAGE — content for the secondary page (slug: k-square-mall).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: K Square — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ksquare_hero',
		array(
			'title'       => __( 'K Square — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ksquare',
			'description' => __( 'The full-screen hero — centered title and background image.', 'harbour-bay-downtown' ),
			'priority'    => 120,
		)
	);

	$wp_customize->add_setting(
		'hbd_ksquare_hero_title',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'sanitize_textarea_field',
			'default'           => 'K Square Mall',
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		'hbd_ksquare_hero_title',
		array(
			'label'       => __( 'Title', 'harbour-bay-downtown' ),
			'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ),
			'section'     => 'hbd_ksquare_hero',
			'type'        => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'hbd_ksquare_hero_image_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_ksquare_hero_image_id',
			array(
				'label'       => __( 'Background image', 'harbour-bay-downtown' ),
				'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_ksquare_hero',
				'mime_type'   => 'image',
			)
		)
	);

	// -------------------------------------------------------------------------
	// Section: K Square — Free Shuttle.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ksquare_shuttle',
		array(
			'title'       => __( 'K Square — Free Shuttle', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ksquare',
			'description' => __( 'The shuttle title, pill, pick-up/drop-off, the three info items, and the image.', 'harbour-bay-downtown' ),
			'priority'    => 121,
		)
	);

	$hbd_ksquare_shuttle_fields = array(
		'hbd_ksquare_shuttle_title'   => array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'default' => "Free Shuttle\nto K Square Mall", 'type' => 'textarea', 'sanitize' => 'sanitize_textarea_field' ),
		'hbd_ksquare_shuttle_tag'     => array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'default' => 'Shuttle', 'type' => 'text', 'sanitize' => 'sanitize_text_field' ),
		'hbd_ksquare_shuttle_pickup'  => array( 'label' => __( 'Pick-up location', 'harbour-bay-downtown' ), 'default' => 'Outside Swiss-BelHotel Harbour Bay', 'type' => 'text', 'sanitize' => 'sanitize_text_field' ),
		'hbd_ksquare_shuttle_dropoff' => array( 'label' => __( 'Drop-off point', 'harbour-bay-downtown' ), 'default' => 'K Square Mall main entrance', 'type' => 'text', 'sanitize' => 'sanitize_text_field' ),
		'hbd_ksquare_shuttle_item1'   => array( 'label' => __( 'Info item 1', 'harbour-bay-downtown' ), 'default' => 'Complimentary for Harbour Bay visitors', 'type' => 'text', 'sanitize' => 'sanitize_text_field' ),
		'hbd_ksquare_shuttle_item2'   => array( 'label' => __( 'Info item 2', 'harbour-bay-downtown' ), 'default' => 'Operates hourly (11.30am – 9.30pm)', 'type' => 'text', 'sanitize' => 'sanitize_text_field' ),
		'hbd_ksquare_shuttle_item3'   => array( 'label' => __( 'Info item 3', 'harbour-bay-downtown' ), 'default' => 'Comfortable and easy to access', 'type' => 'text', 'sanitize' => 'sanitize_text_field' ),
	);
	foreach ( $hbd_ksquare_shuttle_fields as $hbd_id => $hbd_f ) {
		$wp_customize->add_setting( $hbd_id, array( 'type' => 'theme_mod', 'sanitize_callback' => $hbd_f['sanitize'], 'default' => $hbd_f['default'], 'transport' => 'refresh' ) );
		$wp_customize->add_control( $hbd_id, array( 'label' => $hbd_f['label'], 'section' => 'hbd_ksquare_shuttle', 'type' => $hbd_f['type'] ) );
	}

	$wp_customize->add_setting(
		'hbd_ksquare_shuttle_image_id',
		array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' )
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_ksquare_shuttle_image_id',
			array( 'label' => __( 'Image', 'harbour-bay-downtown' ), 'section' => 'hbd_ksquare_shuttle', 'mime_type' => 'image' )
		)
	);

	// -------------------------------------------------------------------------
	// Section: K Square — About (title, tag, body, 4 collage images + captions).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ksquare_about',
		array(
			'title'       => __( 'K Square — About', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ksquare',
			'description' => __( 'The title, pill, body, and the four collage images with their caption labels.', 'harbour-bay-downtown' ),
			'priority'    => 122,
		)
	);

	$wp_customize->add_setting( 'hbd_ksquare_about_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'About K Square Mall', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_ksquare_about_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_ksquare_about', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_ksquare_about_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Lifestyle Mall', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_ksquare_about_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_ksquare_about', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_ksquare_about_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "K Square Mall is a family-friendly lifestyle mall located a short drive from Harbour Bay Downtown. It's a comfortable, air-conditioned space — ideal for families, groups, or anyone looking for a relaxed afternoon.", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_ksquare_about_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'description' => __( 'Each line break starts a new paragraph.', 'harbour-bay-downtown' ), 'section' => 'hbd_ksquare_about', 'type' => 'textarea' ) );

	$hbd_ksquare_about_captions = array(
		'hbd_ksquare_about_caption1' => 'Cinepolis cinema',
		'hbd_ksquare_about_caption2' => "Indoor playgrounds and kids' entertainment",
		'hbd_ksquare_about_caption3' => 'Casual dining options',
		'hbd_ksquare_about_caption4' => 'Cafés and everyday retail',
	);
	$hbd_i = 1;
	foreach ( $hbd_ksquare_about_captions as $hbd_cap_id => $hbd_cap_default ) {
		$wp_customize->add_setting( "hbd_ksquare_about_image{$hbd_i}_id", array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
		$wp_customize->add_control(
			new WP_Customize_Media_Control(
				$wp_customize,
				"hbd_ksquare_about_image{$hbd_i}_id",
				array( 'label' => sprintf( /* translators: %d: image number. */ __( 'Image %d', 'harbour-bay-downtown' ), $hbd_i ), 'section' => 'hbd_ksquare_about', 'mime_type' => 'image' )
			)
		);
		$wp_customize->add_setting( $hbd_cap_id, array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $hbd_cap_default, 'transport' => 'refresh' ) );
		$wp_customize->add_control( $hbd_cap_id, array( 'label' => sprintf( /* translators: %d: caption number. */ __( 'Caption %d', 'harbour-bay-downtown' ), $hbd_i ), 'section' => 'hbd_ksquare_about', 'type' => 'text' ) );
		$hbd_i++;
	}

	// -------------------------------------------------------------------------
	// Section: K Square — Nearby Area (title + body; cards are static).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_ksquare_nearby',
		array(
			'title'       => __( 'K Square — Nearby Area', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_ksquare',
			'description' => __( 'The title and body beside the place cards. The cards are static placeholders for now.', 'harbour-bay-downtown' ),
			'priority'    => 123,
		)
	);

	$wp_customize->add_setting( 'hbd_ksquare_nearby_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Nearby Area\n& Surroundings", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_ksquare_nearby_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_ksquare_nearby', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_ksquare_nearby_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'K Square Mall is part of a growing lifestyle area. This makes the district suitable for short stays, business visits, and weekend trips.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_ksquare_nearby_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'description' => __( 'Line breaks are kept as typed. Leave a blank line for extra space.', 'harbour-bay-downtown' ), 'section' => 'hbd_ksquare_nearby', 'type' => 'textarea' ) );

	// =========================================================================
	// LIVE & WORK PAGE — content for the secondary page (slug: live-work).
	// =========================================================================

	// -------------------------------------------------------------------------
	// Section: Live & Work — Hero.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_livework_hero',
		array(
			'title'       => __( 'Live & Work — Hero', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_livework',
			'description' => __( 'The full-screen hero — centered title, subtitle, and background image.', 'harbour-bay-downtown' ),
			'priority'    => 130,
		)
	);

	$wp_customize->add_setting( 'hbd_livework_hero_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Space to Work, Places to Live', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_hero_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_hero', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_livework_hero_subtitle', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Harbour Bay Downtown brings together office, retail, and residential opportunities in one connected waterfront district near the international ferry terminal.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_hero_subtitle', array( 'label' => __( 'Subtitle', 'harbour-bay-downtown' ), 'description' => __( 'Shown under the title, beside the line decoration. Leave empty to hide.', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_hero', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_livework_hero_image_id', array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_livework_hero_image_id',
			array( 'label' => __( 'Background image', 'harbour-bay-downtown' ), 'description' => __( 'Full-bleed hero image. A dark scrim is applied for legibility.', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_hero', 'mime_type' => 'image' )
		)
	);

	// -------------------------------------------------------------------------
	// Section: Live & Work — Coming Soon (toggle + content).
	// (Buildings themselves are managed under the Buildings menu in wp-admin.)
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_livework_coming',
		array(
			'title'       => __( 'Live & Work — Coming Soon', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_livework',
			'description' => __( 'Highlight an upcoming development. Turn it off when nothing is coming.', 'harbour-bay-downtown' ),
			'priority'    => 132,
		)
	);

	$wp_customize->add_setting( 'hbd_livework_coming_show', array( 'type' => 'theme_mod', 'sanitize_callback' => 'rest_sanitize_boolean', 'default' => true, 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_coming_show', array( 'label' => __( 'Show the Coming Soon section', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_coming', 'type' => 'checkbox' ) );

	$wp_customize->add_setting( 'hbd_livework_coming_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'New Development', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_coming_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_coming', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_livework_coming_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Coming Soon', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_coming_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_coming', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_livework_coming_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "A new office building will be introduced soon at Harbour Bay Downtown, expanding the district's business space offerings. Designed for companies looking for a well connected location, this upcoming property will provide another opportunity to work within Batam's most accessible waterfront district.", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_coming_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_coming', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_livework_coming_amenities', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "building: New office space option coming soon\nnavigation: Strategic location near the ferry terminal\nmap: Close to hospitality, dining, and retail\nbriefcase: Ideal for growing businesses and professional services", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_coming_amenities', array( 'label' => __( 'Amenities', 'harbour-bay-downtown' ), 'description' => __( 'One per line, as “icon: text”. Icons: building, walk, map, navigation, briefcase, ship, calendar.', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_coming', 'type' => 'textarea' ) );

	// -------------------------------------------------------------------------
	// Section: Live & Work — Enquire (title + intro; the form is a placeholder).
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_livework_contact',
		array(
			'title'       => __( 'Live & Work — Enquire', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_livework',
			'description' => __( 'The title and intro beside the enquiry form. Submissions are emailed to the Sales & Leasing team and saved under Enquiries (see inc/forms.php).', 'harbour-bay-downtown' ),
			'priority'    => 133,
		)
	);

	$wp_customize->add_setting( 'hbd_livework_contact_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Enquire About Space', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_contact_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_contact', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_livework_contact_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Interested in office space or accommodation at Harbour Bay Downtown? Share a few details below and our team will get back to you with suitable options.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_livework_contact_body', array( 'label' => __( 'Intro text', 'harbour-bay-downtown' ), 'section' => 'hbd_livework_contact', 'type' => 'textarea' ) );

	// =========================================================================
	// MAP PAGE — content for the secondary page (slug: map).
	// =========================================================================
	$wp_customize->add_section(
		'hbd_map_page',
		array(
			'title'       => __( 'Map — Page', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_map',
			'description' => __( 'The heading for the full Map page. The map image is set under Homepage → Map, and the pins under Appearance → Map Pins (shared with the homepage).', 'harbour-bay-downtown' ),
			'priority'    => 140,
		)
	);

	$wp_customize->add_setting( 'hbd_map_page_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Map', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_map_page_title', array( 'label' => __( 'Heading', 'harbour-bay-downtown' ), 'section' => 'hbd_map_page', 'type' => 'textarea' ) );

	// =========================================================================
	// MAGAZINE PAGE — content for the secondary page (slug: magazine).
	// =========================================================================

	// Section: Magazine — Discover Batam.
	$wp_customize->add_section(
		'hbd_magazine_discover',
		array(
			'title'       => __( 'Magazine — Discover Batam', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_magazine',
			'priority'    => 10,
		)
	);

	$wp_customize->add_setting( 'hbd_magazine_discover_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Discover Batam', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_discover_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_discover', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_magazine_discover_decor', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'magazine', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_discover_decor', array( 'label' => __( 'Background word', 'harbour-bay-downtown' ), 'description' => __( 'Faint word shown behind the title.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_discover', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_magazine_discover_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'About', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_discover_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_discover', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_magazine_discover_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Discover Batam is a curated city guide designed to help visitors experience Batam with clarity and confidence.\nFrom dining recommendations to weekend ideas, the magazine brings together practical information and local highlights — presented in a clean, easy-to-read format.", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_discover_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter for a new paragraph.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_discover', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_discover_image_id', array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'hbd_magazine_discover_image_id', array( 'label' => __( 'Image', 'harbour-bay-downtown' ), 'description' => __( 'The magazine image shown on the right of the card.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_discover', 'mime_type' => 'image' ) ) );

	// Section: Magazine — What You'll Find Inside.
	$wp_customize->add_section(
		'hbd_magazine_inside',
		array(
			'title'       => __( "Magazine — What You'll Find Inside", 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_magazine',
			'priority'    => 20,
		)
	);

	$wp_customize->add_setting( 'hbd_magazine_inside_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "What You'll Find Inside", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_inside_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_inside', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_inside_subtitle', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'The focus is simple: helpful information without unnecessary noise.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_inside_subtitle', array( 'label' => __( 'Subtitle', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_inside', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_inside_image_id', array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'hbd_magazine_inside_image_id', array( 'label' => __( 'Image', 'harbour-bay-downtown' ), 'description' => __( 'The open-magazine image shown in the centre.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_inside', 'mime_type' => 'image' ) ) );

	$wp_customize->add_setting( 'hbd_magazine_inside_labels', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Family-friendly activities\nSpa and wellness spots\nWeekend itineraries\nDining recommendations\nNew openings and updates\nProperty and lifestyle features", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_inside_labels', array( 'label' => __( 'Feature labels', 'harbour-bay-downtown' ), 'description' => __( 'One per line, up to six. The first three sit on the left of the image, the next three on the right.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_inside', 'type' => 'textarea' ) );

	// Section: Magazine — Read Online.
	$wp_customize->add_section(
		'hbd_magazine_read',
		array(
			'title'       => __( 'Magazine — Read Online', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_magazine',
			'priority'    => 30,
		)
	);

	$wp_customize->add_setting( 'hbd_magazine_read_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Read Online', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_read_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_read', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_read_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'The digital edition is regularly updated with new recommendations and features.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_read_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_read', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_read_button_label', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Visit Website', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_read_button_label', array( 'label' => __( 'Button label', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_read', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_magazine_read_button_url', array( 'type' => 'theme_mod', 'sanitize_callback' => 'esc_url_raw', 'default' => '#', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_read_button_url', array( 'label' => __( 'Button URL', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_read', 'type' => 'url' ) );

	// Carousel cards — image + category chip per card (4 fixed slots; fall back to the bundled magazine-read-N.png).
	$magazine_read_chips = array( 1 => 'Places', 2 => 'Food', 3 => 'Itineraries', 4 => 'Essentials' );
	foreach ( $magazine_read_chips as $n => $chip ) {
		$wp_customize->add_setting( "hbd_magazine_read_card{$n}_image_id", array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "hbd_magazine_read_card{$n}_image_id", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — image', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_magazine_read', 'mime_type' => 'image' ) ) );

		$wp_customize->add_setting( "hbd_magazine_read_card{$n}_chip", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $chip, 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_magazine_read_card{$n}_chip", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — category chip', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_magazine_read', 'type' => 'text' ) );
	}

	// Section: Magazine — Where to Find.
	$wp_customize->add_section(
		'hbd_magazine_where',
		array(
			'title'       => __( 'Magazine — Where to Find', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_magazine',
			'priority'    => 40,
		)
	);

	$wp_customize->add_setting( 'hbd_magazine_where_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Availability', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_where_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_where', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_magazine_where_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Where to Find the Magazine', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_where_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_where', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_where_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Printed copies of Discover Batam are available at selected locations. You can pick up a copy during your visit or browse the latest issue online.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_where_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_where', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_magazine_where_amenities', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "district: Harbour Bay Downtown\nhotel: Hotels within the district\npin: Selected lifestyle venues", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_magazine_where_amenities', array( 'label' => __( 'Amenities', 'harbour-bay-downtown' ), 'description' => __( 'One per line, as “icon: text”. Icons: district, hotel, pin, building, walk, map, navigation, briefcase, ship, calendar.', 'harbour-bay-downtown' ), 'section' => 'hbd_magazine_where', 'type' => 'textarea' ) );

	// =========================================================================
	// CONTACT PAGE — content for the secondary page (slug: contact-us).
	// =========================================================================

	// Section: Contact — Contact Us (title, two info cards, intro).
	$wp_customize->add_section(
		'hbd_contact_cards',
		array(
			'title'       => __( 'Contact — Contact Us', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_contact',
			'priority'    => 10,
		)
	);

	$wp_customize->add_setting( 'hbd_contact_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Contact Us', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_title', array( 'label' => __( 'Page title', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_intro_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Stay In Touch', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_intro_tag', array( 'label' => __( 'Intro pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_intro_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Whether you're planning a visit, exploring business opportunities, or looking for more information, our team is here to help.", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_intro_body', array( 'label' => __( 'Intro text', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_gen_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'General Enquiries', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_gen_title', array( 'label' => __( 'Card 1 — title', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_gen_desc', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'For questions about Harbour Bay Downtown, facilities, directions, or visitor information:', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_gen_desc', array( 'label' => __( 'Card 1 — description', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_gen_email', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'info@harbourbaydowntown.com', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_gen_email', array( 'label' => __( 'Card 1 — email', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_gen_phone', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => '[number]', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_gen_phone', array( 'label' => __( 'Card 1 — phone', 'harbour-bay-downtown' ), 'description' => __( 'Leave empty to hide the phone row.', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_gen_note', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'We aim to respond within 1–2 working days.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_gen_note', array( 'label' => __( 'Card 1 — footer note', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_media_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Media & Partnerships', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_media_title', array( 'label' => __( 'Card 2 — title', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_media_desc', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'For media enquiries, collaborations, or partnership opportunities:', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_media_desc', array( 'label' => __( 'Card 2 — description', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_media_email', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => '[media email]', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_media_email', array( 'label' => __( 'Card 2 — email', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_media_note', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Kindly include your organisation name and a brief outline of your request.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_media_note', array( 'label' => __( 'Card 2 — footer note', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_cards', 'type' => 'textarea' ) );

	// Section: Contact — Send Us a Message (form intro; the form is a placeholder).
	$wp_customize->add_section(
		'hbd_contact_form',
		array(
			'title'       => __( 'Contact — Send Us a Message', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_contact',
			'description' => __( 'The title and intro beside the form. Submissions are emailed to the relevant team and saved under Enquiries (see inc/forms.php).', 'harbour-bay-downtown' ),
			'priority'    => 20,
		)
	);

	$wp_customize->add_setting( 'hbd_contact_form_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Send Us a Message', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_form_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_form', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_form_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Fill in the form below and the relevant team will get back to you.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_form_body', array( 'label' => __( 'Intro text', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_form', 'type' => 'textarea' ) );

	// Section: Contact — Location (address + Google Map).
	$wp_customize->add_section(
		'hbd_contact_location',
		array(
			'title'       => __( 'Contact — Location', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_contact',
			'priority'    => 30,
		)
	);

	$wp_customize->add_setting( 'hbd_contact_location_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Location', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_location_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_location', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_location_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Where Is', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_location_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_location', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_location_place', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Harbour Bay Downtown', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_location_place', array( 'label' => __( 'Place name', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_location', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_location_address', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Harbour Bay, Batam, Indonesia\nLocated directly beside Harbour Bay International Ferry Terminal.", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_location_address', array( 'label' => __( 'Address', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter for a line break.', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_location', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_contact_map_query', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Harbour Bay Downtown, Batam, Indonesia', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_map_query', array( 'label' => __( 'Map location', 'harbour-bay-downtown' ), 'description' => __( 'An address or place name to centre the map on.', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_location', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_contact_map_key', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => '', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_contact_map_key', array( 'label' => __( 'Google Maps Embed API key', 'harbour-bay-downtown' ), 'description' => __( 'Optional. Paste the client’s Maps Embed API key here. Until one is set, a keyless map is shown.', 'harbour-bay-downtown' ), 'section' => 'hbd_contact_location', 'type' => 'text' ) );

	// =========================================================================
	// ADVERTISING PAGE — content for the secondary page (slug: advertising).
	// =========================================================================

	// Section: Advertising — Key Numbers (title + four stat cards).
	$wp_customize->add_section(
		'hbd_adv_numbers',
		array(
			'title'    => __( 'Advertising — Key Numbers', 'harbour-bay-downtown' ),
			'panel'    => 'hbd_panel_advertising',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting( 'hbd_adv_numbers_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Key Numbers (2025)', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_numbers_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_numbers', 'type' => 'text' ) );

	$adv_numbers = array(
		'1' => array( '4.7M', 'Vehicles per year' ),
		'2' => array( '392K', 'Vehicles per month' ),
		'3' => array( '421K', 'Peak monthly vehicles (December)' ),
		'4' => array( '2.3M', 'Ferry passengers per year' ),
	);
	foreach ( $adv_numbers as $n => $pair ) {
		$wp_customize->add_setting( "hbd_adv_num{$n}_value", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_adv_num{$n}_value", array(
			/* translators: %d: card number. */
			'label' => sprintf( __( 'Card %d — value', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_adv_numbers', 'type' => 'text' ) );
		$wp_customize->add_setting( "hbd_adv_num{$n}_label", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_adv_num{$n}_label", array(
			/* translators: %d: card number. */
			'label' => sprintf( __( 'Card %d — label', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_adv_numbers', 'type' => 'text' ) );
	}

	// Section: Advertising — Ferry Passenger Mix (intro + three percentage cards).
	$wp_customize->add_section(
		'hbd_adv_mix',
		array(
			'title'       => __( 'Advertising — Ferry Passenger Mix', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_advertising',
			'description' => __( 'The country illustrations are fixed; the percentages and labels are editable below.', 'harbour-bay-downtown' ),
			'priority'    => 20,
		)
	);

	$wp_customize->add_setting( 'hbd_adv_mix_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Ferry Passenger Mix', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_mix_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_mix', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_adv_mix_subtitle', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Harbour Bay Ferry Terminal welcomes a diverse mix of regional travellers', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_mix_subtitle', array( 'label' => __( 'Subtitle', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_mix', 'type' => 'textarea' ) );

	$adv_mix = array(
		'1' => array( '57%', 'Singapore' ),
		'2' => array( '23%', 'Malaysia' ),
		'3' => array( '20%', 'Indonesia (Domestic)' ),
	);
	foreach ( $adv_mix as $n => $pair ) {
		$wp_customize->add_setting( "hbd_adv_mix{$n}_value", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_adv_mix{$n}_value", array(
			/* translators: %d: card number. */
			'label' => sprintf( __( 'Card %d — percentage', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_adv_mix', 'type' => 'text' ) );
		$wp_customize->add_setting( "hbd_adv_mix{$n}_label", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_adv_mix{$n}_label", array(
			/* translators: %d: card number. */
			'label' => sprintf( __( 'Card %d — label', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_adv_mix', 'type' => 'text' ) );
	}

	// Section: Advertising — Advertising Opportunities (benefits + collage labels).
	$wp_customize->add_section(
		'hbd_adv_opps',
		array(
			'title'    => __( 'Advertising — Advertising Opportunities', 'harbour-bay-downtown' ),
			'panel'    => 'hbd_panel_advertising',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting( 'hbd_adv_opps_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Advertising Opportunities', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_opps_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_opps', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_adv_opps_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Why It Matters', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_opps_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_opps', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_adv_opps_items', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "boat: Direct exposure to arriving and departing ferry passengers\npin: Located immediately outside the ferry terminal\nfootfall: High foot traffic across hotels, dining, spas, and shopping\ncalendar: Strong peaks during weekends, holidays, and school breaks", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_opps_items', array( 'label' => __( 'Benefits', 'harbour-bay-downtown' ), 'description' => __( 'One per line, as “icon: text”. Icons: boat, pin, footfall, calendar, ship, navigation, walk, building, map, briefcase, district, hotel.', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_opps', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_adv_opps_labels', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Static advertising placements\nLED digital screens\nDining & lifestyle\nMain walkways\nArrival & departure zones", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_opps_labels', array( 'label' => __( 'Collage labels', 'harbour-bay-downtown' ), 'description' => __( 'One per line, up to five, placed around the image collage.', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_opps', 'type' => 'textarea' ) );

	// Collage images (5 slots) — fall back to the bundled adv-opp-N.png.
	for ( $i = 1; $i <= 5; $i++ ) {
		$wp_customize->add_setting( "hbd_adv_opps_image{$i}_id", array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "hbd_adv_opps_image{$i}_id", array( /* translators: %d: collage slot number. */ 'label' => sprintf( __( 'Collage image %d', 'harbour-bay-downtown' ), $i ), 'section' => 'hbd_adv_opps', 'mime_type' => 'image' ) ) );
	}

	// Section: Advertising — Get Your Brand Seen (banner card).
	$wp_customize->add_section(
		'hbd_adv_cta',
		array(
			'title'    => __( 'Advertising — Get Your Brand Seen', 'harbour-bay-downtown' ),
			'panel'    => 'hbd_panel_advertising',
			'priority' => 40,
		)
	);

	$wp_customize->add_setting( 'hbd_adv_cta_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Get Your Brand Seen', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_cta_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_cta', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_adv_cta_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Advertising Enquiry', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_cta_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_cta', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_adv_cta_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Fill out the contact form and our team will get back to you with our advertising rate card.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_cta_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_cta', 'type' => 'textarea' ) );

	// Section: Advertising — Enquiry Form (intro; the form is a placeholder).
	$wp_customize->add_section(
		'hbd_adv_form',
		array(
			'title'       => __( 'Advertising — Enquiry Form', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_advertising',
			'description' => __( 'The title and intro beside the form. Submissions are emailed to the relevant team and saved under Enquiries (see inc/forms.php).', 'harbour-bay-downtown' ),
			'priority'    => 50,
		)
	);

	$wp_customize->add_setting( 'hbd_adv_form_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Advertise at\nHarbour Bay\nDowntown", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_form_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_form', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_adv_form_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Be seen by millions of travelers right at arrival.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_adv_form_body', array( 'label' => __( 'Intro text', 'harbour-bay-downtown' ), 'section' => 'hbd_adv_form', 'type' => 'textarea' ) );

	// =========================================================================
	// SALES & LEASING PAGE — content for the secondary page (slug: sales-leasing).
	// =========================================================================

	// Section: Sales & Leasing — Why Harbour Bay.
	$wp_customize->add_section( 'hbd_sl_why', array( 'title' => __( 'Sales & Leasing — Why Harbour Bay', 'harbour-bay-downtown' ), 'panel' => 'hbd_panel_sales', 'priority' => 10 ) );

	$wp_customize->add_setting( 'hbd_sl_why_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Why Harbour Bay Downtown?', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_why_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_why', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_why_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Prime Location', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_why_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_why', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_why_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Harbour Bay Downtown is located directly next to Harbour Bay Ferry Terminal, attracting strong visitor traffic from Singapore and a growing number of travellers from Malaysia. The district also offers walkable access to hotels, dining, shopping, and lifestyle destinations, making it easy for visitors to arrive, explore, and spend time in one connected area.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_why_body', array( 'label' => __( 'Body text', 'harbour-bay-downtown' ), 'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_why', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_sl_why_image_id', array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
	$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'hbd_sl_why_image_id', array( 'label' => __( 'Image', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_why', 'mime_type' => 'image' ) ) );

	$sl_why_stats = array( '1' => array( '50', 'Minutes from Singapore' ), '2' => array( '2', 'Hours from Johor, Malaysia' ) );
	foreach ( $sl_why_stats as $n => $pair ) {
		$wp_customize->add_setting( "hbd_sl_why_stat{$n}_value", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_why_stat{$n}_value", array( /* translators: %d: stat number. */ 'label' => sprintf( __( 'Stat %d — value', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_why', 'type' => 'text' ) );
		$wp_customize->add_setting( "hbd_sl_why_stat{$n}_label", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_why_stat{$n}_label", array( /* translators: %d: stat number. */ 'label' => sprintf( __( 'Stat %d — label', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_why', 'type' => 'text' ) );
	}

	// Section: Sales & Leasing — Built-In Traffic.
	$wp_customize->add_section( 'hbd_sl_traffic', array( 'title' => __( 'Sales & Leasing — Built-In Traffic', 'harbour-bay-downtown' ), 'panel' => 'hbd_panel_sales', 'priority' => 20 ) );

	$wp_customize->add_setting( 'hbd_sl_traffic_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'By the Numbers', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_traffic_tag', array( 'label' => __( 'Pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_traffic', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_traffic_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Built-In Traffic (2025)', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_traffic_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_traffic', 'type' => 'textarea' ) );

	$sl_traffic = array( '1' => array( '2.3M', 'Domestic & international ferry passengers' ), '2' => array( '4.7M', 'Vehicles traffic' ) );
	foreach ( $sl_traffic as $n => $pair ) {
		$wp_customize->add_setting( "hbd_sl_traffic{$n}_value", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_traffic{$n}_value", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — value', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_traffic', 'type' => 'text' ) );
		$wp_customize->add_setting( "hbd_sl_traffic{$n}_label", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_traffic{$n}_label", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — label', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_traffic', 'type' => 'text' ) );
	}

	// Section: Sales & Leasing — Integrated Environment.
	$wp_customize->add_section( 'hbd_sl_env', array( 'title' => __( 'Sales & Leasing — Integrated Environment', 'harbour-bay-downtown' ), 'panel' => 'hbd_panel_sales', 'priority' => 30 ) );

	$wp_customize->add_setting( 'hbd_sl_env_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Integrated Environment', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_env_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_env', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_env_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Connected District', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_env_tag', array( 'label' => __( 'Card pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_env', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_env_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Visitors don't just pass through Harbour Bay Downtown.\n\nThey stay, explore, dine, shop, and spend time across the district, creating strong demand for F&B, retail, and everyday services.", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_env_body', array( 'label' => __( 'Card text', 'harbour-bay-downtown' ), 'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_env', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_sl_env_labels', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "Hotels\nMall\nSeaside restaurants\nResidences\nOffices", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_env_labels', array( 'label' => __( 'Place labels', 'harbour-bay-downtown' ), 'description' => __( 'One per line, up to five, placed around the collage.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_env', 'type' => 'textarea' ) );

	// Collage images (5 slots) — fall back to the bundled sl-env-N.png.
	for ( $i = 1; $i <= 5; $i++ ) {
		$wp_customize->add_setting( "hbd_sl_env_image{$i}_id", array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "hbd_sl_env_image{$i}_id", array( /* translators: %d: collage slot number. */ 'label' => sprintf( __( 'Collage image %d', 'harbour-bay-downtown' ), $i ), 'section' => 'hbd_sl_env', 'mime_type' => 'image' ) ) );
	}

	// Section: Sales & Leasing — Opportunities.
	$wp_customize->add_section( 'hbd_sl_opps', array( 'title' => __( 'Sales & Leasing — Opportunities', 'harbour-bay-downtown' ), 'panel' => 'hbd_panel_sales', 'priority' => 40 ) );

	$wp_customize->add_setting( 'hbd_sl_opps_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Opportunities Available', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_opps_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_opps', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_opps_subtitle', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Seasonal offers, dining deals, and limited-time experiences around Harbour Bay.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_opps_subtitle', array( 'label' => __( 'Subtitle', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_opps', 'type' => 'textarea' ) );

	$sl_opps_cards = array(
		'1' => array( 'Retail & F&B Spaces', 'Units within Bayfront Mall and The Broadway (due to open 4th quarter 2026)', "Restaurants & cafes\nBeauty & wellness\nConvenience & specialty retail" ),
		'2' => array( 'Office Spaces', 'Located within Menara Aria Office Building', "Regional teams\nService businesses\nSupport offices" ),
		'3' => array( 'Residential Units', 'Bayerina, Harbourbay Residences and Union Square condominium', "Full-time residence\nHoliday home\nInvestment (rental to short-stay visitors)" ),
	);
	foreach ( $sl_opps_cards as $n => $c ) {
		$wp_customize->add_setting( "hbd_sl_opps{$n}_title", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $c[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_opps{$n}_title", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — title', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_opps', 'type' => 'text' ) );
		$wp_customize->add_setting( "hbd_sl_opps{$n}_desc", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => $c[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_opps{$n}_desc", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — description', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_opps', 'type' => 'textarea' ) );
		$wp_customize->add_setting( "hbd_sl_opps{$n}_chips", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => $c[2], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_opps{$n}_chips", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — feature chips', 'harbour-bay-downtown' ), $n ), 'description' => __( 'One per line.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_opps', 'type' => 'textarea' ) );

		$wp_customize->add_setting( "hbd_sl_opps{$n}_image_id", array( 'type' => 'theme_mod', 'sanitize_callback' => 'absint', 'default' => 0, 'transport' => 'refresh' ) );
		$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, "hbd_sl_opps{$n}_image_id", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — image', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_opps', 'mime_type' => 'image' ) ) );
	}

	$wp_customize->add_setting( 'hbd_sl_opps_up_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Upcoming Developments', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_opps_up_title', array( 'label' => __( 'Upcoming — title', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_opps', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_sl_opps_up_tag', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => 'Future Growth', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_opps_up_tag', array( 'label' => __( 'Upcoming — pill label', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_opps', 'type' => 'text' ) );

	$wp_customize->add_setting( 'hbd_sl_opps_up_items', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => "New lifestyle and commercial concepts within the district\nOpportunities to enter early in high-growth areas", 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_opps_up_items', array( 'label' => __( 'Upcoming — notes', 'harbour-bay-downtown' ), 'description' => __( 'One per line (shown in two columns).', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_opps', 'type' => 'textarea' ) );

	// Section: Sales & Leasing — What Makes This Different.
	$wp_customize->add_section( 'hbd_sl_diff', array( 'title' => __( 'Sales & Leasing — What Makes This Different', 'harbour-bay-downtown' ), 'panel' => 'hbd_panel_sales', 'priority' => 50 ) );

	$wp_customize->add_setting( 'hbd_sl_diff_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'What Makes This Different', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_diff_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_diff', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_sl_diff_subtitle', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Most areas in Batam require driving from place to place. At Harbour Bay Downtown, everything is within walking distance from the ferry terminal.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_diff_subtitle', array( 'label' => __( 'Subtitle', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_diff', 'type' => 'textarea' ) );

	$sl_diff = array( '1' => array( 'Higher', 'Customer conversion' ), '2' => array( 'Longer', 'Visitor dwell time' ), '3' => array( 'Stronger', 'Business performance' ) );
	foreach ( $sl_diff as $n => $pair ) {
		$wp_customize->add_setting( "hbd_sl_diff{$n}_value", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[0], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_diff{$n}_value", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — word', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_diff', 'type' => 'text' ) );
		$wp_customize->add_setting( "hbd_sl_diff{$n}_label", array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $pair[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( "hbd_sl_diff{$n}_label", array( /* translators: %d: card number. */ 'label' => sprintf( __( 'Card %d — label', 'harbour-bay-downtown' ), $n ), 'section' => 'hbd_sl_diff', 'type' => 'text' ) );
	}

	// Section: Sales & Leasing — Enquiry Form (intro; the form is a placeholder).
	$wp_customize->add_section( 'hbd_sl_form', array( 'title' => __( 'Sales & Leasing — Enquiry Form', 'harbour-bay-downtown' ), 'panel' => 'hbd_panel_sales', 'description' => __( 'The form itself is a placeholder — submitting does nothing yet.', 'harbour-bay-downtown' ), 'priority' => 60 ) );

	$wp_customize->add_setting( 'hbd_sl_form_title', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Sales & Leasing', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_form_title', array( 'label' => __( 'Title', 'harbour-bay-downtown' ), 'description' => __( 'Press Enter to break onto a new line.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_form', 'type' => 'textarea' ) );

	$wp_customize->add_setting( 'hbd_sl_form_body', array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_textarea_field', 'default' => 'Own or lease space in Batam’s most connected waterfront district. Whether you are looking to open a business, invest, or secure a home, this is one of the few locations in Batam where everything works together.', 'transport' => 'refresh' ) );
	$wp_customize->add_control( 'hbd_sl_form_body', array( 'label' => __( 'Intro text', 'harbour-bay-downtown' ), 'description' => __( 'Leave a blank line between paragraphs.', 'harbour-bay-downtown' ), 'section' => 'hbd_sl_form', 'type' => 'textarea' ) );

	// -------------------------------------------------------------------------
	// Section: Footer — logo, social links, and copyright.
	// -------------------------------------------------------------------------
	$wp_customize->add_section(
		'hbd_footer',
		array(
			'title'       => __( 'Footer', 'harbour-bay-downtown' ),
			'panel'       => 'hbd_panel_global',
			'description' => __( 'The footer logo, social icon links, and copyright line.', 'harbour-bay-downtown' ),
		)
	);

	// --- Footer logo --------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_footer_logo_id',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'default'           => 0,
			'transport'         => 'refresh',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'hbd_footer_logo_id',
			array(
				'label'       => __( 'Footer logo', 'harbour-bay-downtown' ),
				'description' => __( 'Logo shown in the footer. If left empty, the site title is shown instead.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_footer',
				'mime_type'   => 'image',
			)
		)
	);

	// --- Social links -------------------------------------------------------
	$socials = array(
		'hbd_social_instagram' => __( 'Instagram URL', 'harbour-bay-downtown' ),
		'hbd_social_facebook'  => __( 'Facebook URL', 'harbour-bay-downtown' ),
		'hbd_social_whatsapp'  => __( 'WhatsApp URL', 'harbour-bay-downtown' ),
	);

	foreach ( $socials as $setting_id => $label ) {
		$wp_customize->add_setting(
			$setting_id,
			array(
				'type'              => 'theme_mod',
				'sanitize_callback' => 'esc_url_raw',
				'default'           => '',
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			$setting_id,
			array(
				'label'       => $label,
				'description' => __( 'Leave blank to hide this icon.', 'harbour-bay-downtown' ),
				'section'     => 'hbd_footer',
				'type'        => 'url',
			)
		);
	}

	// --- Column headings ----------------------------------------------------
	$footer_headings = array(
		'hbd_footer_heading_explore' => array( __( 'Column 1 heading', 'harbour-bay-downtown' ), 'Explore' ),
		'hbd_footer_heading_quick'   => array( __( 'Column 2 heading', 'harbour-bay-downtown' ), 'Quick Links' ),
		'hbd_footer_heading_others'  => array( __( 'Column 3 heading', 'harbour-bay-downtown' ), 'Others' ),
	);
	foreach ( $footer_headings as $setting_id => $cfg ) {
		$wp_customize->add_setting( $setting_id, array( 'type' => 'theme_mod', 'sanitize_callback' => 'sanitize_text_field', 'default' => $cfg[1], 'transport' => 'refresh' ) );
		$wp_customize->add_control( $setting_id, array( 'label' => $cfg[0], 'section' => 'hbd_footer', 'type' => 'text' ) );
	}

	// --- Copyright ----------------------------------------------------------
	$wp_customize->add_setting(
		'hbd_footer_copyright',
		array(
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wp_kses_post',
			'default'           => '',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hbd_footer_copyright',
		array(
			'label'       => __( 'Copyright text', 'harbour-bay-downtown' ),
			'description' => __( 'Shown at the bottom of the footer. Use {year} for the current year. Leave blank to use “© {year} {site name}. All rights reserved.”', 'harbour-bay-downtown' ),
			'section'     => 'hbd_footer',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'hbd_customize_register' );

/**
 * Resolve a theme-mod image setting to a URL — Customizer media control,
 * falling back to a packaged PNG in assets/images/.
 *
 * Uses wp_get_original_image_url() to bypass WP's auto-downscaling
 * (the "-scaled" suffix). Used by Map, Guides, Events, Promotions, etc.
 *
 * @param string $mod_key      Theme mod key (e.g. 'hbd_map_image_id').
 * @param string $fallback_png Filename inside assets/images/.
 * @return string Image URL.
 */
function hbd_resolve_image( $mod_key, $fallback_png ) {
	$id = (int) get_theme_mod( $mod_key, 0 );

	if ( ! $id ) {
		return HBD_THEME_URI . '/assets/images/' . $fallback_png;
	}

	$url = function_exists( 'wp_get_original_image_url' ) ? wp_get_original_image_url( $id ) : '';
	if ( ! $url ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
	}

	return $url ? $url : HBD_THEME_URI . '/assets/images/' . $fallback_png;
}

/**
 * Resolve a hero image URL — first checks the new theme_mod (Customizer),
 * then falls back to the legacy option (admin page), then to the packaged PNG.
 *
 * Uses wp_get_original_image_url() to bypass WordPress's auto-downscaling
 * (the "-scaled" suffix WP applies to uploads > 2560px). On Retina displays a
 * full-bleed hero needs the original pixels to render crisp.
 *
 * @param string $mod_key      Theme mod key (e.g. 'hbd_hero_background_id').
 * @param string $fallback_png Filename inside assets/images/.
 * @return string Image URL.
 */
function hbd_resolve_hero_image( $mod_key, $fallback_png ) {
	$id = (int) get_theme_mod( $mod_key, 0 );

	// Legacy fallback — read the option that the old admin page wrote to.
	if ( ! $id ) {
		$legacy_key = ( 'hbd_hero_background_id' === $mod_key ) ? 'hbd_hero_background_id' : 'hbd_hero_foreground_id';
		$id         = (int) get_option( $legacy_key, 0 );
	}

	if ( ! $id ) {
		return HBD_THEME_URI . '/assets/images/' . $fallback_png;
	}

	// Prefer the truly original upload (no -scaled suffix). Falls back to
	// the registered "full" size if the original isn't recoverable.
	$url = function_exists( 'wp_get_original_image_url' ) ? wp_get_original_image_url( $id ) : '';
	if ( ! $url ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
	}

	return $url ? $url : HBD_THEME_URI . '/assets/images/' . $fallback_png;
}
