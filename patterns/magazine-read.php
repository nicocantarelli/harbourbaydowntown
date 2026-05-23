<?php
/**
 * Title: Magazine — Read Online
 * Slug: harbour-bay-downtown/magazine-read
 * Categories: harbour-bay-downtown
 * Description: Special Promotions layout (intro left, carousel right) with a button in the intro and full-image preview cards (image + category chip). Intro and the four cards (image + chip each) are editable via Customizer → Magazine Page → Magazine — Read Online.
 * Inserter: no
 * Viewport Width: 1440
 */

$title        = nl2br( esc_html( get_theme_mod( 'hbd_magazine_read_title', 'Read Online' ) ) );
$body         = get_theme_mod( 'hbd_magazine_read_body', 'The digital edition is regularly updated with new recommendations and features.' );
$button_label = get_theme_mod( 'hbd_magazine_read_button_label', 'Visit Website' );
$button_url   = get_theme_mod( 'hbd_magazine_read_button_url', '#' );

// Carousel cards — image + category chip per card. Each is a Customizer upload
// (Magazine — Read Online), falling back to the bundled magazine-read-N.png.
$card_defaults = array(
	1 => array( 'magazine-read-1.png', 'Places' ),
	2 => array( 'magazine-read-2.png', 'Food' ),
	3 => array( 'magazine-read-3.png', 'Itineraries' ),
	4 => array( 'magazine-read-4.png', 'Essentials' ),
);
$cards = array();
foreach ( $card_defaults as $n => $default ) {
	$cards[] = array(
		'image' => hbd_resolve_image( "hbd_magazine_read_card{$n}_image_id", $default[0] ),
		'chip'  => get_theme_mod( "hbd_magazine_read_card{$n}_chip", $default[1] ),
	);
}
?>
<!-- wp:group {"tagName":"section","className":"home-promotions magazine-read","layout":{"type":"default"}} -->
<section class="wp-block-group home-promotions magazine-read" data-carousel>
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

			<!-- wp:buttons {"className":"magazine-read__cta"} -->
			<div class="wp-block-buttons magazine-read__cta">
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
				<div class="magazine-read__card">
					<figure class="magazine-read__media"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
					<span class="tag-chip tag-chip--inverse magazine-read__chip"><?php echo esc_html( $card['chip'] ); ?></span>
				</div>
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
