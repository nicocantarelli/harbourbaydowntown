<?php
/**
 * Title: Sales & Leasing — Opportunities Available
 * Slug: harbour-bay-downtown/sl-opportunities
 * Categories: harbour-bay-downtown
 * Description: A centered title + subtitle above three full-image opportunity cards (title, description, feature chips) and an "Upcoming Developments" card. Editable via Customizer → Sales & Leasing Page → Sales & Leasing — Opportunities.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_sl_opps_title', 'Opportunities Available' ) ) );
$subtitle = get_theme_mod( 'hbd_sl_opps_subtitle', 'Seasonal offers, dining deals, and limited-time experiences around Harbour Bay.' );

$chips_of = static function ( $raw ) {
	return array_slice( array_values( array_filter( array_map( 'trim', preg_split( '/\R+/', (string) $raw ) ), 'strlen' ) ), 0, 6 );
};

$cards = array(
	array(
		'image' => hbd_resolve_image( 'hbd_sl_opps1_image_id', 'sl-opp-1.png' ),
		'title' => get_theme_mod( 'hbd_sl_opps1_title', 'Retail & F&B Spaces' ),
		'desc'  => get_theme_mod( 'hbd_sl_opps1_desc', 'Units within Bayfront Mall and The Broadway (due to open 4th quarter 2026)' ),
		'chips' => $chips_of( get_theme_mod( 'hbd_sl_opps1_chips', "Restaurants & cafes\nBeauty & wellness\nConvenience & specialty retail" ) ),
	),
	array(
		'image' => hbd_resolve_image( 'hbd_sl_opps2_image_id', 'sl-opp-2.png' ),
		'title' => get_theme_mod( 'hbd_sl_opps2_title', 'Office Spaces' ),
		'desc'  => get_theme_mod( 'hbd_sl_opps2_desc', 'Located within Menara Aria Office Building' ),
		'chips' => $chips_of( get_theme_mod( 'hbd_sl_opps2_chips', "Regional teams\nService businesses\nSupport offices" ) ),
	),
	array(
		'image' => hbd_resolve_image( 'hbd_sl_opps3_image_id', 'sl-opp-3.png' ),
		'title' => get_theme_mod( 'hbd_sl_opps3_title', 'Residential Units' ),
		'desc'  => get_theme_mod( 'hbd_sl_opps3_desc', 'Bayerina, Harbourbay Residences and Union Square condominium' ),
		'chips' => $chips_of( get_theme_mod( 'hbd_sl_opps3_chips', "Full-time residence\nHoliday home\nInvestment (rental to short-stay visitors)" ) ),
	),
);

$up_title = nl2br( esc_html( get_theme_mod( 'hbd_sl_opps_up_title', 'Upcoming Developments' ) ) );
$up_tag   = get_theme_mod( 'hbd_sl_opps_up_tag', 'Future Growth' );
$up_items = array_slice( array_values( array_filter( array_map( 'trim', preg_split( '/\R+/', (string) get_theme_mod( 'hbd_sl_opps_up_items', "New lifestyle and commercial concepts within the district\nOpportunities to enter early in high-growth areas" ) ) ), 'strlen' ) ), 0, 4 );
?>
<!-- wp:group {"tagName":"section","className":"sl-opportunities","layout":{"type":"default"}} -->
<section class="wp-block-group sl-opportunities">
	<!-- wp:group {"className":"sl-opportunities__head","layout":{"type":"default"}} -->
	<div class="wp-block-group sl-opportunities__head">
		<!-- wp:heading {"level":2,"className":"sl-opportunities__title","textAlign":"center"} -->
		<h2 class="wp-block-heading sl-opportunities__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<!-- /wp:heading -->

		<?php if ( $subtitle ) : ?>
		<!-- wp:paragraph {"className":"sl-opportunities__subtitle","align":"center"} -->
		<p class="sl-opportunities__subtitle has-text-align-center"><?php echo esc_html( $subtitle ); ?></p>
		<!-- /wp:paragraph -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="sl-opportunities__leasing">
	<div class="sl-opportunities__cards">
		<?php foreach ( $cards as $card ) : ?>
		<article class="sl-opp-card">
			<figure class="sl-opp-card__media"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>

			<div class="sl-opp-card__head">
				<h3 class="sl-opp-card__title"><?php echo esc_html( $card['title'] ); ?></h3>
				<?php if ( $card['desc'] ) : ?><p class="sl-opp-card__desc"><?php echo esc_html( $card['desc'] ); ?></p><?php endif; ?>
			</div>

			<?php if ( $card['chips'] ) : ?>
			<div class="sl-opp-card__chips">
				<?php foreach ( $card['chips'] as $chip ) : ?>
				<span class="tag-chip tag-chip--inverse"><?php echo esc_html( $chip ); ?></span>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</article>
		<?php endforeach; ?>
	</div>

	<div class="sl-opp-upcoming">
		<h3 class="sl-opp-upcoming__title"><?php echo $up_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h3>

		<div class="sl-opp-upcoming__info">
			<?php if ( $up_tag ) : ?>
			<div class="sl-opp-upcoming__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $up_tag ); ?></span>
			</div>
			<?php endif; ?>

			<div class="sl-opp-upcoming__items">
				<?php foreach ( $up_items as $item ) : ?>
				<p class="sl-opp-upcoming__item"><?php echo esc_html( $item ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
