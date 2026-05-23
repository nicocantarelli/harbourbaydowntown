<?php
/**
 * Title: Live & Work Hero
 * Slug: harbour-bay-downtown/livework-hero
 * Categories: harbour-bay-downtown
 * Description: Full-screen hero with a centered title, a vertical line decoration, and a subtitle. Editable via Customizer → Live & Work Page → Live & Work — Hero.
 * Inserter: no
 * Viewport Width: 1440
 */

$bg_url        = hbd_resolve_image( 'hbd_livework_hero_image_id', 'livework-hero.png' );
$heading_raw   = get_theme_mod( 'hbd_livework_hero_title', 'Space to Work, Places to Live' );
$heading_html  = nl2br( esc_html( $heading_raw ) );
$subtitle_raw  = get_theme_mod( 'hbd_livework_hero_subtitle', 'Harbour Bay Downtown brings together office, retail, and residential opportunities in one connected waterfront district near the international ferry terminal.' );
$subtitle_html = nl2br( esc_html( $subtitle_raw ) );
?>
<!-- wp:group {"tagName":"section","className":"page-hero page-hero--centered page-hero--livework","layout":{"type":"default"}} -->
<section class="wp-block-group page-hero page-hero--centered page-hero--livework">
	<!-- wp:html -->
	<figure class="page-hero__background"><img src="<?php echo esc_url( $bg_url ); ?>" alt=""/></figure>
	<!-- /wp:html -->

	<!-- wp:group {"className":"page-hero__inner","layout":{"type":"default"}} -->
	<div class="wp-block-group page-hero__inner">
		<!-- wp:heading {"level":1,"className":"page-hero__title","textColor":"base"} -->
		<h1 class="wp-block-heading page-hero__title has-base-color has-text-color"><?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h1>
		<!-- /wp:heading -->

		<?php if ( $subtitle_raw ) : ?>
		<!-- wp:html -->
		<div class="page-hero__sub">
			<span class="page-hero__line" aria-hidden="true"></span>
			<p class="page-hero__subtitle"><?php echo $subtitle_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></p>
		</div>
		<!-- /wp:html -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->
</section>
<!-- /wp:group -->
