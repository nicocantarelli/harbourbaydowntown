<?php
/**
 * Title: Wellness — Easy to Fit
 * Slug: harbour-bay-downtown/wellness-easyfit
 * Categories: harbour-bay-downtown
 * Description: A centered title with a faint background word (same treatment as the homepage "Explore" section), above a card with the text on the LEFT and a large image on the RIGHT (the "Our Story" card, mirrored). Editable via Customizer → Wellness & Spa Page → Wellness — Easy to Fit.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_wellness_easyfit_title', 'Easy to Fit' ) ) );
$decor = get_theme_mod( 'hbd_wellness_easyfit_decor', 'into your day' );
$tag   = get_theme_mod( 'hbd_wellness_easyfit_tag', 'Walkable Wellness' );
$img   = hbd_resolve_image( 'hbd_wellness_easyfit_image_id', 'wellness-easyfit.png' );

$body_raw = get_theme_mod( 'hbd_wellness_easyfit_body', "Most wellness and spa spots at Harbour Bay Downtown are within walking distance of hotels, dining, and the ferry.\nWhether you're planning a longer spa session or just a quick massage, it's easy to fit in without changing your plans." );
// Each line (single Enter) becomes its own paragraph; blank lines collapse.
$body_paras = preg_split( '/\R+/', trim( $body_raw ) );
$body_paras = array_filter( array_map( 'trim', $body_paras ), 'strlen' );
?>
<!-- wp:group {"tagName":"section","className":"home-explore wellness-easyfit","layout":{"type":"default"}} -->
<section class="wp-block-group home-explore wellness-easyfit">
	<!-- wp:group {"className":"home-explore__head","layout":{"type":"default"}} -->
	<div class="wp-block-group home-explore__head">
		<!-- wp:paragraph {"className":"decor-text home-explore__decor"} -->
		<p class="decor-text home-explore__decor"><?php echo esc_html( $decor ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"level":2,"className":"home-explore__title","textAlign":"center"} -->
		<h2 class="wp-block-heading home-explore__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="about-story__card">
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

		<figure class="about-story__media"><img src="<?php echo esc_url( $img ); ?>" alt=""/></figure>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
