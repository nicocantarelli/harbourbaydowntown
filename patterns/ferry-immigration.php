<?php
/**
 * Title: Ferries — Immigration & Passenger Information
 * Slug: harbour-bay-downtown/ferry-immigration
 * Categories: harbour-bay-downtown
 * Description: A tag + title on the left, with grouped FAQ accordions on the right. Tag, title, and the three FAQ groups (heading + Question | Answer lines) are editable via Customizer → Ferries Page → Ferries — Immigration & Info.
 * Inserter: no
 * Viewport Width: 1440
 */

$tag   = get_theme_mod( 'hbd_ferries_info_tag', 'Ferry Terminal' );
$title = nl2br( esc_html( get_theme_mod( 'hbd_ferries_info_title', 'Immigration & Passenger Information' ) ) );

// FAQ groups come from the Customizer (Ferries — Immigration & Info). Defaults
// live in hbd_ferries_faq_defaults(). Empty groups are skipped.
$groups = array();
foreach ( hbd_ferries_faq_defaults() as $n => $default ) {
	$group_title = get_theme_mod( "hbd_ferries_faq{$n}_title", $default[0] );
	$items       = hbd_parse_qa_lines( get_theme_mod( "hbd_ferries_faq{$n}_items", $default[1] ) );
	if ( '' === trim( (string) $group_title ) || empty( $items ) ) {
		continue;
	}
	$groups[] = array(
		'title' => $group_title,
		'items' => $items,
	);
}
?>
<!-- wp:group {"tagName":"section","className":"ferry-info","layout":{"type":"default"}} -->
<section class="wp-block-group ferry-info">
	<!-- wp:html -->
	<?php if ( $tag ) : ?>
	<div class="ferry-info__tags">
		<span class="decor-ring" aria-hidden="true"></span>
		<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
	</div>
	<?php endif; ?>

	<div class="ferry-info__cols">
		<h2 class="ferry-info__title"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>

		<div class="ferry-info__groups">
			<?php foreach ( $groups as $group ) : ?>
		<div class="ferry-faq">
			<h3 class="ferry-faq__title"><?php echo esc_html( $group['title'] ); ?></h3>
			<div class="ferry-faq__items">
				<?php foreach ( $group['items'] as $item ) : ?>
				<details class="ferry-faq__item"<?php echo ! empty( $item['open'] ) ? ' open' : ''; ?>>
					<summary class="ferry-faq__q"><?php echo esc_html( $item['q'] ); ?></summary>
					<div class="ferry-faq__a"><p><?php echo esc_html( $item['a'] ); ?></p></div>
				</details>
				<?php endforeach; ?>
			</div>
		</div>
			<?php endforeach; ?>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
