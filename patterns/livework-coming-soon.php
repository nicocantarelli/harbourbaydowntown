<?php
/**
 * Title: Live & Work — Coming Soon
 * Slug: harbour-bay-downtown/livework-coming-soon
 * Categories: harbour-bay-downtown
 * Description: A light card highlighting an upcoming development — tag + title on the left, body + amenities on the right. Shown only when "Show the Coming Soon section" is enabled in Customizer → Live & Work Page → Live & Work — Coming Soon.
 * Inserter: no
 * Viewport Width: 1440
 */

// Hidden entirely when there's nothing coming up.
if ( ! get_theme_mod( 'hbd_livework_coming_show', true ) ) {
	return;
}

$tag       = get_theme_mod( 'hbd_livework_coming_tag', 'New Development' );
$title     = nl2br( esc_html( get_theme_mod( 'hbd_livework_coming_title', 'Coming Soon' ) ) );
$body_raw  = get_theme_mod( 'hbd_livework_coming_body', "A new office building will be introduced soon at Harbour Bay Downtown, expanding the district's business space offerings. Designed for companies looking for a well connected location, this upcoming property will provide another opportunity to work within Batam's most accessible waterfront district." );
$paras     = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', $body_raw ) ), 'strlen' );
$amenities = hbd_parse_amenities( get_theme_mod( 'hbd_livework_coming_amenities', "building: New office space option coming soon\nnavigation: Strategic location near the ferry terminal\nmap: Close to hospitality, dining, and retail\nbriefcase: Ideal for growing businesses and professional services" ) );
?>
<!-- wp:group {"tagName":"section","className":"lw-coming","layout":{"type":"default"}} -->
<section class="wp-block-group lw-coming">
	<!-- wp:html -->
	<div class="lw-coming__card">
		<div class="lw-coming__head">
			<?php if ( $tag ) : ?>
			<div class="lw-coming__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>

			<h2 class="lw-coming__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		</div>

		<div class="lw-coming__info">
			<div class="lw-coming__body">
				<?php foreach ( $paras as $para ) : ?>
				<p><?php echo esc_html( $para ); ?></p>
				<?php endforeach; ?>
			</div>

			<span class="lw-coming__divider" aria-hidden="true"></span>

			<?php hbd_render_amenities( $amenities ); ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
