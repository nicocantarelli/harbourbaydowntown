<?php
/**
 * Site header — opens HTML, runs wp_head(), opens body and site wrapper,
 * outputs the global site header (logo + primary nav) and the smart sticky navbar
 * that reveals on scroll-up once the hero (or, on solid-header pages, the header)
 * has scrolled past.
 *
 * @package HarbourBayDowntown
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="wp-site-blocks">
	<?php
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$logo_url       = $custom_logo_id ? wp_get_attachment_image_url( $custom_logo_id, 'full' ) : HBD_THEME_URI . '/assets/images/logo.svg';
	$logo_alt       = get_bloginfo( 'name' );
	$home_url       = esc_url( home_url( '/' ) );

	// Hero pages float the header over a full-screen hero (transparent, white
	// text) and get the smart sticky nav. The front page always qualifies;
	// secondary-page templates opt in by setting $GLOBALS['hbd_hero_page'] = true
	// before get_header().
	$has_hero = is_front_page() || ! empty( $GLOBALS['hbd_hero_page'] );

	// Hamburger toggle — hidden above the desktop breakpoint (CSS); opens the
	// mobile drawer below it. Reused in both the static header and the sticky nav.
	$nav_toggle = sprintf(
		'<button class="site-header__toggle" type="button" data-mobile-nav-toggle aria-controls="mobile-nav" aria-expanded="false" aria-label="%s"><span aria-hidden="true"></span><span aria-hidden="true"></span><span aria-hidden="true"></span></button>',
		esc_attr__( 'Open menu', 'harbour-bay-downtown' )
	);
	$allowed_toggle = array(
		'button' => array(
			'class'         => true,
			'type'          => true,
			'data-mobile-nav-toggle' => true,
			'aria-controls' => true,
			'aria-expanded' => true,
			'aria-label'    => true,
		),
		'span'   => array(
			'aria-hidden' => true,
		),
	);
	?>
	<header class="site-header<?php echo $has_hero ? ' site-header--overlay' : ''; ?>">
		<a class="site-header__logo" href="<?php echo $home_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_url() above ?>" rel="home">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
		</a>

		<?php echo do_shortcode( '[hbd_menu location="header"]' ); ?>
		<?php echo wp_kses( $nav_toggle, $allowed_toggle ); ?>
	</header>

	<?php // Smart sticky nav on every page — reveals on scroll-up once past the hero
		// (hero pages) or once the solid header scrolls out of view (other pages). ?>
	<div class="sticky-nav" data-sticky-nav aria-hidden="true">
		<a class="site-header__logo sticky-nav__logo" href="<?php echo $home_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_url() above ?>" rel="home">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
		</a>

		<?php echo do_shortcode( '[hbd_menu location="header"]' ); ?>
		<?php echo wp_kses( $nav_toggle, $allowed_toggle ); ?>
	</div>

	<?php // Mobile navigation drawer — slides in from the right below the desktop
		// breakpoint, reusing the header menu (re-skinned vertical in CSS). ?>
	<div class="mobile-nav" id="mobile-nav" data-mobile-nav hidden>
		<div class="mobile-nav__backdrop" data-mobile-nav-close></div>
		<nav class="mobile-nav__panel" aria-label="<?php esc_attr_e( 'Mobile', 'harbour-bay-downtown' ); ?>" tabindex="-1">
			<div class="mobile-nav__head">
				<a class="site-header__logo mobile-nav__logo" href="<?php echo $home_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_url() above ?>" rel="home">
					<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
				</a>
				<button class="mobile-nav__close" type="button" data-mobile-nav-close aria-label="<?php esc_attr_e( 'Close menu', 'harbour-bay-downtown' ); ?>">
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</button>
			</div>
			<?php echo do_shortcode( '[hbd_menu location="header"]' ); ?>
		</nav>
	</div>

	<main class="site-main">
