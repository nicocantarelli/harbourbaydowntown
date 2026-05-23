<?php
/**
 * Title: K Square — About
 * Slug: harbour-bay-downtown/ksquare-about
 * Categories: harbour-bay-downtown
 * Description: Centered title above a four-image collage (with caption lines) on the left and a tag + body + social links on the right. Editable via Customizer → K Square Mall Page → K Square — About.
 * Inserter: no
 * Viewport Width: 1440
 */

$title = nl2br( esc_html( get_theme_mod( 'hbd_ksquare_about_title', 'About K Square Mall' ) ) );
$tag   = get_theme_mod( 'hbd_ksquare_about_tag', 'Lifestyle Mall' );

$body_raw   = get_theme_mod( 'hbd_ksquare_about_body', "K Square Mall is a family-friendly lifestyle mall located a short drive from Harbour Bay Downtown. It's a comfortable, air-conditioned space — ideal for families, groups, or anyone looking for a relaxed afternoon." );
// Each line break starts a new paragraph.
$body_paras = preg_split( '/\R+/', trim( $body_raw ) );
$body_paras = array_filter( array_map( 'trim', $body_paras ), 'strlen' );

$images = array(
	hbd_resolve_image( 'hbd_ksquare_about_image1_id', 'ksquare-about-1.png' ),
	hbd_resolve_image( 'hbd_ksquare_about_image2_id', 'ksquare-about-2.png' ),
	hbd_resolve_image( 'hbd_ksquare_about_image3_id', 'ksquare-about-3.png' ),
	hbd_resolve_image( 'hbd_ksquare_about_image4_id', 'ksquare-about-4.png' ),
);

$captions = array(
	get_theme_mod( 'hbd_ksquare_about_caption1', 'Cinepolis cinema' ),
	get_theme_mod( 'hbd_ksquare_about_caption2', "Indoor playgrounds and kids' entertainment" ),
	get_theme_mod( 'hbd_ksquare_about_caption3', 'Casual dining options' ),
	get_theme_mod( 'hbd_ksquare_about_caption4', 'Cafés and everyday retail' ),
);

$socials = array(
	'instagram' => array( 'label' => 'Instagram', 'url' => get_theme_mod( 'hbd_social_instagram', '' ), 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>' ),
	'facebook'  => array( 'label' => 'Facebook', 'url' => get_theme_mod( 'hbd_social_facebook', '' ), 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 22v-8h2.5l.5-3.5h-3V8.3c0-1 .3-1.7 1.8-1.7h2v-3c-.3 0-1.5-.1-2.8-.1-2.8 0-4.7 1.7-4.7 4.8v2.2H7v3.5h2.8V22z"/></svg>' ),
	'whatsapp'  => array( 'label' => 'WhatsApp', 'url' => get_theme_mod( 'hbd_social_whatsapp', '' ), 'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5a9.5 9.5 0 0 0-8.2 14.3L2.5 22l5.4-1.4A9.5 9.5 0 1 0 12 2.5zm0 17.3a7.8 7.8 0 0 1-4-1.1l-.3-.2-3 .8.8-2.9-.2-.3a7.8 7.8 0 1 1 6.7 3.7zm4.4-5.8c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1-.2-.1-.9-.3-1.8-1.1-.7-.6-1.1-1.3-1.2-1.5-.1-.2 0-.4.1-.5l.4-.5c.1-.1.2-.3.2-.4 0-.1.1-.3 0-.4 0-.1-.5-1.3-.7-1.7-.2-.5-.4-.4-.5-.4h-.4c-.2 0-.4 0-.6.3-.2.3-.8.8-.8 1.9 0 1.1.8 2.2.9 2.4.1.2 1.6 2.5 4 3.5.6.3 1 .4 1.4.5.6.2 1.1.2 1.5.1.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1 0-.1-.2-.2-.4-.3z"/></svg>' ),
);
?>
<!-- wp:group {"tagName":"section","className":"ks-about","layout":{"type":"default"}} -->
<section class="wp-block-group ks-about">
	<!-- wp:heading {"level":2,"className":"ks-about__title","textAlign":"center"} -->
	<h2 class="wp-block-heading ks-about__title has-text-align-center"><?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_html() above ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="ks-about__row">
		<div class="ks-about__collage">
			<?php foreach ( $images as $i => $src ) : ?>
			<figure class="ks-about__img ks-about__img--<?php echo (int) ( $i + 1 ); ?>"><img src="<?php echo esc_url( $src ); ?>" alt=""/></figure>
			<?php endforeach; ?>

			<?php foreach ( $captions as $i => $caption ) :
				if ( ! $caption ) {
					continue;
				}
				?>
			<span class="ks-about__caption ks-about__caption--<?php echo (int) ( $i + 1 ); ?>">
				<span class="ks-about__caption-line" aria-hidden="true"></span>
				<span class="ks-about__caption-label"><?php echo esc_html( $caption ); ?></span>
			</span>
			<?php endforeach; ?>
		</div>

		<div class="ks-about__info">
			<div class="ks-about__copy">
				<?php if ( $tag ) : ?>
				<div class="ks-about__tags">
					<span class="decor-ring" aria-hidden="true"></span>
					<span class="tag-chip"><?php echo esc_html( $tag ); ?></span>
				</div>
				<?php endif; ?>

				<div class="ks-about__body">
					<?php foreach ( $body_paras as $para ) : ?>
					<p><?php echo esc_html( $para ); ?></p>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="ks-about__social">
				<?php foreach ( $socials as $social ) : ?>
				<a href="<?php echo esc_url( $social['url'] ? $social['url'] : '#' ); ?>" class="icon-button" aria-label="<?php echo esc_attr( $social['label'] ); ?>"<?php echo $social['url'] ? ' rel="noopener" target="_blank"' : ''; ?>><?php echo $social['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
