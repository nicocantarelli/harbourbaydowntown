<?php
/**
 * Title: Dine — Categories
 * Slug: harbour-bay-downtown/dine-categories
 * Categories: harbour-bay-downtown
 * Description: A segmented filter above a carousel of restaurant cards. Tabs are the Listing sub-categories that have restaurants (Listings → Type: Restaurants + a Category); clicking a tab shows that category's listings as a horizontal carousel. Falls back to static placeholders until restaurants are added.
 * Inserter: no
 * Viewport Width: 1440
 */

$tabs_data = hbd_get_listing_tabs( 'restaurants' );

// Shared carousel controls (progress bar + prev/next), reused per tab panel.
$controls = '<div class="carousel__controls">'
	. '<div class="progress-bar"><span class="progress-bar__rail"></span><span class="progress-bar__fill" data-carousel-progress></span></div>'
	. '<div class="carousel__nav">'
	. '<button type="button" class="icon-button icon-button--outline" data-carousel-prev aria-label="Previous"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M21.7803 13.2197C21.4874 12.9268 21.0127 12.9268 20.7198 13.2197L14.7198 19.2197C14.4269 19.5126 14.4269 19.9873 14.7198 20.2802L20.7198 26.2802C21.0127 26.5731 21.4874 26.5731 21.7803 26.2802C22.0732 25.9873 22.0732 25.5126 21.7803 25.2197L16.3106 19.7499L21.7803 14.2802C22.0732 13.9873 22.0732 13.5126 21.7803 13.2197Z" fill="currentColor"/></svg></button>'
	. '<button type="button" class="icon-button icon-button--outline" data-carousel-next aria-label="Next"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none"><path d="M18.2197 13.2197C18.5126 12.9268 18.9873 12.9268 19.2802 13.2197L25.2802 19.2197C25.5731 19.5126 25.5731 19.9873 25.2802 20.2802L19.2802 26.2802C18.9873 26.5731 18.5126 26.5731 18.2197 26.2802C17.9268 25.9873 17.9268 25.5126 18.2197 25.2197L23.6894 19.7499L18.2197 14.2802C17.9268 13.9873 17.9268 13.5126 18.2197 13.2197Z" fill="currentColor"/></svg></button>'
	. '</div></div>';
?>
<!-- wp:group {"tagName":"section","className":"dine-categories","layout":{"type":"default"}} -->
<section class="wp-block-group dine-categories">
	<!-- wp:html -->
	<?php if ( ! empty( $tabs_data ) ) : ?>
		<div class="dine-categories__switch" data-tabs role="tablist" aria-label="Dining categories">
			<?php $first = true; foreach ( $tabs_data as $tab ) : ?>
				<button type="button" class="dine-categories__tab<?php echo $first ? ' is-active' : ''; ?>" data-tab="<?php echo esc_attr( $tab['term']->slug ); ?>" role="tab" aria-selected="<?php echo $first ? 'true' : 'false'; ?>"><?php echo esc_html( $tab['term']->name ); ?></button>
			<?php $first = false; endforeach; ?>
		</div>

		<?php $first = true; foreach ( $tabs_data as $tab ) : ?>
		<div class="dine-categories__panel" data-panel="<?php echo esc_attr( $tab['term']->slug ); ?>" role="tabpanel"<?php echo $first ? '' : ' hidden'; ?>>
			<div class="carousel carousel--listings" data-carousel>
				<div class="carousel__track" data-carousel-track>
					<?php
					foreach ( $tab['cards'] as $card ) :
						$loc  = trim( (string) ( $card['location'] ?? '' ) );
						$chip = '' !== $loc ? hbd_truncate_text( trim( preg_split( '/\s*[·,]\s*/', $loc )[0] ), 22 ) : ( $card['pill'] ?? '' );
					?>
					<div class="card card--type-3">
						<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( $card['image'] ); ?>" alt=""/></figure>
						<div class="card__copy">
							<h3 class="card__title"><?php echo esc_html( $card['title'] ); ?></h3>
							<?php if ( $chip ) : ?><span class="tag-chip tag-chip--inverse"><?php echo esc_html( $chip ); ?></span><?php endif; ?>
						</div>
						<div class="wp-block-buttons card__cta">
							<div class="wp-block-button is-style-pill-big"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $card['link'] ); ?>"<?php echo ! empty( $card['is_external'] ) ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $card['cta_label'] ); ?></a></div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php echo $controls; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped — static markup ?>
			</div>
		</div>
		<?php $first = false; endforeach; ?>
	<?php else : ?>
		<?php
		// Placeholder until restaurants are tagged with categories.
		$ph_tabs  = array( 'Breakfast & Coffee', 'Lunch & Casual Meals', 'Dinner by the Sea', 'Late-Night Eats' );
		$ph_cards = array(
			array( 'image' => 'card-dine.png',    'title' => 'Sunrise Café',     'date' => 'Open 7 AM' ),
			array( 'image' => 'promo-dining.png', 'title' => 'Harbour Espresso', 'date' => 'Daily' ),
			array( 'image' => 'card-stay.png',    'title' => 'The Brunch Co.',   'date' => 'Weekends' ),
			array( 'image' => 'promo-surf.png',   'title' => 'Bay Bakery',       'date' => 'Open 6 AM' ),
		);
		?>
		<div class="dine-categories__switch" role="tablist" aria-label="Dining categories">
			<?php foreach ( $ph_tabs as $i => $tab ) : ?>
				<button type="button" class="dine-categories__tab<?php echo 0 === $i ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"><?php echo esc_html( $tab ); ?></button>
			<?php endforeach; ?>
		</div>

		<div class="dine-categories__cards">
			<?php foreach ( $ph_cards as $card ) : ?>
			<div class="card card--type-3">
				<figure class="wp-block-image size-full card__image"><img src="<?php echo esc_url( HBD_THEME_URI . '/assets/images/' . $card['image'] ); ?>" alt=""/></figure>
				<div class="card__copy">
					<h3 class="card__title"><?php echo esc_html( $card['title'] ); ?></h3>
					<span class="tag-chip tag-chip--inverse"><?php echo esc_html( $card['date'] ); ?></span>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
