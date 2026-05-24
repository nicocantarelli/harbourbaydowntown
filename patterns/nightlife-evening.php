<?php
/**
 * Title: Nightlife — A Smarter Way to Spend the Evening
 * Slug: harbour-bay-downtown/nightlife-evening
 * Categories: harbour-bay-downtown
 * Description: Same card layout as the About "Our Story" section (image left, tag + body right) but with the staggered/offset title from the "A Place for Visits…" section. Editable via Customizer → Nightlife Page → Nightlife — A Smarter Way.
 * Inserter: no
 * Viewport Width: 1440
 */

$title_lines = explode( "\n", (string) get_theme_mod( 'hbd_nightlife_evening_title', "A Smarter Way\nto Spend the Evening" ) );
$tag         = get_theme_mod( 'hbd_nightlife_evening_tag', 'Night Strolls' );
$img         = hbd_resolve_image( 'hbd_nightlife_evening_image_id', 'nightlife-evening.png' );

$body_raw   = get_theme_mod( 'hbd_nightlife_evening_body', 'Nightlife at Harbour Bay works because of its simplicity. Dining, drinks, hotels, and the ferry terminal are all connected in one district.' );
$body_paras = preg_split( '/\n\s*\n/', trim( $body_raw ) );
?>
<!-- wp:group {"tagName":"section","className":"about-story nightlife-evening","layout":{"type":"default"}} -->
<section class="wp-block-group about-story nightlife-evening">
	<!-- wp:heading {"level":2,"className":"about-place__title"} -->
	<h2 class="wp-block-heading about-place__title"><?php
	foreach ( $title_lines as $title_line ) {
		echo '<span class="about-place__title-line">' . esc_html( $title_line ) . '</span>';
	}
	?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="about-story__card">
		<figure class="about-story__media"><img src="<?php echo esc_url( $img ); ?>" alt=""/></figure>

		<div class="about-story__body">
			<div class="about-story__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>

			<div class="about-story__text">
				<?php foreach ( $body_paras as $para ) : ?>
					<p><?php echo esc_html( trim( $para ) ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
