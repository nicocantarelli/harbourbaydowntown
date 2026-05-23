<?php
/**
 * Title: Live & Work — Buildings
 * Slug: harbour-bay-downtown/livework-buildings
 * Categories: harbour-bay-downtown
 * Description: One section per building (managed under Buildings in wp-admin) — a centered title, an image on the left, and a tag, body, and amenities on the right. Falls back to static placeholders until buildings are added.
 * Inserter: no
 * Viewport Width: 1440
 */

$buildings = hbd_get_buildings();
if ( empty( $buildings ) ) {
	$img       = HBD_THEME_URI . '/assets/images/';
	$buildings = array(
		array(
			'title'     => 'Menara Aria',
			'image'     => $img . 'livework-building-1.png',
			'tag'       => 'Office Space',
			'link'      => '#',
			'body'      => "Menara Aria offers office space in one of Batam's most connected waterfront districts.\n\nSuitable for businesses that value accessibility, visibility, and convenience, it places teams close to the ferry terminal, hotels, dining, and everyday essentials.",
			'amenities' => array(
				array( 'icon' => 'building', 'text' => 'Office spaces in a strategic business location' ),
				array( 'icon' => 'walk', 'text' => 'Walking distance to the international ferry terminal' ),
				array( 'icon' => 'map', 'text' => 'Close to hotels, restaurants, and Bayfront Mall' ),
				array( 'icon' => 'navigation', 'text' => 'Easy access for clients, teams, and visitors' ),
				array( 'icon' => 'briefcase', 'text' => 'Professional setting within an established district' ),
			),
		),
		array(
			'title'     => 'Harbour Bay Condo 1',
			'image'     => $img . 'livework-building-2.png',
			'tag'       => 'Residential',
			'link'      => '#',
			'body'      => 'A practical residential option for those who want to stay close to work, transport, and lifestyle amenities. Ideal for frequent travellers, working professionals, and long stay guests looking for convenience in a connected district.',
			'amenities' => array(
				array( 'icon' => 'building', 'text' => 'Comfortable residential accommodation' ),
				array( 'icon' => 'map', 'text' => 'Close to dining, retail, and daily essentials' ),
				array( 'icon' => 'walk', 'text' => 'Walking distance to the ferry terminal' ),
				array( 'icon' => 'navigation', 'text' => 'Convenient access to nearby hotels and key destinations' ),
				array( 'icon' => 'calendar', 'text' => 'Suitable for short or extended stays' ),
			),
		),
		array(
			'title'     => 'Harbour Bay Condo 2',
			'image'     => $img . 'livework-building-3.png',
			'tag'       => 'Residential',
			'link'      => '#',
			'body'      => 'Located within Harbour Bay Downtown, this accommodation option offers a convenient and well connected place to stay. With nearby amenities and easy access to transport, it supports both everyday living and flexible travel needs.',
			'amenities' => array(
				array( 'icon' => 'building', 'text' => 'Residential unit in a connected waterfront area' ),
				array( 'icon' => 'map', 'text' => 'Near food, shopping, and lifestyle options' ),
				array( 'icon' => 'ship', 'text' => 'Easy access to the international ferry terminal' ),
				array( 'icon' => 'briefcase', 'text' => 'Suitable for professionals, residents, and frequent travellers' ),
				array( 'icon' => 'navigation', 'text' => 'Convenient location for daily living and mobility' ),
			),
		),
	);
}

$arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 36 36" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 26 26 10"/><path d="M12 10h14v14"/></svg>';

foreach ( $buildings as $building ) :
	$paras = array_filter( array_map( 'trim', preg_split( '/\n\s*\n/', (string) $building['body'] ) ), 'strlen' );
	?>
<!-- wp:group {"tagName":"section","className":"lw-building","layout":{"type":"default"}} -->
<section class="wp-block-group lw-building">
	<!-- wp:heading {"level":2,"className":"lw-building__title","textAlign":"center"} -->
	<h2 class="wp-block-heading lw-building__title has-text-align-center"><?php echo esc_html( $building['title'] ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:html -->
	<div class="lw-building__row">
		<figure class="lw-building__media"><img src="<?php echo esc_url( $building['image'] ); ?>" alt="<?php echo esc_attr( $building['title'] ); ?>"/></figure>

		<div class="lw-building__info">
			<div class="lw-building__head">
				<?php if ( $building['tag'] ) : ?>
				<div class="lw-building__tags">
					<span class="decor-ring" aria-hidden="true"></span>
					<span class="tag-chip"><?php echo esc_html( $building['tag'] ); ?></span>
				</div>
				<?php endif; ?>

				<?php if ( $building['link'] ) : ?>
				<a class="icon-button lw-building__arrow" href="<?php echo esc_url( $building['link'] ); ?>" aria-label="<?php echo esc_attr( $building['title'] ); ?>"><?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></a>
				<?php endif; ?>
			</div>

			<div class="lw-building__text">
				<div class="lw-building__body">
					<?php foreach ( $paras as $para ) : ?>
					<p><?php echo esc_html( $para ); ?></p>
					<?php endforeach; ?>
				</div>

				<span class="lw-building__divider" aria-hidden="true"></span>

				<?php hbd_render_amenities( $building['amenities'] ); ?>
			</div>
		</div>
	</div>
	<!-- /wp:html -->
</section>
<!-- /wp:group -->
<?php endforeach; ?>
