<?php
/**
 * Title: About — A Place for Visits, Living, and Work
 * Slug: harbour-bay-downtown/about-place
 * Categories: harbour-bay-downtown
 * Description: Centered title, a text column (tag + heading + body), and a three-image collage with line captions. Editable via Customizer → Theme Options → About — Live & Work.
 * Inserter: no
 * Viewport Width: 1440
 */

$place_title_lines = explode( "\n", (string) get_theme_mod( 'hbd_about_place_title', "A Place for Visits,\nLiving, and Work" ) );
$place_tag     = get_theme_mod( 'hbd_about_place_tag', 'Live & Work' );
$place_heading = nl2br( esc_html( get_theme_mod( 'hbd_about_place_heading', 'Where stays, work, and daily life meet' ) ) );
$place_body    = get_theme_mod( 'hbd_about_place_body', 'Harbour Bay Downtown brings together lifestyle spaces, homes, and offices in one connected district.' );

$place_img1 = hbd_resolve_image( 'hbd_about_place_image1_id', 'about-place-1.png' );
$place_img2 = hbd_resolve_image( 'hbd_about_place_image2_id', 'about-place-2.png' );
$place_img3 = hbd_resolve_image( 'hbd_about_place_image3_id', 'about-place-3.png' );

$place_cap1 = get_theme_mod( 'hbd_about_place_caption1', 'HBB Residences' );
$place_cap2 = get_theme_mod( 'hbd_about_place_caption2', 'Menara Aria' );
?>
<!-- wp:group {"tagName":"section","className":"about-place","layout":{"type":"default"}} -->
<section class="wp-block-group about-place">
	<!-- wp:heading {"level":2,"className":"about-place__title"} -->
	<h2 class="wp-block-heading about-place__title"><?php
	foreach ( $place_title_lines as $place_title_line ) {
		echo '<span class="about-place__title-line">' . esc_html( $place_title_line ) . '</span>';
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
				<span class="tag-chip"><?php echo esc_html( $place_tag ); ?></span>
			</div>
			<!-- /wp:html -->

			<!-- wp:group {"className":"about-place__copy","layout":{"type":"default"}} -->
			<div class="wp-block-group about-place__copy">
				<!-- wp:heading {"level":3,"className":"about-place__heading"} -->
				<h3 class="wp-block-heading about-place__heading"><?php echo $place_heading; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h3>
				<!-- /wp:heading -->

				<!-- wp:paragraph {"className":"about-place__body"} -->
				<p class="about-place__body"><?php echo esc_html( $place_body ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->

		<!-- wp:html -->
		<div class="about-place__collage">
			<figure class="about-place__img about-place__img--1"><img src="<?php echo esc_url( $place_img1 ); ?>" alt=""/></figure>
			<figure class="about-place__img about-place__img--2"><img src="<?php echo esc_url( $place_img2 ); ?>" alt=""/></figure>
			<figure class="about-place__img about-place__img--3"><img src="<?php echo esc_url( $place_img3 ); ?>" alt=""/></figure>

			<?php if ( $place_cap1 ) : ?>
			<span class="about-place__caption about-place__caption--1">
				<span class="about-place__caption-line" aria-hidden="true"></span>
				<span class="about-place__caption-label"><?php echo esc_html( $place_cap1 ); ?></span>
			</span>
			<?php endif; ?>

			<?php if ( $place_cap2 ) : ?>
			<span class="about-place__caption about-place__caption--2">
				<span class="about-place__caption-line" aria-hidden="true"></span>
				<span class="about-place__caption-label"><?php echo esc_html( $place_cap2 ); ?></span>
			</span>
			<?php endif; ?>
		</div>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
