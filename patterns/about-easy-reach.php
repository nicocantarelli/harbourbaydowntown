<?php
/**
 * Title: About — Everything Within Easy Reach
 * Slug: harbour-bay-downtown/about-easy-reach
 * Categories: harbour-bay-downtown
 * Description: The homepage Special Promotions layout (intro left, carousel right) rewired to pull the Explore Cards. Intro copy is editable via Customizer → Theme Options → About — Easy Reach; the cards come from Appearance → Explore Cards.
 * Inserter: no
 * Viewport Width: 1440
 */

$cards = get_option( 'hbd_explore_cards', hbd_default_explore_cards() );
if ( ! is_array( $cards ) || empty( $cards ) ) {
	$cards = hbd_default_explore_cards();
}

$reach_title = nl2br( esc_html( get_theme_mod( 'hbd_about_reach_title', 'Everything Within Easy Reach' ) ) );
$reach_text  = get_theme_mod( 'hbd_about_reach_text', "Hotels, residences, offices, dining spots, and shops are all in one connected area. With sheltered walkways and a waterfront path linking everything together, it's easy to move around from morning to night without needing a car or taxi." );
?>
<!-- wp:group {"tagName":"section","className":"home-promotions about-easy-reach","layout":{"type":"default"}} -->
<section class="wp-block-group home-promotions about-easy-reach" data-carousel>
	<!-- wp:group {"className":"home-promotions__layout","layout":{"type":"default"}} -->
	<div class="wp-block-group home-promotions__layout">
		<!-- wp:group {"className":"home-promotions__intro","layout":{"type":"default"}} -->
		<div class="wp-block-group home-promotions__intro">
			<!-- wp:heading {"level":2,"className":"home-promotions__title"} -->
			<h2 class="wp-block-heading home-promotions__title"><?php echo $reach_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"className":"home-promotions__lede"} -->
			<p class="home-promotions__lede"><?php echo esc_html( $reach_text ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"home-promotions__carousel"} -->
		<div class="wp-block-group home-promotions__carousel">
			<!-- wp:group {"className":"carousel__track home-promotions__track"} -->
			<div class="wp-block-group carousel__track home-promotions__track" data-carousel-track>
				<?php foreach ( $cards as $card ) :
					$image_url = hbd_explore_card_image_url( $card );
					$link_text = ! empty( $card['link_text'] ) ? $card['link_text'] : 'Explore';
					$link_url  = ! empty( $card['link_url'] ) ? $card['link_url'] : '#';
				?>
				<!-- wp:group {"className":"card card--type-1","layout":{"type":"default"}} -->
				<div class="wp-block-group card card--type-1">
					<?php if ( $image_url ) : ?>
					<!-- wp:image {"className":"card__image","sizeSlug":"full"} -->
					<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $card['title'] ?? '' ); ?>"/></figure>
					<!-- /wp:image -->
					<?php endif; ?>

					<!-- wp:heading {"level":3,"className":"card__title","textColor":"base"} -->
					<h3 class="wp-block-heading card__title has-base-color has-text-color"><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"className":"card__body","textColor":"base"} -->
					<p class="card__body has-base-color has-text-color"><?php echo esc_html( $card['description'] ?? '' ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:buttons {"className":"card__cta"} -->
					<div class="wp-block-buttons card__cta">
						<!-- wp:button {"className":"is-style-pill-big"} -->
						<div class="wp-block-button is-style-pill-big"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_text ); ?></a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->
				</div>
				<!-- /wp:group -->
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
