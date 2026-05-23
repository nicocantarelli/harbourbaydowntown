<?php
/**
 * Front page — homepage. Renders the hero plus the constrained content sections
 * (map, explore, guides, events, promotions) by including each pattern PHP file
 * and running its block markup through do_blocks().
 *
 * @package HarbourBayDowntown
 */

get_header();

/**
 * Render a registered pattern by slug. The pattern files emit block markup;
 * we capture and run it through do_blocks() so blocks render as HTML.
 *
 * @param string $relative_path Path under /patterns/ (no extension).
 */
function hbd_render_pattern( $relative_path ) {
	$file = get_template_directory() . '/patterns/' . $relative_path . '.php';
	if ( ! file_exists( $file ) ) {
		return;
	}
	ob_start();
	include $file;
	$content = ob_get_clean();
	echo do_blocks( $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

hbd_render_pattern( 'home-hero' );
?>

<div class="site-content">
	<?php
	hbd_render_pattern( 'home-map-highlights' );
	hbd_render_pattern( 'home-explore' );
	hbd_render_pattern( 'home-guides' );
	hbd_render_pattern( 'home-events' );
	hbd_render_pattern( 'home-promotions' );
	?>
</div>

<?php
get_footer();
