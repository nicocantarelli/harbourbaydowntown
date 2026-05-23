<?php
/**
 * Title: Advertising — Ferry Passenger Mix
 * Slug: harbour-bay-downtown/adv-mix
 * Categories: harbour-bay-downtown
 * Description: A title + subtitle on the left and three percentage cards (with faint country illustrations) on the right. Editable via Customizer → Advertising Page → Advertising — Ferry Passenger Mix.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_adv_mix_title', 'Ferry Passenger Mix' ) ) );
$subtitle = get_theme_mod( 'hbd_adv_mix_subtitle', 'Harbour Bay Ferry Terminal welcomes a diverse mix of regional travellers' );

$img   = HBD_THEME_URI . '/assets/images/';
$cards = array(
	array( 'percent' => get_theme_mod( 'hbd_adv_mix1_value', '57%' ), 'label' => get_theme_mod( 'hbd_adv_mix1_label', 'Singapore' ),            'illustration' => 'adv-flag-sg.png' ),
	array( 'percent' => get_theme_mod( 'hbd_adv_mix2_value', '23%' ), 'label' => get_theme_mod( 'hbd_adv_mix2_label', 'Malaysia' ),             'illustration' => 'adv-flag-my.png' ),
	array( 'percent' => get_theme_mod( 'hbd_adv_mix3_value', '20%' ), 'label' => get_theme_mod( 'hbd_adv_mix3_label', 'Indonesia (Domestic)' ), 'illustration' => 'adv-flag-id.png' ),
);
?>
<!-- wp:group {"tagName":"section","className":"adv-mix","layout":{"type":"default"}} -->
<section class="wp-block-group adv-mix">
	<!-- wp:html -->
	<div class="adv-mix__intro">
		<h2 class="adv-mix__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<?php if ( $subtitle ) : ?><p class="adv-mix__subtitle"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
	</div>

	<div class="adv-mix__cards">
		<?php foreach ( $cards as $card ) : ?>
		<div class="adv-mix__card">
			<img class="adv-mix__illustration" src="<?php echo esc_url( $img . $card['illustration'] ); ?>" alt="" aria-hidden="true" />
			<span class="adv-mix__percent" data-countup><?php echo esc_html( $card['percent'] ); ?></span>
			<span class="adv-mix__label"><?php echo esc_html( $card['label'] ); ?></span>
		</div>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
