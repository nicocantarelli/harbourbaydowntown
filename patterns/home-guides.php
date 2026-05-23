<?php
/**
 * Title: Home Guides
 * Slug: harbour-bay-downtown/home-guides
 * Categories: harbour-bay-downtown
 * Description: Tabbed guide articles driven by blog posts — one feature card and two stacked compact cards per audience.
 * Block Types:
 * Viewport Width: 1440
 */

$guides_data = function_exists( 'hbd_get_guides_data' ) ? hbd_get_guides_data() : array();

if ( empty( $guides_data ) ) {
	return; // No audiences with posts — render nothing.
}

$read_more_label = get_theme_mod( 'hbd_guides_readmore_label', 'Read More' );
$read_more_url   = get_theme_mod( 'hbd_guides_readmore_url', '' );

// Fall back to the blog page (then the site home) when no link is set.
if ( ! $read_more_url ) {
	$posts_page_id = (int) get_option( 'page_for_posts' );
	$read_more_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
}
?>
<!-- wp:group {"tagName":"section","className":"home-guides","layout":{"type":"default"}} -->
<section class="wp-block-group home-guides">
	<!-- wp:group {"className":"home-guides__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group home-guides__head">
		<!-- wp:html -->
		<div class="tabs" data-tabs role="tablist" aria-label="<?php esc_attr_e( 'Guide audience', 'harbour-bay-downtown' ); ?>">
			<?php
			$is_first = true;
			foreach ( $guides_data as $slug => $group ) :
				?>
				<button type="button" class="tab<?php echo $is_first ? ' is-active' : ''; ?>" data-tab="<?php echo esc_attr( $slug ); ?>" role="tab" aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="guides-panel-<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $group['term']->name ); ?></button>
				<?php
				$is_first = false;
			endforeach;
			?>
		</div>
		<!-- /wp:html -->

		<!-- wp:buttons {"className":"home-guides__cta"} -->
		<div class="wp-block-buttons home-guides__cta">
			<!-- wp:button {"className":"is-style-pill-big is-style-pill-big-dark"} -->
			<div class="wp-block-button is-style-pill-big is-style-pill-big-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $read_more_url ); ?>"><?php echo esc_html( $read_more_label ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<?php
	$is_first = true;
	foreach ( $guides_data as $slug => $group ) :
		$feature    = $group['feature'];
		$card_total = 1 + count( $group['cards'] ); // feature + compact cards (1–3)
		?>
		<!-- wp:html -->
		<div class="wp-block-group home-guides__grid home-guides__grid--cards-<?php echo (int) $card_total; ?>" id="guides-panel-<?php echo esc_attr( $slug ); ?>" data-panel="<?php echo esc_attr( $slug ); ?>" role="tabpanel"<?php echo $is_first ? '' : ' hidden'; ?>>
			<div class="wp-block-group home-guides__feature">
				<a class="wp-block-group card card--type-4 card--link" href="<?php echo esc_url( $feature['permalink'] ); ?>" aria-label="<?php echo esc_attr( $feature['title'] ); ?>">
					<div class="wp-block-group card__image">
						<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $feature['image'] ); ?>" alt=""/></figure>
						<?php if ( $feature['category'] ) : ?>
							<span class="tag-chip tag-chip--inverse card__chip-tl"><?php echo esc_html( $feature['category'] ); ?></span>
						<?php endif; ?>
					</div>

					<div class="wp-block-group card__content">
						<div class="wp-block-group card__head">
							<h3 class="wp-block-heading card__title"><?php echo esc_html( $feature['title'] ); ?></h3>
							<div class="wp-block-group card__meta">
								<span class="tag-chip tag-chip--small"><?php echo esc_html( $feature['date'] ); ?></span>
								<span class="tag-chip tag-chip--small"><?php echo esc_html( $feature['read_time'] ); ?></span>
							</div>
						</div>
						<p class="card__body"><?php echo esc_html( $feature['excerpt'] ); ?></p>
					</div>
				</a>
			</div>

			<div class="wp-block-group home-guides__stack">
				<?php foreach ( $group['cards'] as $card ) : ?>
					<a class="wp-block-group card card--type-4 card--type-4-sm card--link" href="<?php echo esc_url( $card['permalink'] ); ?>" aria-label="<?php echo esc_attr( $card['title'] ); ?>">
						<div class="wp-block-group card__image">
							<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
						</div>

						<div class="wp-block-group card__content">
							<div class="wp-block-group card__head">
								<?php if ( $card['category'] ) : ?>
									<span class="tag-chip tag-chip--solid-dark"><?php echo esc_html( $card['category'] ); ?></span>
								<?php endif; ?>
								<div class="wp-block-group card__meta">
									<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['date'] ); ?></span>
									<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['read_time'] ); ?></span>
								</div>
							</div>
							<h4 class="wp-block-heading card__title"><?php echo esc_html( $card['title'] ); ?></h4>
							<p class="card__body"><?php echo esc_html( $card['excerpt'] ); ?></p>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- /wp:html -->
		<?php
		$is_first = false;
	endforeach;
	?>
</section>
<!-- /wp:group -->
