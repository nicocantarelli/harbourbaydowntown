<?php
/**
 * Search results — reuses the blog grid (Card_Type_4 post cards) so results
 * match the rest of the site. A solid-header page.
 *
 * @package HarbourBayDowntown
 */

get_header();
?>
<div class="site-content blog">
	<header class="blog__header">
		<h1 class="blog__title">
			<?php
			/* translators: %s: Search query. */
			printf( esc_html__( 'Results for "%s"', 'harbour-bay-downtown' ), esc_html( get_search_query() ) );
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="blog__grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$card = hbd_guides_post_view_model( get_post() );
				?>
				<a class="card card--type-4 card--link blog__card" href="<?php echo esc_url( $card['permalink'] ); ?>" aria-label="<?php echo esc_attr( $card['title'] ); ?>">
					<div class="card__image">
						<figure class="wp-block-image size-full"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
						<?php if ( $card['category'] ) : ?>
							<span class="tag-chip tag-chip--inverse card__chip-tl"><?php echo esc_html( $card['category'] ); ?></span>
						<?php endif; ?>
					</div>

					<div class="card__content">
						<div class="card__text">
							<h2 class="card__title"><?php echo esc_html( $card['title'] ); ?></h2>
							<p class="card__body"><?php echo esc_html( $card['excerpt'] ); ?></p>
						</div>
						<div class="card__meta">
							<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['date'] ); ?></span>
							<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['read_time'] ); ?></span>
						</div>
					</div>
				</a>
				<?php
			endwhile;
			?>
		</div>

		<?php
		the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => esc_html__( 'Previous', 'harbour-bay-downtown' ),
				'next_text' => esc_html__( 'Next', 'harbour-bay-downtown' ),
			)
		);
		?>
	<?php else : ?>
		<p class="blog__empty"><?php esc_html_e( 'No results found. Try a different search.', 'harbour-bay-downtown' ); ?></p>
	<?php endif; ?>
</div>

<?php
get_footer();
