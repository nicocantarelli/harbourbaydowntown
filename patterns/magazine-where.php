<?php
/**
 * Title: Magazine — Where to Find the Magazine
 * Slug: harbour-bay-downtown/magazine-where
 * Categories: harbour-bay-downtown
 * Description: A light card — tag + title on the left, body + amenities on the right (reuses the Live & Work "Coming Soon" card layout). Editable via Customizer → Magazine Page → Magazine — Where to Find.
 * Inserter: no
 * Viewport Width: 1440
 */

$tag       = get_theme_mod( 'hbd_magazine_where_tag', 'Availability' );
$title     = nl2br( esc_html( get_theme_mod( 'hbd_magazine_where_title', 'Where to Find the Magazine' ) ) );
$body_raw  = get_theme_mod( 'hbd_magazine_where_body', 'Printed copies of Discover Batam are available at selected locations. You can pick up a copy during your visit or browse the latest issue online.' );
$paras     = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', $body_raw ) ), 'strlen' );
$amenities = hbd_parse_amenities( get_theme_mod( 'hbd_magazine_where_amenities', "district: Harbour Bay Downtown\nhotel: Hotels within the district\npin: Selected lifestyle venues" ) );
?>
<!-- wp:group {"tagName":"section","className":"lw-coming magazine-where","layout":{"type":"default"}} -->
<section class="wp-block-group lw-coming magazine-where">
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
