<?php
/**
 * Title: Dine — Restaurants
 * Slug: harbour-bay-downtown/dine-restaurants
 * Categories: harbour-bay-downtown
 * Description: Same as the Stay "Hotels" grid (Card_Type_5) but with carousel controls at the bottom — a two-row track that scrolls when there are more than six cards. Heading editable via Customizer → Dine Page → Dine — Restaurants. Cards come from Listings of type Restaurants; falls back to placeholders until added.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_dine_restaurants_title', 'Restaurants' ) ) );

// Restaurant cards come from Listings of type "restaurants" (Listings → Type: Restaurants).
// Until any exist, fall back to static placeholders so the section isn't empty.
$cards = hbd_get_listings( 'restaurants' );
if ( empty( $cards ) ) {
	$img   = HBD_THEME_URI . '/assets/images/';
	$cards = array(
		array( 'image' => $img . 'card-dine.png',      'pill' => 'Waterfront',   'title' => 'Coastline Seafood', 'link' => '#' ),
		array( 'image' => $img . 'promo-dining.png',   'pill' => 'Steak & Grill', 'title' => 'The Harbour Grill', 'link' => '#' ),
		array( 'image' => $img . 'card-stay.png',      'pill' => 'Local Cuisine', 'title' => 'Nagoya Kitchen', 'link' => '#' ),
		array( 'image' => $img . 'card-shop.png',      'pill' => 'Japanese',      'title' => 'Bay Sushi Bar', 'link' => '#' ),
		array( 'image' => $img . 'promo-surf.png',     'pill' => 'Italian',       'title' => 'Trattoria del Mare', 'link' => '#' ),
		array( 'image' => $img . 'card-nightlife.png', 'pill' => 'Asian Fusion',  'title' => 'Spice Route', 'link' => '#' ),
		array( 'image' => $img . 'promo-friday.png',   'pill' => 'French',        'title' => 'Ocean Breeze Bistro', 'link' => '#' ),
		array( 'image' => $img . 'card-dine.png',      'pill' => 'Seafood Grill', 'title' => 'Dock 9', 'link' => '#' ),
		array( 'image' => $img . 'card-stay.png',      'pill' => 'Indian',        'title' => 'Saffron House', 'link' => '#' ),
		array( 'image' => $img . 'card-shop.png',      'pill' => 'Street Food',   'title' => 'The Noodle Bar', 'link' => '#' ),
		array( 'image' => $img . 'promo-dining.png',   'pill' => 'Spanish',       'title' => 'Marina Tapas', 'link' => '#' ),
		array( 'image' => $img . 'card-nightlife.png', 'pill' => 'Fusion',        'title' => 'Sunset Lounge', 'link' => '#' ),
	);
}

$arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg>';
?>
<!-- wp:group {"tagName":"section","className":"dine-restaurants","layout":{"type":"default"}} -->
<section class="wp-block-group dine-restaurants" data-carousel>
	<!-- wp:heading {"level":2,"className":"dine-restaurants__title","textAlign":"center"} -->
	<h2 class="wp-block-heading dine-restaurants__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="dine-restaurants__track" data-carousel-track>
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

	<!-- wp:group {"className":"carousel__controls dine-restaurants__controls","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
	<div class="wp-block-group carousel__controls dine-restaurants__controls">
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
