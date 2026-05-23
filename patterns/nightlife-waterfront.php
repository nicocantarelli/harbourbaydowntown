<?php
/**
 * Title: Nightlife — By the Waterfront
 * Slug: harbour-bay-downtown/nightlife-waterfront
 * Categories: harbour-bay-downtown
 * Description: Centered title + text column + three-image collage with captions. Same layout as the About "A Place for Visits…" section (reuses its .about-place styles). Editable via Customizer → Nightlife Page → Nightlife — By the Waterfront.
 * Inserter: no
 * Viewport Width: 1440
 */

$title_lines = explode( "\n", (string) get_theme_mod( 'hbd_nightlife_waterfront_title', 'By the Waterfront' ) );
$tag         = get_theme_mod( 'hbd_nightlife_waterfront_tag', 'Night Strolls' );
$heading_raw = get_theme_mod( 'hbd_nightlife_waterfront_heading', '' );
$heading     = nl2br( esc_html( $heading_raw ) );
$body_raw    = get_theme_mod( 'hbd_nightlife_waterfront_body', "After dinner, many visitors take a walk along the promenade. It's open, comfortable, and easy to navigate. Some stop for a drink by the water.\n\nOthers simply enjoy the view and the atmosphere. It's relaxed, but not quiet. Social, but not overwhelming." );
$body_paras  = preg_split( '/\n\s*\n/', trim( $body_raw ) );

$img1 = hbd_resolve_image( 'hbd_nightlife_waterfront_image1_id', 'nightlife-waterfront-1.png' );
$img2 = hbd_resolve_image( 'hbd_nightlife_waterfront_image2_id', 'nightlife-waterfront-2.png' );
$img3 = hbd_resolve_image( 'hbd_nightlife_waterfront_image3_id', 'nightlife-waterfront-3.png' );

$cap1 = get_theme_mod( 'hbd_nightlife_waterfront_caption1', 'Promenade' );
$cap2 = get_theme_mod( 'hbd_nightlife_waterfront_caption2', 'Altitude Rooftop' );
?>
<!-- wp:group {"tagName":"section","className":"about-place nightlife-waterfront","layout":{"type":"default"}} -->
<section class="wp-block-group about-place nightlife-waterfront">
	<!-- wp:heading {"level":2,"className":"about-place__title"} -->
	<h2 class="wp-block-heading about-place__title"><?php
	foreach ( $title_lines as $title_line ) {
		echo '<span class="about-place__title-line">' . esc_html( $title_line ) . '</span>';
	}
	?></h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"about-place__row","layout":{"type":"default"}} -->
	<div class="wp-block-group about-place__row">
		<!-- wp:group {"className":"about-place__text","layout":{"type":"default"}} -->
		<div class="wp-block-group about-place__text">
			<!-- wp:html -->
			<div class="about-place__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<!-- /wp:html -->

			<!-- wp:group {"className":"about-place__copy","layout":{"type":"default"}} -->
			<div class="wp-block-group about-place__copy">
				<?php if ( $heading_raw ) : ?>
				<!-- wp:heading {"level":3,"className":"about-place__heading"} -->
				<h3 class="wp-block-heading about-place__heading"><?php echo $heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h3>
				<!-- /wp:heading -->
				<?php endif; ?>

				<?php foreach ( $body_paras as $para ) : ?>
				<!-- wp:paragraph {"className":"about-place__body"} -->
				<p class="about-place__body"><?php echo esc_html( trim( $para ) ); ?></p>
				<!-- /wp:paragraph -->
				<?php endforeach; ?>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:html -->
		<div class="about-place__collage">
			<figure class="about-place__img about-place__img--1"><img src="<?php echo esc_url( $img1 ); ?>" alt=""/></figure>
			<figure class="about-place__img about-place__img--2"><img src="<?php echo esc_url( $img2 ); ?>" alt=""/></figure>
			<figure class="about-place__img about-place__img--3"><img src="<?php echo esc_url( $img3 ); ?>" alt=""/></figure>

			<?php if ( $cap1 ) : ?>
			<span class="about-place__caption about-place__caption--1">
				<span class="about-place__caption-line" aria-hidden="true"></span>
				<span class="about-place__caption-label"><?php echo esc_html( $cap1 ); ?></span>
			</span>
			<?php endif; ?>

			<?php if ( $cap2 ) : ?>
			<span class="about-place__caption about-place__caption--2">
				<span class="about-place__caption-line" aria-hidden="true"></span>
				<span class="about-place__caption-label"><?php echo esc_html( $cap2 ); ?></span>
			</span>
			<?php endif; ?>
		</div>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
