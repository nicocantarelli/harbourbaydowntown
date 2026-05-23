<?php
/**
 * Single Listing — detail page (hotel / restaurant / shop / wellness / nightlife).
 * Info on the left, a contained photo on the right (so modest-res photos aren't
 * stretched full-bleed), and the location map below.
 *
 * @package HarbourBayDowntown
 */

get_header();

while ( have_posts() ) :
	the_post();

	$id = get_the_ID();

	$image = get_the_post_thumbnail_url( $id, 'large' );
	if ( ! $image ) {
		$image = HBD_THEME_URI . '/assets/images/card-shop.png';
	}

	$pill        = (string) get_post_meta( $id, '_hbd_listing_pill', true );
	$description = (string) get_post_meta( $id, '_hbd_listing_description', true );
	$location    = (string) get_post_meta( $id, '_hbd_listing_location', true );
	$map_query   = (string) get_post_meta( $id, '_hbd_listing_map', true );
	$hours       = (string) get_post_meta( $id, '_hbd_listing_hours', true );
	$phone       = (string) get_post_meta( $id, '_hbd_listing_phone', true );
	$website     = (string) get_post_meta( $id, '_hbd_listing_link', true );

	$paras      = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', $description ) ), 'strlen' );
	$hour_lines = array_filter( array_map( 'trim', preg_split( '/\R+/', $hours ) ), 'strlen' );
	$map        = hbd_map_embed( $map_query ? $map_query : $location, get_the_title() );

	$terms     = get_the_terms( $id, 'listing_type' );
	$type_name = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
	?>
	<article <?php post_class( 'listing-detail' ); ?>>
		<div class="site-content">
			<div class="listing-detail__top">
				<div class="listing-detail__info">
					<?php if ( $pill ) : ?>
						<div class="listing-detail__chip-row">
							<span class="decor-ring" aria-hidden="true"></span>
							<span class="tag-chip"><?php echo esc_html( $pill ); ?></span>
						</div>
					<?php endif; ?>

					<h1 class="listing-detail__title"><?php the_title(); ?></h1>

					<?php if ( $paras ) : ?>
						<div class="listing-detail__desc">
							<?php foreach ( $paras as $para ) : ?>
								<p><?php echo esc_html( $para ); ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( $type_name || $hour_lines || $location || $phone ) : ?>
						<div class="listing-detail__meta">
							<?php if ( $type_name ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Type', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><?php echo esc_html( $type_name ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( $hour_lines ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Open hours', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><?php echo nl2br( esc_html( implode( "\n", $hour_lines ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></span>
								</div>
							<?php endif; ?>

							<?php if ( $location ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Location', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><?php echo esc_html( $location ); ?></span>
								</div>
							<?php endif; ?>

							<?php if ( $phone ) : ?>
								<div class="event-meta-item">
									<span class="event-meta-item__label"><?php esc_html_e( 'Phone', 'harbour-bay-downtown' ); ?></span>
									<span class="event-meta-item__value"><a href="<?php echo esc_attr( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></span>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $website ) : ?>
						<div class="wp-block-buttons listing-detail__cta">
							<div class="wp-block-button is-style-pill-big is-style-pill-big-dark">
								<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Visit website', 'harbour-bay-downtown' ); ?></a>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<figure class="listing-detail__image"><img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"/></figure>
			</div>

			<?php if ( $map ) : ?>
				<div class="listing-detail__map"><?php echo $map; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — built/escaped in hbd_map_embed() ?></div>
			<?php endif; ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
