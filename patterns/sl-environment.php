<?php
/**
 * Title: Sales & Leasing — Integrated Environment
 * Slug: harbour-bay-downtown/sl-environment
 * Categories: harbour-bay-downtown
 * Description: A centered title above an image collage with a central text card and labelled places (dot + line connectors). Editable via Customizer → Sales & Leasing Page → Sales & Leasing — Integrated Environment.
 * Inserter: no
 * Viewport Width: 1440
 */

$title    = nl2br( esc_html( get_theme_mod( 'hbd_sl_env_title', 'Integrated Environment' ) ) );
$tag      = get_theme_mod( 'hbd_sl_env_tag', 'Connected District' );
$body_raw = get_theme_mod( 'hbd_sl_env_body', "Visitors don't just pass through Harbour Bay Downtown.\n\nThey stay, explore, dine, shop, and spend time across the district, creating strong demand for F&B, retail, and everyday services." );
$paras    = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', $body_raw ) ), 'strlen' );

// Collage images (positions handled in CSS) — Customizer upload per slot, else the bundled PNG.
$images = array();
for ( $i = 1; $i <= 5; $i++ ) {
	$images[] = hbd_resolve_image( "hbd_sl_env_image{$i}_id", "sl-env-{$i}.png" );
}

$labels_raw = get_theme_mod( 'hbd_sl_env_labels', "Hotels\nMall\nSeaside restaurants\nResidences\nOffices" );
$labels     = array_slice( array_values( array_filter( array_map( 'trim', preg_split( '/\R+/', (string) $labels_raw ) ), 'strlen' ) ), 0, 5 );
?>
<!-- wp:group {"tagName":"section","className":"sl-environment","layout":{"type":"default"}} -->
<section class="wp-block-group sl-environment">
	<!-- wp:heading {"level":2,"className":"sl-environment__title","textAlign":"center"} -->
	<h2 class="wp-block-heading sl-environment__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="sl-environment__collage">
		<?php foreach ( $images as $i => $file ) : ?>
		<figure class="sl-environment__img sl-environment__img--<?php echo (int) ( $i + 1 ); ?>"><img src="<?php echo esc_url( $file ); ?>" alt=""/></figure>
		<?php endforeach; ?>

		<div class="sl-environment__card">
			<?php if ( $tag ) : ?>
			<div class="sl-environment__tags">
				<span class="decor-ring" aria-hidden="true"></span>
				<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
			</div>
			<?php endif; ?>
			<div class="sl-environment__body">
				<?php foreach ( $paras as $para ) : ?>
				<p><?php echo esc_html( $para ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>

		<?php foreach ( $labels as $i => $label ) : ?>
		<span class="sl-environment__caption sl-environment__caption--<?php echo (int) ( $i + 1 ); ?>">
			<span class="sl-environment__caption-line" aria-hidden="true"></span>
			<span class="sl-environment__caption-label"><?php echo esc_html( $label ); ?></span>
		</span>
		<?php endforeach; ?>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
