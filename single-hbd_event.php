<?php
/**
 * Single Event / Promotion — detail page. Shares the listing detail layout
 * (info on the left, a contained photo on the right, location map below) so
 * events, promotions and listings present consistently.
 *
 * @package HarbourBayDowntown
 */

get_header();

while ( have_posts() ) :
	the_post();

	$event   = hbd_event_view_model( get_post() );
	$cta     = hbd_event_cta( $event['id'] );
	$map     = hbd_map_embed( $event['map'] ? $event['map'] : $event['location'], $event['title'] );
	$content = trim( get_the_content() );
	?>
	<article <?php post_class( 'listing-detail' ); ?>>
		<div class="site-content">
			<div class="listing-detail__top">
				<div class="listing-detail__info">
					<?php if ( $event['type_name'] ) : ?>
						<div class="listing-detail__chip-row">
							<span class="decor-ring" aria-hidden="true"></span>
							<span class="tag-chip"><?php echo esc_html( $event['type_name'] ); ?></span>
						</div>
					<?php endif; ?>

					<h1 class="listing-detail__title"><?php the_title(); ?></h1>

					<?php if ( $content ) : ?>
						<div class="listing-detail__desc"><?php the_content(); ?></div>
					<?php endif; ?>

					<?php if ( $event['date_display'] || $event['time'] || $event['location'] ) : ?>
						<div class="listing-detail__meta">
							<?php if ( $event['date_display'] ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Date', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><?php echo esc_html( $event['date_display'] ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( $event['time'] ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Time', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><?php echo esc_html( $event['time'] ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( $event['location'] ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Location', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><?php echo esc_html( $event['location'] ); ?></span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $cta ) : ?>
						<div class="wp-block-buttons listing-detail__cta">
							<div class="wp-block-button is-style-pill-big is-style-pill-big-dark">
								<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta['is_file'] ? ' download' : ' target="_blank" rel="noopener"'; ?>><?php echo esc_html( $cta['label'] ); ?></a>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<figure class="listing-detail__image"><img src="<?php echo esc_url( $event['image'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>"/></figure>
			</div>

			<?php if ( $map ) : ?>
				<div class="listing-detail__map"><?php echo $map; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — built/escaped in hbd_map_embed() ?></div>
			<?php endif; ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
