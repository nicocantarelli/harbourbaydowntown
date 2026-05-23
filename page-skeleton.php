<?php
/**
 * SECONDARY-PAGE SKELETON — copy/paste starter. NOT a live template on its own.
 *
 * To build a new secondary page (e.g. "Stay"):
 *   1. Copy this file to `page-<slug>.php` (e.g. page-stay.php). WordPress auto-applies
 *      it to the Page whose slug matches — no template dropdown needed.
 *   2. Create the section templates it renders under `/patterns/<slug>-*.php`
 *      (copy an existing about-*.php as a starting point).
 *   3. Add the matching Customizer fields in inc/customizer.php if the section
 *      content should be editable.
 *   4. Delete the lines/sections you don't need, and this header comment.
 *
 * Layout contract (matches front-page.php and page-about.php):
 *   - The hero renders OUTSIDE `.site-content` so it stays full-bleed/full-screen.
 *   - Everything else renders INSIDE `.site-content`, which caps content at 1440px.
 *   - Setting $GLOBALS['hbd_hero_page'] = true (before get_header) turns on the
 *     overlay header + smart sticky nav for pages that open with a hero.
 *
 * @package HarbourBayDowntown
 */

$GLOBALS['hbd_hero_page'] = true; // remove if this page has no full-screen hero.

get_header();

// Full-bleed hero (outside .site-content).
hbd_render_section( 'about-hero' ); // ← rename to your own <slug>-hero section.
?>

<div class="site-content">
	<?php
	// Capped content sections (1440px). Add/remove/reorder as the design needs.
	// Reuse a homepage section verbatim:  hbd_render_section( 'home-map-highlights' );
	// Render a page-specific section:     hbd_render_section( '<slug>-<name>' );
	?>
</div>

<?php
get_footer();
