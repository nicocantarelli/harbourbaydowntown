<?php
/**
 * Generic page template.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>

<div class="site-content">
	<div class="page-content">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php
		endwhile;
		?>
	</div>
</div>

<?php
get_footer();
