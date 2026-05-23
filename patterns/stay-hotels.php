<?php
/**
 * Title: Stay — Hotels
 * Slug: harbour-bay-downtown/stay-hotels
 * Categories: harbour-bay-downtown
 * Description: A grid of full-image hotel cards (Card_Type_5) from Listings of type Hotels. The heading is editable via Customizer → Stay Page → Stay — Hotels. Falls back to placeholders until hotels are added.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_stay_hotels_title', 'Hotels' ) ) );

// Hotel cards come from Listings of type "hotels" (Listings → Type: Hotels).
// Until any exist, fall back to static placeholders so the section isn't empty.
$cards = hbd_get_listings( 'hotels' );
if ( empty( $cards ) ) {
	$img   = HBD_THEME_URI . '/assets/images/';
	$cards = array(
		array( 'image' => $img . 'card-stay.png',      'pill' => '5 min from terminal', 'title' => 'Batam Marriott Hotel Harbour Bay', 'link' => '#' ),
		array( 'image' => $img . 'card-dine.png',      'pill' => '3 min from terminal', 'title' => 'Swiss-Belhotel Harbour Bay', 'link' => '#' ),
		array( 'image' => $img . 'card-shop.png',      'pill' => '7 min from terminal', 'title' => 'Zest Hotel Harbour Bay', 'link' => '#' ),
		array( 'image' => $img . 'card-nightlife.png', 'pill' => '6 min from terminal', 'title' => 'Yello Hotel Harbour Bay', 'link' => '#' ),
		array( 'image' => $img . 'promo-dining.png',   'pill' => '10 min to Nagoya',    'title' => 'Nagoya Hill Hotel', 'link' => '#' ),
		array( 'image' => $img . 'promo-friday.png',   'pill' => '8 min from terminal', 'title' => 'Harmoni Suites Batam', 'link' => '#' ),
	);
}

$arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg>';
?>
<!-- wp:group {"tagName":"section","className":"stay-hotels","layout":{"type":"default"}} -->
<section class="wp-block-group stay-hotels" data-carousel>
	<!-- wp:heading {"level":2,"className":"stay-hotels__title","textAlign":"center"} -->
	<h2 class="wp-block-heading stay-hotels__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="stay-hotels__track" data-carousel-track>
		<?php foreach ( $cards as $card ) : ?>
		<a class="card card--type-5 card--link" href="<?php echo esc_url( $card['link'] ); ?>"<?php echo ! empty( $card['is_external'] ) ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr( $card['title'] ); ?>">
			<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>

			<div class="card__top">
				<div class="card__tags">
					<span class="decor-ring decor-ring--light" aria-hidden="true"></span>
					<span class="tag-chip"><?php echo esc_html( $card['pill'] ); ?></span>
				</div>
				<span class="icon-button icon-button--light card__arrow" aria-hidden="true"><?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			</div>

			<h3 class="card__title"><?php echo esc_html( $card['title'] ); ?></h3>
		</a>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->

	<!-- wp:group {"className":"carousel__controls stay-hotels__controls","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
	<div class="wp-block-group carousel__controls stay-hotels__controls">
		<!-- wp:html -->
		<div class="progress-bar"><span class="progress-bar__rail"></span><span class="progress-bar__fill" data-carousel-progress></span></div>
		<!-- /wp:html -->

		<!-- wp:group {"className":"carousel__nav","layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group carousel__nav">
			<!-- wp:html -->
			<button type="button" class="icon-button icon-button--outline" data-carousel-prev aria-label="Previous"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M21.7803 13.2197C21.4874 12.9268 21.0127 12.9268 20.7198 13.2197L14.7198 19.2197C14.4269 19.5126 14.4269 19.9873 14.7198 20.2802L20.7198 26.2802C21.0127 26.5731 21.4874 26.5731 21.7803 26.2802C22.0732 25.9873 22.0732 25.5126 21.7803 25.2197L16.3106 19.7499L21.7803 14.2802C22.0732 13.9873 22.0732 13.5126 21.7803 13.2197Z" fill="currentColor"/></svg></button>
			<!-- /wp:html -->

			<!-- wp:html -->
			<button type="button" class="icon-button icon-button--outline" data-carousel-next aria-label="Next"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M18.2197 13.2197C18.5126 12.9268 18.9873 12.9268 19.2802 13.2197L25.2802 19.2197C25.5731 19.5126 25.5731 19.9873 25.2802 20.2802L19.2802 26.2802C18.9873 26.5731 18.5126 26.5731 18.2197 26.2802C17.9268 25.9873 17.9268 25.5126 18.2197 25.2197L23.6894 19.7499L18.2197 14.2802C17.9268 13.9873 17.9268 13.5126 18.2197 13.2197Z" fill="currentColor"/></svg></button>
			<!-- /wp:html -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
