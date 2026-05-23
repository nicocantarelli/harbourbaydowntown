<?php
/**
 * Title: Sales & Leasing — Built-In Traffic
 * Slug: harbour-bay-downtown/sl-traffic
 * Categories: harbour-bay-downtown
 * Description: A tag + title on the left and two big stat cards on the right. Editable via Customizer → Sales & Leasing Page → Sales & Leasing — Built-In Traffic.
 * Inserter: no
 * Viewport Width: 1440
 */

$tag   = get_theme_mod( 'hbd_sl_traffic_tag', 'By the Numbers' );
$title = nl2br( esc_html( get_theme_mod( 'hbd_sl_traffic_title', 'Built-In Traffic (2025)' ) ) );

$cards = array(
	array( 'value' => get_theme_mod( 'hbd_sl_traffic1_value', '2.3M' ), 'label' => get_theme_mod( 'hbd_sl_traffic1_label', 'Domestic & international ferry passengers' ) ),
	array( 'value' => get_theme_mod( 'hbd_sl_traffic2_value', '4.7M' ), 'label' => get_theme_mod( 'hbd_sl_traffic2_label', 'Vehicles traffic' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"sl-traffic","layout":{"type":"default"}} -->
<section class="wp-block-group sl-traffic">
	<!-- wp:html -->
	<div class="sl-traffic__intro">
		<?php if ( $tag ) : ?>
		<div class="sl-traffic__tags">
			<span class="decor-ring" aria-hidden="true"></span>
			<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
		</div>
		<?php endif; ?>
		<h2 class="sl-traffic__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	</div>

	<div class="sl-traffic__cards">
		<?php foreach ( $cards as $card ) : ?>
		<div class="sl-stat">
			<span class="sl-stat__value" data-countup><?php echo esc_html( $card['value'] ); ?></span>
			<span class="sl-stat__label"><?php echo esc_html( $card['label'] ); ?></span>
		</div>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
