<?php
/**
 * Title: Home Events
 * Slug: harbour-bay-downtown/home-events
 * Categories: harbour-bay-downtown
 * Description: "What's On" grid — one wide feature card and three narrow event cards, driven by the Events & Promotions content type (type: Event). Cards link to each item's detail page.
 * Block Types:
 * Viewport Width: 1440
 */

$events = hbd_get_events( array( 'type' => 'event', 'number' => 4 ) );
if ( empty( $events ) ) {
	$events = hbd_placeholder_events(); // Show placeholders until the client adds Events.
}

$featured     = $events[0];
$narrow_cards = array_slice( $events, 1, 3 );

$events_title = nl2br( esc_html( get_theme_mod( 'hbd_events_title', "What's On" ) ) );
$events_decor = get_theme_mod( 'hbd_events_decor', 'at Harbour Bay' );
?>
<!-- wp:group {"tagName":"section","className":"home-events","layout":{"type":"default"}} -->
<section class="wp-block-group home-events">
	<!-- wp:group {"className":"home-events__head","layout":{"type":"default"}} -->
	<div class="wp-block-group home-events__head">
		<!-- wp:paragraph {"className":"decor-text home-events__decor"} -->
		<p class="decor-text home-events__decor"><?php echo esc_html( $events_decor ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"home-events__title","textAlign":"center"} -->
		<h2 class="wp-block-heading home-events__title has-text-align-center"><?php echo $events_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"home-events__grid","layout":{"type":"flex","flexWrap":"nowrap"}} -->
	<div class="wp-block-group home-events__grid">
		<!-- wp:group {"className":"card card--type-2 card--type-2-wide","layout":{"type":"default"}} -->
		<div class="wp-block-group card card--type-2 card--type-2-wide">
			<!-- wp:image {"className":"card__image","sizeSlug":"full"} -->
			<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $featured['image'] ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:group {"className":"card__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
			<div class="wp-block-group card__head">
				<!-- wp:group {"className":"card__chips","layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
				<div class="wp-block-group card__chips">
					<span class="decor-ring decor-ring--light" aria-hidden="true"></span>
					<?php if ( $featured['type_name'] ) : ?>
						<span class="tag-chip tag-chip--inverse"><?php echo esc_html( $featured['type_name'] ); ?></span>
					<?php endif; ?>
					<?php if ( $featured['date_display'] ) : ?>
						<span class="decor-ring decor-ring--light" aria-hidden="true"></span>
						<span class="tag-chip tag-chip--inverse"><?php echo esc_html( $featured['date_display'] ); ?></span>
					<?php endif; ?>
				</div>
				<!-- /wp:group -->

				<!-- wp:html -->
				<a href="<?php echo esc_url( $featured['permalink'] ); ?>" class="icon-button icon-button--light icon-button--lg" aria-label="<?php echo esc_attr( $featured['title'] ); ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg></a>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"card__copy","layout":{"type":"default"}} -->
			<div class="wp-block-group card__copy">
				<!-- wp:heading {"level":3,"className":"card__title","textColor":"base"} -->
				<h3 class="wp-block-heading card__title has-base-color has-text-color"><?php echo nl2br( esc_html( $featured['title'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h3>
				<!-- /wp:heading -->

				<?php if ( $featured['excerpt'] ) : ?>
				<!-- wp:paragraph {"className":"card__body","textColor":"base"} -->
				<p class="card__body has-base-color has-text-color"><?php echo esc_html( $featured['excerpt'] ); ?></p>
				<!-- /wp:paragraph -->
				<?php endif; ?>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<?php foreach ( $narrow_cards as $card ) : ?>
		<!-- wp:group {"className":"card card--type-2","layout":{"type":"default"}} -->
		<div class="wp-block-group card card--type-2">
			<!-- wp:image {"className":"card__image","sizeSlug":"full"} -->
			<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
			<!-- /wp:image -->

			<!-- wp:group {"className":"card__head","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right","verticalAlignment":"center"}} -->
			<div class="wp-block-group card__head">
				<!-- wp:html -->
				<a href="<?php echo esc_url( $card['permalink'] ); ?>" class="icon-button icon-button--light icon-button--lg" aria-label="<?php echo esc_attr( $card['title'] ); ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg></a>
				<!-- /wp:html -->
			</div>
			<!-- /wp:group -->

			<!-- wp:heading {"level":4,"className":"card__title","textColor":"base"} -->
			<h4 class="wp-block-heading card__title has-base-color has-text-color"><?php echo nl2br( esc_html( $card['title'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h4>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
