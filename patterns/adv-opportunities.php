<?php
/**
 * Title: Advertising — Advertising Opportunities
 * Slug: harbour-bay-downtown/adv-opportunities
 * Categories: harbour-bay-downtown
 * Description: A centered title above a tag + benefits list (left) and an image collage with labelled placements (right). Editable via Customizer → Advertising Page → Advertising — Advertising Opportunities.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_adv_opps_title', 'Advertising Opportunities' ) ) );
$tag   = get_theme_mod( 'hbd_adv_opps_tag', 'Why It Matters' );
$items = hbd_parse_amenities( get_theme_mod( 'hbd_adv_opps_items', "boat: Direct exposure to arriving and departing ferry passengers\npin: Located immediately outside the ferry terminal\nfootfall: High foot traffic across hotels, dining, spas, and shopping\ncalendar: Strong peaks during weekends, holidays, and school breaks" ) );

// Collage images keyed by slot (positions handled in CSS via the modifier class).
// Each slot is a Customizer upload, falling back to the bundled adv-opp-N.png.
$images = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$images[] = hbd_resolve_image( "hbd_adv_opps_image{$i}_id", "adv-opp-{$i}.png" );
}

// Up to five placement labels, one per line, mapped to fixed slots around the collage.
$labels_raw = get_theme_mod( 'hbd_adv_opps_labels', "Static advertising placements\nLED digital screens\nDining & lifestyle\nMain walkways\nArrival & departure zones" );
$labels     = array_slice( array_values( array_filter( array_map( 'trim', preg_split( '/\R+/', (string) $labels_raw ) ), 'strlen' ) ), 0, 5 );
?>
<!-- wp:group {"tagName":"section","className":"adv-opportunities","layout":{"type":"default"}} -->
<section class="wp-block-group adv-opportunities">
	<!-- wp:heading {"level":2,"className":"adv-opportunities__title","textAlign":"center"} -->
	<h2 class="wp-block-heading adv-opportunities__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="adv-opportunities__row">
		<div class="adv-opportunities__info">
			<?php if ( $tag ) : ?>
			<div class="adv-opportunities__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>

			<ul class="adv-opportunities__items">
				<?php foreach ( $items as $item ) : ?>
				<li class="adv-opportunities__item">
					<span class="adv-opportunities__item-icon" aria-hidden="true"><?php echo hbd_amenity_icon_svg( $item['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span class="adv-opportunities__item-text"><?php echo esc_html( $item['text'] ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="adv-opportunities__collage">
			<?php foreach ( $images as $i => $file ) : ?>
			<figure class="adv-opportunities__img adv-opportunities__img--<?php echo (int) ( $i + 1 ); ?>"><img src="<?php echo esc_url( $file ); ?>" alt=""/></figure>
			<?php endforeach; ?>

			<?php foreach ( $labels as $i => $label ) : ?>
			<span class="adv-opportunities__caption adv-opportunities__caption--<?php echo (int) ( $i + 1 ); ?>">
				<span class="adv-opportunities__caption-line" aria-hidden="true"></span>
				<span class="adv-opportunities__caption-label"><?php echo esc_html( $label ); ?></span>
			</span>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
