<?php
/**
 * Title: K Square — Nearby Area & Surroundings
 * Slug: harbour-bay-downtown/ksquare-nearby
 * Categories: harbour-bay-downtown
 * Description: A title + body on the left and a set of full-image place cards on the right (one wide card above two smaller ones). Title/body editable via Customizer → K Square Mall Page. The cards are static placeholders for now.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_ksquare_nearby_title', "Nearby Area\n& Surroundings" ) ) );

// Line breaks are preserved as-is (single Enter = a tight line break; a blank
// line = real space). No paragraph margins are added.
$body = nl2br( esc_html( get_theme_mod( 'hbd_ksquare_nearby_body', 'K Square Mall is part of a growing lifestyle area. This makes the district suitable for short stays, business visits, and weekend trips.' ) ) );

$img = HBD_THEME_URI . '/assets/images/';

// Names honour line breaks (rendered via nl2br) so titles can sit on two lines.
// `link` is empty for now → cards render as plain (non-interactive) tiles with no
// arrow. Give a card a URL and it becomes a link with the hover treatment.
$feature = array( 'image' => $img . 'ksquare-nearby-swiss.png', 'name' => "Swiss-Belhotel\nExpress", 'link' => '' );
$cards   = array(
	array( 'image' => $img . 'ksquare-nearby-eska.png',   'name' => 'Eska Hotel',           'link' => '' ),
	array( 'image' => $img . 'ksquare-nearby-padang.png', 'name' => "Padang Golf\nSukajadi", 'link' => '' ),
);

$arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg>';

// Render a place card. With a link it's an <a> (arrow + hover via --link); without
// one it's a plain <div> — no arrow, no hover.
$render_place_card = static function ( array $card, $extra_class = '' ) use ( $arrow_svg ) {
	$has_link = ! empty( $card['link'] );
	$tag      = $has_link ? 'a' : 'div';
	$classes  = trim( 'ks-place-card ' . $extra_class . ( $has_link ? ' ks-place-card--link' : '' ) );
	?>
	<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — 'a' or 'div' ?> class="<?php echo esc_attr( $classes ); ?>"<?php if ( $has_link ) : ?> href="<?php echo esc_url( $card['link'] ); ?>" aria-label="<?php echo esc_attr( $card['name'] ); ?>"<?php endif; ?>>
		<figure class="ks-place-card__media"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
		<div class="ks-place-card__top">
			<h3 class="ks-place-card__name"><?php echo nl2br( esc_html( $card['name'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h3>
			<?php if ( $has_link ) : ?>
			<span class="icon-button icon-button--light icon-button--lg ks-place-card__arrow" aria-hidden="true"><?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php endif; ?>
		</div>
	</<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — 'a' or 'div' ?>>
	<?php
};
?>
<!-- wp:group {"tagName":"section","className":"ks-nearby","layout":{"type":"default"}} -->
<section class="wp-block-group ks-nearby">
	<!-- wp:html -->
	<div class="ks-nearby__intro">
		<h2 class="ks-nearby__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
		<p class="ks-nearby__body"><?php echo $body; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></p>
	</div>

	<div class="ks-nearby__cards">
		<?php $render_place_card( $feature, 'ks-place-card--wide' ); ?>

		<div class="ks-nearby__row">
			<?php foreach ( $cards as $card ) : ?>
				<?php $render_place_card( $card ); ?>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
