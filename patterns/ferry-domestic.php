<?php
/**
 * Title: Ferries — Domestic Ferry Routes
 * Slug: harbour-bay-downtown/ferry-domestic
 * Categories: harbour-bay-downtown
 * Description: A heading above a two-column grid of ferry-operator cards (same card as the International section), from the Ferries content type (Direction: Domestic). Heading editable via Customizer → Ferries Page. Falls back to placeholders until operators are added.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_ferries_domestic_title', 'Domestic Ferry Routes' ) ) );

$cards = hbd_get_ferries( 'domestic' );
if ( empty( $cards ) ) {
	$img   = HBD_THEME_URI . '/assets/images/';
	$cards = array(
		array( 'image' => $img . 'nightlife-waterfront-1.png', 'logo' => $img . 'ferry-logo-oceanna.png',      'name' => 'Oceanna Ferry', 'route' => 'HarbourFront Centre ( Singapore )',          'time' => '50min',         'counter' => 'Harbour Bay Ferry Terminal', 'link' => '#' ),
		array( 'image' => $img . 'nightlife-waterfront-2.png', 'logo' => $img . 'ferry-logo-reni-fadhila.png', 'name' => 'Reni Fadhila',  'route' => 'Puteri Harbour Ferry Terminal ( Johor Bahru )', 'time' => '1h - 1h 30min', 'counter' => 'Harbour Bay Ferry Terminal', 'link' => '#' ),
	);
}

$button_label = get_theme_mod( 'hbd_ferries_card_button', 'Visit Operator' );
?>
<!-- wp:group {"tagName":"section","className":"ferry-routes ferry-routes--domestic","layout":{"type":"default"}} -->
<section class="wp-block-group ferry-routes ferry-routes--domestic">
	<!-- wp:heading {"level":2,"className":"ferry-routes__title","textAlign":"center"} -->
	<h2 class="wp-block-heading ferry-routes__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="ferry-routes__grid">
		<?php foreach ( $cards as $card ) : ?>
		<article class="ferry-card">
			<div class="ferry-card__media"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></div>

			<div class="ferry-card__body">
				<div class="ferry-card__content">
					<?php if ( ! empty( $card['logo'] ) ) : ?>
					<img class="ferry-card__logo" src="<?php echo esc_url( $card['logo'] ); ?>" alt="<?php echo esc_attr( $card['name'] ); ?> logo" />
					<?php endif; ?>
					<h3 class="ferry-card__name"><?php echo esc_html( $card['name'] ); ?></h3>
					<dl class="ferry-card__info">
						<div class="ferry-card__row"><dt>Route:</dt> <dd><?php echo esc_html( $card['route'] ); ?></dd></div>
						<div class="ferry-card__row"><dt>Time:</dt> <dd><?php echo esc_html( $card['time'] ); ?></dd></div>
						<div class="ferry-card__row"><dt>Counter Location:</dt> <dd><?php echo esc_html( $card['counter'] ); ?></dd></div>
					</dl>
				</div>

				<?php if ( ! empty( $card['link'] ) ) : ?>
				<div class="wp-block-buttons ferry-card__cta">
					<div class="wp-block-button is-style-pill-big is-style-pill-big-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $card['link'] ); ?>"><?php echo esc_html( $button_label ); ?></a></div>
				</div>
				<?php endif; ?>
			</div>
		</article>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
