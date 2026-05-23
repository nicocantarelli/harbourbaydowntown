<?php
/**
 * Title: Stay — Stay Guides
 * Slug: harbour-bay-downtown/stay-guides
 * Categories: harbour-bay-downtown
 * Description: Special Promotions layout (intro left, carousel right) with a button in the intro and Type-4 guide cards. Intro editable via Customizer → Stay Page → Stay — Stay Guides. The cards are static placeholders for now.
 * Inserter: no
 * Viewport Width: 1440
 */

$title        = nl2br( esc_html( get_theme_mod( 'hbd_stay_guides_title', 'Stay Guides' ) ) );
$body         = get_theme_mod( 'hbd_stay_guides_body', 'From short business trips to relaxed weekend escapes, Harbour Bay Downtown offers a range of hotels and serviced residences designed for convenience and comfort — steps away from everything you need.' );
$button_label = get_theme_mod( 'hbd_stay_guides_button_label', 'Read More' );
$button_url   = get_theme_mod( 'hbd_stay_guides_button_url', '#' );

// Guide cards come from blog posts tagged with the "stay" Guide Section.
// Until any are tagged, fall back to static placeholders so the section isn't empty.
$cards = hbd_get_section_guides( 'stay' );
if ( empty( $cards ) ) {
	$img   = HBD_THEME_URI . '/assets/images/';
	$cards = array(
		array( 'image' => $img . 'card-stay.png',      'category' => 'Guide', 'title' => 'Your First Day',  'excerpt' => 'A simple guide to where to stay, what to eat, and how to spend your first day.', 'date' => '14 March 2026', 'read_time' => '5 min read', 'permalink' => '#' ),
		array( 'image' => $img . 'card-dine.png',      'category' => 'Guide', 'title' => 'Weekend Escapes', 'excerpt' => 'Make the most of a short stay with a relaxed two-day waterfront itinerary.',       'date' => '10 March 2026', 'read_time' => '4 min read', 'permalink' => '#' ),
		array( 'image' => $img . 'card-shop.png',      'category' => 'Guide', 'title' => 'Business Stays',  'excerpt' => 'Serviced residences and hotels built for productive, comfortable work trips.',     'date' => '2 March 2026',  'read_time' => '6 min read', 'permalink' => '#' ),
		array( 'image' => $img . 'card-nightlife.png', 'category' => 'Guide', 'title' => 'Family Friendly', 'excerpt' => 'Room options, dining, and activities that work well for travelling families.',      'date' => '28 Feb 2026',   'read_time' => '5 min read', 'permalink' => '#' ),
	);
}
?>
<!-- wp:group {"tagName":"section","className":"home-promotions stay-guides","layout":{"type":"default"}} -->
<section class="wp-block-group home-promotions stay-guides" data-carousel>
	<!-- wp:group {"className":"home-promotions__layout","layout":{"type":"default"}} -->
	<div class="wp-block-group home-promotions__layout">
		<!-- wp:group {"className":"home-promotions__intro","layout":{"type":"default"}} -->
		<div class="wp-block-group home-promotions__intro">
			<!-- wp:heading {"level":2,"className":"home-promotions__title"} -->
			<h2 class="wp-block-heading home-promotions__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"home-promotions__lede"} -->
			<p class="home-promotions__lede"><?php echo esc_html( $body ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"className":"stay-guides__cta"} -->
			<div class="wp-block-buttons stay-guides__cta">
				<!-- wp:button {"className":"is-style-pill-big is-style-pill-big-dark"} -->
				<div class="wp-block-button is-style-pill-big is-style-pill-big-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $button_label ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"home-promotions__carousel"} -->
		<div class="wp-block-group home-promotions__carousel">
			<!-- wp:group {"className":"carousel__track home-promotions__track"} -->
			<div class="wp-block-group carousel__track home-promotions__track" data-carousel-track>
				<?php foreach ( $cards as $card ) : ?>
				<!-- wp:html -->
				<a class="wp-block-group card card--type-4 card--link" href="<?php echo esc_url( $card['permalink'] ); ?>" aria-label="<?php echo esc_attr( $card['title'] ); ?>">
					<div class="wp-block-group card__image">
						<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
						<span class="tag-chip tag-chip--inverse card__chip-tl"><?php echo esc_html( $card['category'] ? $card['category'] : 'Guide' ); ?></span>
					</div>

					<div class="wp-block-group card__content">
						<div class="card__text">
							<h3 class="wp-block-heading card__title"><?php echo esc_html( $card['title'] ); ?></h3>
							<p class="card__body"><?php echo esc_html( $card['excerpt'] ); ?></p>
						</div>
						<div class="card__meta">
							<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['date'] ); ?></span>
							<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['read_time'] ); ?></span>
						</div>
					</div>
				</a>
				<!-- /wp:html -->
				<?php endforeach; ?>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"carousel__controls home-promotions__controls","layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
	<div class="wp-block-group carousel__controls home-promotions__controls">
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
