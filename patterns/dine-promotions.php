<?php
/**
 * Title: Dine — Special Promotions
 * Slug: harbour-bay-downtown/dine-promotions
 * Categories: harbour-bay-downtown
 * Description: Intro on the left + a carousel of promotion cards, driven by the Events & Promotions content type (type: Promotion). Cards link to each promotion's detail page. Intro editable via Customizer → Dine Page → Dine — Special Promotions.
 * Inserter: no
 * Viewport Width: 1440
 */

$promos = hbd_get_events( array( 'type' => 'promotion', 'number' => 3 ) );
if ( empty( $promos ) ) {
	$promos = hbd_placeholder_promotions();
}

$title = nl2br( esc_html( get_theme_mod( 'hbd_dine_promotions_title', "Special\npromotions" ) ) );
$body  = get_theme_mod( 'hbd_dine_promotions_body', 'Seasonal offers, dining deals, and limited-time experiences around Harbour Bay.' );
?>
<!-- wp:group {"tagName":"section","className":"home-promotions dine-promotions","layout":{"type":"default"}} -->
<section class="wp-block-group home-promotions dine-promotions" data-carousel>
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
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"className":"home-promotions__carousel"} -->
		<div class="wp-block-group home-promotions__carousel">
			<!-- wp:group {"className":"carousel__track home-promotions__track"} -->
			<div class="wp-block-group carousel__track home-promotions__track" data-carousel-track>
				<?php foreach ( $promos as $promo ) : ?>
				<!-- wp:group {"className":"card card--type-3","layout":{"type":"default"}} -->
				<div class="wp-block-group card card--type-3">
					<!-- wp:image {"className":"card__image","sizeSlug":"full"} -->
					<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $promo['image'] ); ?>" alt=""/></figure>
					<!-- /wp:image -->

					<!-- wp:group {"className":"card__copy","layout":{"type":"default"}} -->
					<div class="wp-block-group card__copy">
						<!-- wp:heading {"level":3,"className":"card__title","textColor":"base"} -->
						<h3 class="wp-block-heading card__title has-base-color has-text-color"><?php echo esc_html( $promo['title'] ); ?></h3>
						<!-- /wp:heading -->

						<?php if ( $promo['date_display'] ) : ?>
						<!-- wp:html -->
						<span class="tag-chip tag-chip--inverse"><?php echo esc_html( $promo['date_display'] ); ?></span>
						<!-- /wp:html -->
						<?php endif; ?>
					</div>
					<!-- /wp:group -->

					<!-- wp:buttons {"className":"card__cta"} -->
					<div class="wp-block-buttons card__cta">
						<!-- wp:button {"className":"is-style-pill-big"} -->
						<div class="wp-block-button is-style-pill-big"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $promo['permalink'] ); ?>"><?php esc_html_e( 'View offer', 'harbour-bay-downtown' ); ?></a></div>
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
