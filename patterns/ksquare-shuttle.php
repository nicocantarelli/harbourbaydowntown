<?php
/**
 * Title: K Square — Free Shuttle
 * Slug: harbour-bay-downtown/ksquare-shuttle
 * Categories: harbour-bay-downtown
 * Description: A staggered centered title above a card with shuttle details on the left (tag, pick-up/drop-off, info items) and an image on the right. Editable via Customizer → K Square Mall Page → K Square — Free Shuttle.
 * Inserter: no
 * Viewport Width: 1440
 */

$title_lines = explode( "\n", (string) get_theme_mod( 'hbd_ksquare_shuttle_title', "Free Shuttle\nto K Square Mall" ) );
$tag         = get_theme_mod( 'hbd_ksquare_shuttle_tag', 'Shuttle' );
$pickup      = get_theme_mod( 'hbd_ksquare_shuttle_pickup', 'Outside Swiss-BelHotel Harbour Bay' );
$dropoff     = get_theme_mod( 'hbd_ksquare_shuttle_dropoff', 'K Square Mall main entrance' );
$img         = hbd_resolve_image( 'hbd_ksquare_shuttle_image_id', 'ksquare-shuttle.png' );

// Each info item: an inline icon SVG + a line of text.
$icons = array(
	'coins'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="8" r="6"/><path d="M18.09 10.37A6 6 0 1 1 10.34 18"/><path d="M7 6h1v4"/><path d="m16.71 13.88.7.71-2.82 2.82"/></svg>',
	'calendar'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 2v4M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>',
	'navigation' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>',
);

$items = array(
	array( 'icon' => 'coins',      'text' => get_theme_mod( 'hbd_ksquare_shuttle_item1', 'Complimentary for Harbour Bay visitors' ) ),
	array( 'icon' => 'calendar',   'text' => get_theme_mod( 'hbd_ksquare_shuttle_item2', 'Operates hourly (11.30am – 9.30pm)' ) ),
	array( 'icon' => 'navigation', 'text' => get_theme_mod( 'hbd_ksquare_shuttle_item3', 'Comfortable and easy to access' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"ks-shuttle","layout":{"type":"default"}} -->
<section class="wp-block-group ks-shuttle">
	<!-- wp:heading {"level":2,"className":"about-place__title ks-shuttle__title"} -->
	<h2 class="wp-block-heading about-place__title ks-shuttle__title"><?php
	foreach ( $title_lines as $title_line ) {
		echo '<span class="about-place__title-line">' . esc_html( $title_line ) . '</span>';
	}
	?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="ks-shuttle__card">
		<div class="ks-shuttle__body">
			<?php if ( $tag ) : ?>
			<div class="ks-shuttle__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>

			<dl class="ks-shuttle__details">
				<div class="ks-shuttle__detail"><dt>Pick-up location:</dt> <dd><?php echo esc_html( $pickup ); ?></dd></div>
				<div class="ks-shuttle__detail"><dt>Drop-off point:</dt> <dd><?php echo esc_html( $dropoff ); ?></dd></div>
			</dl>

			<ul class="ks-shuttle__items">
				<?php foreach ( $items as $item ) : ?>
				<li class="ks-shuttle__item">
					<span class="ks-shuttle__item-icon" aria-hidden="true"><?php echo $icons[ $item['icon'] ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php echo esc_html( $item['text'] ); ?></span>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<figure class="ks-shuttle__media"><img src="<?php echo esc_url( $img ); ?>" alt=""/></figure>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
