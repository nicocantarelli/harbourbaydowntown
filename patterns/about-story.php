<?php
/**
 * Title: About — Our Story
 * Slug: harbour-bay-downtown/about-story
 * Categories: harbour-bay-downtown
 * Description: Centered title and a card with a large image on the left, a tag and body copy on the right. Editable via Customizer → Theme Options → About — Our Story.
 * Inserter: no
 * Viewport Width: 1440
 */

$story_title = nl2br( esc_html( get_theme_mod( 'hbd_about_story_title', 'Our Story' ) ) );
$story_tag   = get_theme_mod( 'hbd_about_story_tag', 'Waterfront District' );
$story_img   = hbd_resolve_image( 'hbd_about_story_image_id', 'about-story.jpg' );

$story_body_raw = get_theme_mod(
	'hbd_about_story_body',
	"Harbour Bay Downtown was developed as a waterfront district that brings together travel, leisure, and everyday needs in one connected area.\n\nWith direct access to the international ferry terminal, Harbour Bay Downtown welcomes visitors arriving in Batam while also serving residents and professionals who spend their days here."
);
// Split on blank lines into paragraphs.
$story_paras = preg_split( '/\n\s*\n/', trim( $story_body_raw ) );
?>
<!-- wp:group {"tagName":"section","className":"about-story","layout":{"type":"default"}} -->
<section class="wp-block-group about-story">
	<!-- wp:heading {"level":2,"className":"about-story__title","textAlign":"center"} -->
	<h2 class="wp-block-heading about-story__title has-text-align-center"><?php echo $story_title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="about-story__card">
		<figure class="about-story__media"><img src="<?php echo esc_url( $story_img ); ?>" alt=""/></figure>

		<div class="about-story__body">
			<div class="about-story__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $story_tag ); ?></span>
			</div>

			<div class="about-story__text">
				<?php foreach ( $story_paras as $para ) : ?>
					<p><?php echo esc_html( trim( $para ) ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
