<?php
/**
 * Title: Magazine — What You'll Find Inside
 * Slug: harbour-bay-downtown/magazine-inside
 * Categories: harbour-bay-downtown
 * Description: A centered title + subtitle above a large open-magazine image, with short feature labels (dot + line connectors) flanking it — three on the left, three on the right. Editable via Customizer → Magazine Page → Magazine — What You'll Find Inside.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_magazine_inside_title', "What You'll Find Inside" ) ) );
$subtitle = get_theme_mod( 'hbd_magazine_inside_subtitle', 'The focus is simple: helpful information without unnecessary noise.' );
$img      = hbd_resolve_image( 'hbd_magazine_inside_image_id', 'magazine-inside.png' );

// Up to six labels, one per line. The first three sit on the left, the next
// three on the right (each at a fixed position around the image).
$labels_raw = get_theme_mod( 'hbd_magazine_inside_labels', "Family-friendly activities\nSpa and wellness spots\nWeekend itineraries\nDining recommendations\nNew openings and updates\nProperty and lifestyle features" );
$labels     = array_values( array_filter( array_map( 'trim', preg_split( '/\R+/', (string) $labels_raw ) ), 'strlen' ) );
$labels     = array_slice( $labels, 0, 6 );

// Fixed slots (matching the Figma layout): l1–l3 on the left, r1–r3 on the right.
$slots = array( 'l1', 'l2', 'l3', 'r1', 'r2', 'r3' );
?>
<!-- wp:group {"tagName":"section","className":"magazine-inside","layout":{"type":"default"}} -->
<section class="wp-block-group magazine-inside">
	<!-- wp:group {"className":"magazine-inside__head","layout":{"type":"default"}} -->
	<div class="wp-block-group magazine-inside__head">
		<!-- wp:heading {"level":2,"className":"magazine-inside__title","textAlign":"center"} -->
		<h2 class="wp-block-heading magazine-inside__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<!-- /wp:heading -->

		<?php if ( $subtitle ) : ?>
		<!-- wp:paragraph {"className":"magazine-inside__subtitle","align":"center"} -->
		<p class="magazine-inside__subtitle has-text-align-center"><?php echo esc_html( $subtitle ); ?></p>
		<!-- /wp:paragraph -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:html -->
	<div class="magazine-inside__stage">
		<figure class="magazine-inside__media"><img src="<?php echo esc_url( $img ); ?>" alt=""/></figure>

		<?php
		foreach ( $labels as $i => $label ) :
			$slot = $slots[ $i ];
			$side = ( 'r' === $slot[0] ) ? 'right' : 'left';
			?>
			<span class="magazine-inside__label magazine-inside__label--<?php echo esc_attr( $slot ); ?>">
				<?php if ( 'right' === $side ) : ?>
					<span class="magazine-inside__line" aria-hidden="true"></span>
					<span class="magazine-inside__label-text"><?php echo esc_html( $label ); ?></span>
				<?php else : ?>
					<span class="magazine-inside__label-text"><?php echo esc_html( $label ); ?></span>
					<span class="magazine-inside__line magazine-inside__line--flip" aria-hidden="true"></span>
				<?php endif; ?>
			</span>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
