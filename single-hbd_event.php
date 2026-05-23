<?php
/**
 * Single Event / Promotion — detail page (image, information, date, time,
 * location + map, and a link/file CTA).
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // Float the header over the hero image.

get_header();

while ( have_posts() ) :
	the_post();

	$event = hbd_event_view_model( get_post() );
	$cta   = hbd_event_cta( $event['id'] );
	$map   = hbd_map_embed( $event['map'] ? $event['map'] : $event['location'], $event['title'] );
	?>
	<article <?php post_class( 'event-detail' ); ?>>
		<header class="event-hero" style="background-image:url('<?php echo esc_url( $event['image'] ); ?>');">
			<div class="event-hero__scrim" aria-hidden="true"></div>
			<div class="event-hero__inner">
				<?php if ( $event['type_name'] ) : ?>
					<span class="tag-chip tag-chip--inverse event-hero__type"><?php echo esc_html( $event['type_name'] ); ?></span>
				<?php endif; ?>
				<h1 class="event-hero__title"><?php the_title(); ?></h1>
			</div>
		</header>

		<div class="site-content">
			<div class="event-detail__body">
				<div class="event-detail__main">
					<?php the_content(); ?>

					<?php if ( $cta ) : ?>
						<div class="wp-block-buttons event-detail__cta">
							<div class="wp-block-button is-style-pill-big is-style-pill-big-dark">
								<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta['is_file'] ? ' download' : ' target="_blank" rel="noopener"'; ?>><?php echo esc_html( $cta['label'] ); ?></a>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<aside class="event-detail__meta">
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

					<?php if ( $map ) : ?>
						<div class="event-detail__map"><?php echo $map; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — built/escaped in hbd_map_embed() ?></div>
					<?php endif; ?>
				</aside>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
