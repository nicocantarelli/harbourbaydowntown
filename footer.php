<?php
/**
 * Site footer — closes site-main, outputs the dark footer card, closes HTML.
 *
 * @package HarbourBayDowntown
 */
?>
	</main><!-- .site-main -->

	<footer class="site-footer">
		<a class="site-footer__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php
			$footer_logo_id = (int) get_theme_mod( 'hbd_footer_logo_id', 0 );
			if ( ! $footer_logo_id ) {
				$footer_logo_id = (int) get_theme_mod( 'custom_logo', 0 );
			}
			$footer_logo_url = $footer_logo_id ? wp_get_attachment_image_url( $footer_logo_id, 'full' ) : '';

			if ( $footer_logo_url ) :
				?>
				<img src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
			<?php else : ?>
				<span class="site-footer__brand-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
			<?php endif; ?>
		</a>

		<div class="site-footer__column">
			<h6 class="site-footer__heading"><?php echo esc_html( get_theme_mod( 'hbd_footer_heading_explore', 'Explore' ) ); ?></h6>
			<?php echo do_shortcode( '[hbd_menu location="footer_explore"]' ); ?>
		</div>

		<div class="site-footer__column">
			<h6 class="site-footer__heading"><?php echo esc_html( get_theme_mod( 'hbd_footer_heading_quick', 'Quick Links' ) ); ?></h6>
			<?php echo do_shortcode( '[hbd_menu location="footer_quick_links"]' ); ?>
		</div>

		<div class="site-footer__column">
			<h6 class="site-footer__heading"><?php echo esc_html( get_theme_mod( 'hbd_footer_heading_others', 'Others' ) ); ?></h6>
			<?php echo do_shortcode( '[hbd_menu location="footer_others"]' ); ?>
		</div>

		<div class="site-footer__social">
			<?php
			$socials = array(
				'instagram' => array(
					'label' => 'Instagram',
					'url'   => get_theme_mod( 'hbd_social_instagram', '' ),
					'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor"/></svg>',
				),
				'facebook'  => array(
					'label' => 'Facebook',
					'url'   => get_theme_mod( 'hbd_social_facebook', '' ),
					'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13.5 22v-8h2.5l.5-3.5h-3V8.3c0-1 .3-1.7 1.8-1.7h2v-3c-.3 0-1.5-.1-2.8-.1-2.8 0-4.7 1.7-4.7 4.8v2.2H7v3.5h2.8V22z"/></svg>',
				),
				'whatsapp'  => array(
					'label' => 'WhatsApp',
					'url'   => get_theme_mod( 'hbd_social_whatsapp', '' ),
					'svg'   => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.5a9.5 9.5 0 0 0-8.2 14.3L2.5 22l5.4-1.4A9.5 9.5 0 1 0 12 2.5zm0 17.3a7.8 7.8 0 0 1-4-1.1l-.3-.2-3 .8.8-2.9-.2-.3a7.8 7.8 0 1 1 6.7 3.7zm4.4-5.8c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.5.1l-.7.9c-.1.2-.3.2-.5.1-.2-.1-.9-.3-1.8-1.1-.7-.6-1.1-1.3-1.2-1.5-.1-.2 0-.4.1-.5l.4-.5c.1-.1.2-.3.2-.4 0-.1.1-.3 0-.4 0-.1-.5-1.3-.7-1.7-.2-.5-.4-.4-.5-.4h-.4c-.2 0-.4 0-.6.3-.2.3-.8.8-.8 1.9 0 1.1.8 2.2.9 2.4.1.2 1.6 2.5 4 3.5.6.3 1 .4 1.4.5.6.2 1.1.2 1.5.1.5-.1 1.4-.6 1.6-1.1.2-.6.2-1 .1-1.1 0-.1-.2-.2-.4-.3z"/></svg>',
				),
			);

			foreach ( $socials as $key => $social ) :
				if ( empty( $social['url'] ) ) {
					continue;
				}
				?>
				<a href="<?php echo esc_url( $social['url'] ); ?>" class="icon-button icon-button--light" aria-label="<?php echo esc_attr( $social['label'] ); ?>" rel="noopener" target="_blank"><?php echo $social['svg']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
			<?php endforeach; ?>
		</div>

		<div class="site-footer__bottom">
			<?php
			$copyright = get_theme_mod( 'hbd_footer_copyright', '' );
			if ( '' === trim( (string) $copyright ) ) {
				$copyright = sprintf(
					/* translators: 1: current year, 2: site name. */
					__( '© %1$s %2$s. All rights reserved.', 'harbour-bay-downtown' ),
					wp_date( 'Y' ),
					get_bloginfo( 'name' )
				);
			} else {
				$copyright = str_replace( '{year}', wp_date( 'Y' ), $copyright );
			}
			?>
			<p class="site-footer__copyright"><?php echo wp_kses_post( $copyright ); ?></p>
			<p class="site-footer__credit">
				<?php
				printf(
					/* translators: %s: the linked "Zonda Studio" credit. */
					esc_html__( 'Designed and Developed by %s', 'harbour-bay-downtown' ),
					'<a href="https://zondastudio.com" target="_blank" rel="noopener">' . esc_html__( 'Zonda Studio', 'harbour-bay-downtown' ) . '</a>'
				);
				?>
			</p>
		</div>
	</footer>
</div><!-- .wp-site-blocks -->

<?php wp_footer(); ?>
</body>
</html>
