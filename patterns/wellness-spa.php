<?php
/**
 * Title: Wellness — Spa & Massage
 * Slug: harbour-bay-downtown/wellness-spa
 * Categories: harbour-bay-downtown
 * Description: A heading (with a pill on the right) above a carousel of full-image spa cards (Card_Type_7 — chip + arrow + title on top, feature tags at the bottom), from Listings of type Wellness in the "Spa & Massage" category. Heading + pill editable via Customizer → Wellness & Spa Page → Wellness — Spa & Massage. Falls back to placeholders until venues are added.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_wellness_spa_title', 'Spa & Massage' ) ) );
$tag   = get_theme_mod( 'hbd_wellness_spa_tag', 'Relax & Recharge' );

$cards = hbd_get_listings( 'wellness', -1, 'spa-massage' );
if ( empty( $cards ) ) {
	$img   = HBD_THEME_URI . '/assets/images/';
	$cards = array(
		array( 'image' => $img . 'wellness-spa-1.png', 'pill' => 'Hotel',      'title' => 'Quan Spa',          'tags' => array( 'Massage', 'Facial', 'Body treatments' ),    'link' => '#', 'is_external' => false ),
		array( 'image' => $img . 'wellness-spa-2.png', 'pill' => 'Standalone', 'title' => 'Eska Wellness Spa', 'tags' => array( 'Massage', 'Reflexology', 'Beauty services' ), 'link' => '#', 'is_external' => false ),
		array( 'image' => $img . 'wellness-spa-3.png', 'pill' => 'Standalone', 'title' => 'Spa Central Batam', 'tags' => array( 'Massage', 'Facial', 'Body treatments' ),    'link' => '#', 'is_external' => false ),
	);
}

$arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg>';
?>
<!-- wp:group {"tagName":"section","className":"wellness-spa","layout":{"type":"default"}} -->
<section class="wp-block-group wellness-spa" data-carousel>
	<!-- wp:html -->
	<div class="wellness-spa__head">
		<h2 class="wellness-spa__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<div class="wellness-spa__tag">
			<span class="decor-ring" aria-hidden="true"></span>
			<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
		</div>
	</div>

	<div class="carousel wellness-spa__carousel">
		<div class="carousel__track wellness-spa__track" data-carousel-track>
			<?php foreach ( $cards as $card ) : ?>
			<a class="card card--type-7 card--link" href="<?php echo esc_url( $card['link'] ); ?>"<?php echo ! empty( $card['is_external'] ) ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr( $card['title'] ); ?>">
				<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>

				<div class="card__head">
					<div class="card__top">
						<?php if ( $card['pill'] ) : ?>
						<span class="tag-chip tag-chip--inverse"><?php echo esc_html( $card['pill'] ); ?></span>
						<?php endif; ?>
						<span class="icon-button icon-button--light card__arrow" aria-hidden="true"><?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					</div>
					<h3 class="card__title"><?php echo esc_html( $card['title'] ); ?></h3>
				</div>

				<?php if ( ! empty( $card['tags'] ) ) : ?>
				<div class="card__tags">
					<?php
					// Decor rings sit BEFORE each pill except the last, which gets its
					// ring AFTER — so the row reads icon-pill-icon-pill … pill-icon.
					$last_tag = count( $card['tags'] ) - 1;
					foreach ( $card['tags'] as $i => $feature ) :
						if ( $i === $last_tag ) :
							?>
							<span class="tag-chip"><?php echo esc_html( $feature ); ?></span>
							<span class="decor-ring decor-ring--light" aria-hidden="true"></span>
							<?php
						else :
							?>
							<span class="decor-ring decor-ring--light" aria-hidden="true"></span>
							<span class="tag-chip"><?php echo esc_html( $feature ); ?></span>
							<?php
						endif;
					endforeach;
					?>
				</div>
				<?php endif; ?>
			</a>
			<?php endforeach; ?>
		</div>

		<div class="carousel__controls wellness-spa__controls">
			<div class="progress-bar"><span class="progress-bar__rail"></span><span class="progress-bar__fill" data-carousel-progress></span></div>

			<div class="carousel__nav">
				<button type="button" class="icon-button icon-button--outline" data-carousel-prev aria-label="Previous"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M21.7803 13.2197C21.4874 12.9268 21.0127 12.9268 20.7198 13.2197L14.7198 19.2197C14.4269 19.5126 14.4269 19.9873 14.7198 20.2802L20.7198 26.2802C21.0127 26.5731 21.4874 26.5731 21.7803 26.2802C22.0732 25.9873 22.0732 25.5126 21.7803 25.2197L16.3106 19.7499L21.7803 14.2802C22.0732 13.9873 22.0732 13.5126 21.7803 13.2197Z" fill="currentColor"/></svg></button>

				<button type="button" class="icon-button icon-button--outline" data-carousel-next aria-label="Next"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M18.2197 13.2197C18.5126 12.9268 18.9873 12.9268 19.2802 13.2197L25.2802 19.2197C25.5731 19.5126 25.5731 19.9873 25.2802 20.2802L19.2802 26.2802C18.9873 26.5731 18.5126 26.5731 18.2197 26.2802C17.9268 25.9873 17.9268 25.5126 18.2197 25.2197L23.6894 19.7499L18.2197 14.2802C17.9268 13.9873 17.9268 13.5126 18.2197 13.2197Z" fill="currentColor"/></svg></button>
			</div>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
