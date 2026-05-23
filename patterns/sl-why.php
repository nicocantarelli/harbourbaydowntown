<?php
/**
 * Title: Sales & Leasing — Why Harbour Bay Downtown
 * Slug: harbour-bay-downtown/sl-why
 * Categories: harbour-bay-downtown
 * Description: A centered title above a text column (tag, paragraph, two stats) and a large image. Editable via Customizer → Sales & Leasing Page → Sales & Leasing — Why Harbour Bay.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_sl_why_title', 'Why Harbour Bay Downtown?' ) ) );
$tag      = get_theme_mod( 'hbd_sl_why_tag', 'Prime Location' );
$body_raw = get_theme_mod( 'hbd_sl_why_body', 'Harbour Bay Downtown is located directly next to Harbour Bay Ferry Terminal, attracting strong visitor traffic from Singapore and a growing number of travellers from Malaysia. The district also offers walkable access to hotels, dining, shopping, and lifestyle destinations, making it easy for visitors to arrive, explore, and spend time in one connected area.' );
$paras    = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', $body_raw ) ), 'strlen' );
$img      = hbd_resolve_image( 'hbd_sl_why_image_id', 'sl-why.png' );

$stats = array(
	array( 'value' => get_theme_mod( 'hbd_sl_why_stat1_value', '50' ), 'label' => get_theme_mod( 'hbd_sl_why_stat1_label', 'Minutes from Singapore' ) ),
	array( 'value' => get_theme_mod( 'hbd_sl_why_stat2_value', '2' ),  'label' => get_theme_mod( 'hbd_sl_why_stat2_label', 'Hours from Johor, Malaysia' ) ),
);
?>
<!-- wp:group {"tagName":"section","className":"sl-why","layout":{"type":"default"}} -->
<section class="wp-block-group sl-why">
	<!-- wp:heading {"level":1,"className":"sl-why__title","textAlign":"center"} -->
	<h1 class="wp-block-heading sl-why__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h1>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="sl-why__row">
		<div class="sl-why__text">
			<?php if ( $tag ) : ?>
			<div class="sl-why__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>

			<div class="sl-why__copy">
				<div class="sl-why__body">
					<?php foreach ( $paras as $para ) : ?>
					<p><?php echo esc_html( $para ); ?></p>
					<?php endforeach; ?>
				</div>

				<span class="sl-why__divider" aria-hidden="true"></span>

				<div class="sl-why__stats">
					<?php foreach ( $stats as $stat ) : ?>
					<div class="sl-why__stat">
						<span class="sl-why__stat-value" data-countup><?php echo esc_html( $stat['value'] ); ?></span>
						<span class="sl-why__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<figure class="sl-why__media"><img src="<?php echo esc_url( $img ); ?>" alt=""/></figure>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
