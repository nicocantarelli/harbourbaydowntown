<?php
/**
 * Title: Advertising — Key Numbers
 * Slug: harbour-bay-downtown/adv-numbers
 * Categories: harbour-bay-downtown
 * Description: A centered title above a row of four stat cards (big number + label). Editable via Customizer → Advertising Page → Advertising — Key Numbers.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_adv_numbers_title', 'Key Numbers (2025)' ) ) );

$cards = array(
	array( 'value' => get_theme_mod( 'hbd_adv_num1_value', '4.7M' ), 'label' => get_theme_mod( 'hbd_adv_num1_label', 'Vehicles per year' ) ),
	array( 'value' => get_theme_mod( 'hbd_adv_num2_value', '392K' ), 'label' => get_theme_mod( 'hbd_adv_num2_label', 'Vehicles per month' ) ),
	array( 'value' => get_theme_mod( 'hbd_adv_num3_value', '421K' ), 'label' => get_theme_mod( 'hbd_adv_num3_label', 'Peak monthly vehicles (December)' ) ),
	array( 'value' => get_theme_mod( 'hbd_adv_num4_value', '2.3M' ), 'label' => get_theme_mod( 'hbd_adv_num4_label', 'Ferry passengers per year' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"adv-numbers","layout":{"type":"default"}} -->
<section class="wp-block-group adv-numbers">
	<!-- wp:heading {"level":1,"className":"adv-numbers__title","textAlign":"center"} -->
	<h1 class="wp-block-heading adv-numbers__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h1>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="adv-numbers__grid">
		<?php foreach ( $cards as $card ) : ?>
		<div class="adv-stat">
			<span class="adv-stat__value" data-countup><?php echo esc_html( $card['value'] ); ?></span>
			<span class="adv-stat__label"><?php echo esc_html( $card['label'] ); ?></span>
		</div>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
