<?php
/**
 * Floating FAQ / chat widget — a fixed bottom-right button that opens an FAQ
 * accordion and a "Chat on WhatsApp" CTA. Rendered site-wide via wp_footer.
 *
 * Content is editable in Customizer → Theme Options → FAQ / Chat widget.
 * The WhatsApp link reuses the Footer → WhatsApp URL setting.
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default FAQ questions + answers (also used as the Customizer defaults).
 *
 * @return array<int,array{q:string,a:string}>
 */
function hbd_faq_defaults() {
	return array(
		array(
			'q' => __( 'What is Harbour Bay Downtown?', 'harbour-bay-downtown' ),
			'a' => __( 'Harbour Bay Downtown is a walkable waterfront district in Batam with hotels, dining, wellness, and ferry access all in one area.', 'harbour-bay-downtown' ),
		),
		array(
			'q' => __( 'How close is it to the ferry terminal?', 'harbour-bay-downtown' ),
			'a' => __( 'The international ferry terminal is right within Harbour Bay — just a short walk from the waterfront.', 'harbour-bay-downtown' ),
		),
		array(
			'q' => __( 'Do I need a car to get around?', 'harbour-bay-downtown' ),
			'a' => __( 'No — most of Harbour Bay is walkable, with hotels, dining, and the ferry terminal all close together.', 'harbour-bay-downtown' ),
		),
		array(
			'q' => __( 'What can I find there?', 'harbour-bay-downtown' ),
			'a' => __( 'Hotels, restaurants and cafés, shopping, wellness and spa services, and waterfront walks.', 'harbour-bay-downtown' ),
		),
	);
}

/**
 * Render the floating FAQ / chat widget in the footer.
 */
function hbd_render_faq_widget() {
	if ( ! get_theme_mod( 'hbd_faq_enable', true ) ) {
		return;
	}

	$heading      = get_theme_mod( 'hbd_faq_heading', __( 'FAQ', 'harbour-bay-downtown' ) );
	$cta_heading  = get_theme_mod( 'hbd_faq_cta_heading', __( 'Do you have any questions?', 'harbour-bay-downtown' ) );
	$cta_label    = get_theme_mod( 'hbd_faq_cta_label', __( 'Chat on WhatsApp', 'harbour-bay-downtown' ) );
	// Dedicated chat link, falling back to the Footer WhatsApp URL.
	$cta_url  = get_theme_mod( 'hbd_faq_cta_url', '' );
	if ( ! $cta_url ) {
		$cta_url = get_theme_mod( 'hbd_social_whatsapp', '' );
	}
	$has_link = (bool) $cta_url;
	$cta_url  = $has_link ? $cta_url : '#';

	$defaults = hbd_faq_defaults();
	$faqs     = array();
	foreach ( $defaults as $i => $default ) {
		$n = $i + 1;
		$q = get_theme_mod( "hbd_faq_q{$n}", $default['q'] );
		$a = get_theme_mod( "hbd_faq_a{$n}", $default['a'] );
		if ( $q ) {
			$faqs[] = array( 'q' => $q, 'a' => $a );
		}
	}
	?>
	<div class="faq-widget" data-faq-widget>
		<div class="faq-widget__panel" data-faq-panel hidden>
			<?php if ( ! empty( $faqs ) ) : ?>
				<div class="faq-widget__faq">
					<p class="faq-widget__title"><?php echo esc_html( $heading ); ?></p>
					<div class="faq-widget__questions">
						<?php foreach ( $faqs as $faq ) : ?>
							<div class="faq-item" data-faq-item>
								<button type="button" class="faq-item__trigger" data-faq-trigger aria-expanded="false">
									<span class="faq-item__q"><?php echo esc_html( $faq['q'] ); ?></span>
									<span class="faq-item__icon" aria-hidden="true"></span>
								</button>
								<?php if ( $faq['a'] ) : ?>
									<div class="faq-item__answer" data-faq-answer hidden>
										<p><?php echo esc_html( $faq['a'] ); ?></p>
									</div>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="faq-widget__cta">
				<p class="faq-widget__cta-heading"><?php echo esc_html( $cta_heading ); ?></p>
				<div class="wp-block-button is-style-pill-big is-style-pill-big-dark faq-widget__cta-btn">
					<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $cta_url ); ?>"<?php echo $has_link ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $cta_label ); ?></a>
				</div>
			</div>
		</div>

		<button type="button" class="faq-widget__toggle" data-faq-toggle aria-expanded="false" aria-label="<?php esc_attr_e( 'Open FAQ and chat', 'harbour-bay-downtown' ); ?>">
			<span class="faq-widget__icon faq-widget__icon--chat" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 28.6992 25.7002" fill="none"><path d="M10.3572 18.8357C15.0918 18.5727 18.85 14.6504 18.85 9.85C18.85 4.87944 14.8206 0.85 9.85 0.85C4.87944 0.85 0.85 4.87944 0.85 9.85C0.85 11.6211 1.36141 13.2725 2.24483 14.6649L1.60879 16.5731L1.60778 16.5759C1.36416 17.3067 1.2423 17.6723 1.32908 17.9156C1.40469 18.1277 1.57253 18.2948 1.78457 18.3704C2.02708 18.4569 2.39012 18.3359 3.11604 18.0939L3.12637 18.0908L5.03506 17.4547C6.42745 18.3382 8.07903 18.8497 9.85009 18.8497C10.0203 18.8497 10.1894 18.845 10.3572 18.8357ZM10.3572 18.8357C11.5886 22.3388 14.9261 24.8502 18.8502 24.8502C20.6213 24.8502 22.2725 24.3382 23.6648 23.4547L25.573 24.0908L25.5768 24.0915C26.3075 24.3351 26.6737 24.4572 26.9171 24.3704C27.1291 24.2948 27.2948 24.1276 27.3704 23.9156C27.4573 23.6719 27.3358 23.3059 27.0915 22.5731L26.4555 20.6649L26.6685 20.3119C27.4207 18.9969 27.8492 17.4735 27.8492 15.85C27.8492 10.8795 23.8205 6.85 18.85 6.85" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
			</span>
			<span class="faq-widget__icon faq-widget__icon--close" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6 18 18M18 6 6 18"/></svg>
			</span>
		</button>
	</div>
	<?php
}
add_action( 'wp_footer', 'hbd_render_faq_widget' );
