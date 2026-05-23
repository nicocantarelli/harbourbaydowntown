<?php
/**
 * Single blog post — a left-aligned editorial layout: back link, category,
 * a large title, meta, a divider, then a wide featured image and the content in
 * a readable measure. A solid-header page.
 *
 * @package HarbourBayDowntown
 */

get_header();

$blog_page_id = (int) get_option( 'page_for_posts' );
$blog_url     = $blog_page_id ? get_permalink( $blog_page_id ) : home_url( '/' );
$blog_label   = $blog_page_id ? get_the_title( $blog_page_id ) : __( 'Journal', 'harbour-bay-downtown' );

while ( have_posts() ) :
	the_post();

	$categories = get_the_category();
	$category   = ! empty( $categories ) ? $categories[0]->name : '';
	$read_time  = sprintf(
		/* translators: %d: number of minutes to read. */
		__( '%d min read', 'harbour-bay-downtown' ),
		hbd_reading_time( get_post() )
	);
	?>
	<article <?php post_class( 'post-single' ); ?>>
		<div class="site-content post-single__inner">
			<header class="post-single__header">
				<a class="post-single__back" href="<?php echo esc_url( $blog_url ); ?>">
					<span aria-hidden="true">&larr;</span>
					<?php
					/* translators: %s: blog/journal page title. */
					printf( esc_html__( 'Back to %s', 'harbour-bay-downtown' ), esc_html( $blog_label ) );
					?>
				</a>

				<div class="post-single__headline">
					<?php if ( $category ) : ?>
						<span class="tag-chip post-single__category"><?php echo esc_html( $category ); ?></span>
					<?php endif; ?>

					<h1 class="post-single__title"><?php the_title(); ?></h1>

					<div class="post-single__meta">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'j F Y' ) ); ?></time>
						<span class="post-single__dot" aria-hidden="true">&middot;</span>
						<span><?php echo esc_html( $read_time ); ?></span>
					</div>
				</div>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="post-single__image"><?php the_post_thumbnail( 'large' ); ?></figure>
			<?php endif; ?>

			<div class="post-single__content">
				<?php
				the_content();

				wp_link_pages(
					array(
						'before' => '<div class="post-single__pages">' . esc_html__( 'Pages:', 'harbour-bay-downtown' ),
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<footer class="post-single__footer">
				<a class="post-single__back" href="<?php echo esc_url( $blog_url ); ?>">
					<span aria-hidden="true">&larr;</span>
					<?php
					/* translators: %s: blog/journal page title. */
					printf( esc_html__( 'Back to %s', 'harbour-bay-downtown' ), esc_html( $blog_label ) );
					?>
				</a>
			</footer>
		</div>
	</article>
	<?php
endwhile;

get_footer();
