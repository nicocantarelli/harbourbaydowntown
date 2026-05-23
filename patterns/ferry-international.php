<?php
/**
 * Title: Ferries — International Ferry Routes
 * Slug: harbour-bay-downtown/ferry-international
 * Categories: harbour-bay-downtown
 * Description: A heading above a two-column grid of ferry-operator cards (photo + name, route/time/counter, and a "Visit Operator" button), from the Ferries content type (Direction: International). Heading editable via Customizer → Ferries Page. Falls back to placeholders until operators are added.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_ferries_intl_title', 'International Ferry Routes' ) ) );

$cards = hbd_get_ferries( 'international' );
if ( empty( $cards ) ) {
	$img   = HBD_THEME_URI . '/assets/images/';
	$cards = array(
		array( 'image' => $img . 'nightlife-waterfront-1.png', 'logo' => $img . 'ferry-logo-horizon.png',      'name' => 'Horizon Fast Ferry', 'route' => 'HarbourFront Centre ( Singapore )',         'time' => '50min',         'counter' => 'Harbour Bay Ferry Terminal', 'link' => '#' ),
		array( 'image' => $img . 'nightlife-waterfront-2.png', 'logo' => $img . 'ferry-logo-puteri.png',       'name' => 'Puteri Anggreni',    'route' => 'Puteri Harbour Ferry Terminal ( Johor Bahru )', 'time' => '1h - 1h 30min', 'counter' => 'Harbour Bay Ferry Terminal', 'link' => '#' ),
		array( 'image' => $img . 'nightlife-waterfront-3.png', 'logo' => $img . 'ferry-logo-ocean-dragon.png', 'name' => 'Ocean Dragon Ferry', 'route' => 'Stulang Laut Ferry Terminal ( Johor Bahru )',  'time' => '1h 30min',      'counter' => 'Harbour Bay Ferry Terminal', 'link' => '#' ),
		array( 'image' => $img . 'about-story.jpg',            'logo' => $img . 'ferry-logo-dolphin.png',      'name' => 'Dolphin Fast Ferry', 'route' => 'Pasir Gudang Ferry Terminal ( Johor Bahru )', 'time' => '1h - 1h 30min', 'counter' => 'Harbour Bay Ferry Terminal', 'link' => '#' ),
	);
}

$button_label = get_theme_mod( 'hbd_ferries_card_button', 'Visit Operator' );
?>
<!-- wp:group {"tagName":"section","className":"ferry-routes ferry-routes--intl","layout":{"type":"default"}} -->
<section class="wp-block-group ferry-routes ferry-routes--intl">
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
