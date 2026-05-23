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
	?>
	<header class="site-header<?php echo $has_hero ? ' site-header--overlay' : ''; ?>">
		<a class="site-header__logo" href="<?php echo $home_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_url() above ?>" rel="home">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
		</a>

		<?php echo do_shortcode( '[hbd_menu location="header"]' ); ?>
	</header>

	<?php // Smart sticky nav on every page — reveals on scroll-up once past the hero
		// (hero pages) or once the solid header scrolls out of view (other pages). ?>
	<div class="sticky-nav" data-sticky-nav aria-hidden="true">
		<a class="site-header__logo sticky-nav__logo" href="<?php echo $home_url; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — escaped via esc_url() above ?>" rel="home">
			<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" />
		</a>

		<?php echo do_shortcode( '[hbd_menu location="header"]' ); ?>
	</div>

	<main class="site-main">
