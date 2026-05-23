<?php
/**
 * Title: What's On — Featured Events
 * Slug: harbour-bay-downtown/whats-on-events
 * Categories: harbour-bay-downtown
 * Description: One large feature card plus three smaller event cards, driven by the Events & Promotions content type — events toggled "Feature on the What's On page" (up to 4). Each card links to the event's detail page. Heading editable via Customizer → What's On Page → What's On — Featured Events.
 * Inserter: no
 * Viewport Width: 1440
 */

$title  = nl2br( esc_html( get_theme_mod( 'hbd_whatson_events_title', 'Featured Events' ) ) );
$events = hbd_get_events( array( 'type' => 'event', 'featured' => true, 'number' => 4 ) );
if ( empty( $events ) ) {
	$events = hbd_placeholder_events(); // Show placeholders until events are featured.
}

$feature = $events[0];
$side    = array_slice( $events, 1, 3 );

$arrow = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg>';

/**
 * Render the dot + line + text location row.
 *
 * @param string $location Location text.
 */
$render_loc = static function ( $location ) {
	if ( '' === $location ) {
		return;
	}
	?>
	<span class="event-loc">
		<span class="event-loc__rule" aria-hidden="true"><span class="event-loc__dot"></span><span class="event-loc__line"></span></span>
		<span class="event-loc__text"><?php echo esc_html( $location ); ?></span>
	</span>
	<?php
};
?>
<!-- wp:group {"tagName":"section","className":"whats-on-events","layout":{"type":"default"}} -->
<section class="wp-block-group whats-on-events">
	<!-- wp:html -->
	<div class="whats-on-events__head">
		<h2 class="whats-on-events__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	</div>

	<div class="whats-on-events__layout">
		<div class="whats-on-events__feature">
			<a class="whats-on-feature" href="<?php echo esc_url( $feature['permalink'] ); ?>" aria-label="<?php echo esc_attr( $feature['title'] ); ?>">
				<span class="whats-on-feature__media">
					<img src="<?php echo esc_url( $feature['image'] ); ?>" alt=""/>
					<?php $f_meta = $feature['time'] ? $feature['time'] : $feature['date_display']; ?>
					<?php if ( $f_meta ) : ?>
						<span class="whats-on-feature__tag"><?php echo esc_html( $f_meta ); ?></span>
					<?php endif; ?>
				</span>

				<span class="whats-on-feature__bottom">
					<span class="whats-on-feature__text">
						<span class="whats-on-feature__title"><?php echo esc_html( $feature['title'] ); ?></span>
						<?php $render_loc( $feature['location'] ); ?>
					</span>
					<span class="icon-button icon-button--light whats-on-feature__arrow" aria-hidden="true"><?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
				</span>
			</a>
		</div>

		<div class="whats-on-events__side">
			<?php foreach ( $side as $ev ) : ?>
			<a class="event-card-sm" href="<?php echo esc_url( $ev['permalink'] ); ?>" aria-label="<?php echo esc_attr( $ev['title'] ); ?>">
				<figure class="event-card-sm__image"><img src="<?php echo esc_url( $ev['image'] ); ?>" alt=""/></figure>
				<span class="event-card-sm__body">
					<span class="event-card-sm__top">
						<?php $s_meta = $ev['time'] ? $ev['time'] : $ev['date_display']; ?>
						<span class="event-card-sm__time"><?php echo esc_html( $s_meta ); ?></span>
						<span class="event-card-sm__arrow" aria-hidden="true"><?php echo $arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</span>
					<span class="event-card-sm__title"><?php echo esc_html( $ev['title'] ); ?></span>
					<?php $render_loc( $ev['location'] ); ?>
				</span>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
