<?php
/**
 * Title: Sales & Leasing — What Makes This Different
 * Slug: harbour-bay-downtown/sl-different
 * Categories: harbour-bay-downtown
 * Description: A title + subtitle on the left and three word-stat cards on the right. Editable via Customizer → Sales & Leasing Page → Sales & Leasing — What Makes This Different.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_sl_diff_title', 'What Makes This Different' ) ) );
$subtitle = get_theme_mod( 'hbd_sl_diff_subtitle', 'Most areas in Batam require driving from place to place. At Harbour Bay Downtown, everything is within walking distance from the ferry terminal.' );

$cards = array(
	array( 'value' => get_theme_mod( 'hbd_sl_diff1_value', 'Higher' ),   'label' => get_theme_mod( 'hbd_sl_diff1_label', 'Customer conversion' ) ),
	array( 'value' => get_theme_mod( 'hbd_sl_diff2_value', 'Longer' ),   'label' => get_theme_mod( 'hbd_sl_diff2_label', 'Visitor dwell time' ) ),
	array( 'value' => get_theme_mod( 'hbd_sl_diff3_value', 'Stronger' ), 'label' => get_theme_mod( 'hbd_sl_diff3_label', 'Business performance' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"sl-different","layout":{"type":"default"}} -->
<section class="wp-block-group sl-different">
	<!-- wp:html -->
	<div class="sl-different__intro">
		<h2 class="sl-different__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<?php if ( $subtitle ) : ?><p class="sl-different__subtitle"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
	</div>

	<div class="sl-different__cards">
		<?php foreach ( $cards as $card ) : ?>
		<div class="sl-stat">
			<span class="sl-stat__value"><?php echo esc_html( $card['value'] ); ?></span>
			<span class="sl-stat__label"><?php echo esc_html( $card['label'] ); ?></span>
		</div>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
