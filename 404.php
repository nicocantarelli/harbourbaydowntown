<?php
/**
 * 404 template.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content">
	<div class="page-content">
		<header class="page-header">
			<h1 class="page-title"><?php esc_html_e( 'Page not found', 'harbour-bay-downtown' ); ?></h1>
			<p><?php esc_html_e( 'Looks like nothing was found at this location. Try searching, or head back to the homepage.', 'harbour-bay-downtown' ); ?></p>
		</header>

		<?php get_search_form(); ?>

		<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="icon-button"><?php esc_html_e( 'Back to home', 'harbour-bay-downtown' ); ?></a></p>
	</div>
</div>

<?php
get_footer();
