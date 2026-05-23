# Home Guides Blog-Driven Section — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Drive the homepage Guides section from real WordPress posts — each tab is an audience, each card a post (category chip, date, auto read time, title, excerpt, featured image) — with instant client-side tab switching.

**Architecture:** A new `audience` custom taxonomy on `post` powers the tabs. A data provider (`hbd_get_guides_data()`) queries the newest 3 posts per audience and returns presentation-ready view models. The `home-guides.php` pattern renders one tab + one panel per non-empty audience; `tabs.js` toggles panel visibility on click. No AJAX — all panels ship in the initial HTML.

**Tech Stack:** WordPress/PHP 8.2+, vanilla ES module JS, SCSS compiled by Vite.

**Spec:** `docs/superpowers/specs/2026-05-20-home-guides-blog-design.md`

**Note on verification:** This theme has no PHP/JS unit-test harness (only Vite for builds). Verification steps therefore use `php -l` syntax linting, `npm run build`, and explicit manual checks in WordPress. Do **not** scaffold a new test framework — that is out of scope.

**Git note:** Commit messages are clean and concise with **no** `Co-Authored-By` line (per project convention). Each commit stages only this feature's files so unrelated working-tree changes are never swept in.

---

### Task 1: Audience taxonomy + default terms + reading-time helper

**Files:**
- Create: `inc/guides-data.php`
- Modify: `functions.php` (add `require_once` near the other `inc/*` includes, after the promotions include around line 24)

- [ ] **Step 1: Create `inc/guides-data.php` with the taxonomy, term seeding, and read-time helper**

```php
<?php
/**
 * Home Guides data layer — the `audience` taxonomy, the reading-time helper,
 * and the data provider that powers the homepage Guides section
 * (patterns/home-guides.php).
 *
 * @package HarbourBayDowntown
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the `audience` taxonomy on posts, then seed default terms.
 */
function hbd_register_audience_taxonomy() {
	register_taxonomy(
		'audience',
		'post',
		array(
			'labels'            => array(
				'name'          => __( 'Audiences', 'harbour-bay-downtown' ),
				'singular_name' => __( 'Audience', 'harbour-bay-downtown' ),
				'menu_name'     => __( 'Audiences', 'harbour-bay-downtown' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'audience' ),
		)
	);

	hbd_seed_default_audiences();
}
add_action( 'init', 'hbd_register_audience_taxonomy' );

/**
 * Create the three default audience terms once (guarded by an option flag so it
 * does not run on every request).
 */
function hbd_seed_default_audiences() {
	if ( get_option( 'hbd_audiences_seeded' ) ) {
		return;
	}

	$defaults = array(
		'first-time-visitor' => 'First-Time Visitor',
		'business-traveler'  => 'Business Traveler',
		'weekend-getaway'    => 'Weekend Getaway',
	);

	foreach ( $defaults as $slug => $name ) {
		if ( ! term_exists( $slug, 'audience' ) ) {
			wp_insert_term( $name, 'audience', array( 'slug' => $slug ) );
		}
	}

	update_option( 'hbd_audiences_seeded', 1 );
}

/**
 * Estimate reading time in minutes for a post (~200 words per minute).
 *
 * @param int|WP_Post $post Post ID or object.
 * @return int Minutes, minimum 1.
 */
function hbd_reading_time( $post ) {
	$post = get_post( $post );
	if ( ! $post ) {
		return 1;
	}

	$word_count = str_word_count( wp_strip_all_tags( $post->post_content ) );

	return max( 1, (int) ceil( $word_count / 200 ) );
}
```

- [ ] **Step 2: Add the include to `functions.php`**

Find (around line 23-24):

```php
// Promotions admin page (repeater for the "Special Promotions" carousel).
require_once HBD_THEME_DIR . '/inc/promotions-admin.php';
```

Add immediately after it:

```php
// Home Guides data layer (audience taxonomy + blog-driven cards).
require_once HBD_THEME_DIR . '/inc/guides-data.php';
```

- [ ] **Step 3: Syntax-check both PHP files**

Run: `php -l inc/guides-data.php && php -l functions.php`
Expected: `No syntax errors detected` for each.

- [ ] **Step 4: Manual check — taxonomy registered and seeded**

In WP admin: go to **Posts** in the sidebar — an **Audiences** submenu appears. Open it and confirm three terms exist: *First-Time Visitor*, *Business Traveler*, *Weekend Getaway*. (If they don't appear, delete the `hbd_audiences_seeded` option and reload.)

- [ ] **Step 5: Commit**

```bash
git add inc/guides-data.php functions.php
git commit -m "Add audience taxonomy and reading-time helper for guides"
```

---

### Task 2: Data provider `hbd_get_guides_data()`

**Files:**
- Modify: `inc/guides-data.php` (append the view-model builder and the provider)

- [ ] **Step 1: Append the view-model builder and provider to `inc/guides-data.php`**

Add at the end of the file (before the closing — there is no closing `?>`, just append):

```php
/**
 * Build a presentation-ready view model for one guide post.
 *
 * @param WP_Post $post Post object.
 * @return array{title:string,permalink:string,excerpt:string,date:string,category:string,read_time:string,image:string}
 */
function hbd_guides_post_view_model( $post ) {
	$categories = get_the_category( $post->ID );
	$category   = ! empty( $categories ) ? $categories[0]->name : '';

	$image = get_the_post_thumbnail_url( $post->ID, 'large' );
	if ( ! $image ) {
		$image = get_template_directory_uri() . '/assets/images/guide-firstday.png';
	}

	$minutes   = hbd_reading_time( $post );
	$read_time = sprintf(
		/* translators: %d: number of minutes to read. */
		__( '%d min read', 'harbour-bay-downtown' ),
		$minutes
	);

	return array(
		'title'     => get_the_title( $post ),
		'permalink' => get_permalink( $post ),
		'excerpt'   => hbd_truncate_text( wp_strip_all_tags( get_the_excerpt( $post ) ), 80 ),
		'date'      => get_the_date( 'j F Y', $post ),
		'category'  => $category,
		'read_time' => $read_time,
		'image'     => $image,
	);
}

/**
 * Gather homepage Guides data grouped by audience term.
 *
 * Only audiences with at least one published post are returned. For each, the
 * newest post is the feature card and the next two (if any) are compact cards.
 *
 * @return array<string,array{term:WP_Term,feature:array,cards:array}>
 */
function hbd_get_guides_data() {
	$audiences = get_terms(
		array(
			'taxonomy'   => 'audience',
			'hide_empty' => true,
			'orderby'    => 'term_id',
			'order'      => 'ASC',
		)
	);

	if ( is_wp_error( $audiences ) || empty( $audiences ) ) {
		return array();
	}

	$data = array();

	foreach ( $audiences as $term ) {
		$query = new WP_Query(
			array(
				'post_type'           => 'post',
				'post_status'         => 'publish',
				'posts_per_page'      => 3,
				'orderby'             => 'date',
				'order'               => 'DESC',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
				'tax_query'           => array(
					array(
						'taxonomy' => 'audience',
						'field'    => 'term_id',
						'terms'    => $term->term_id,
					),
				),
			)
		);

		if ( empty( $query->posts ) ) {
			continue;
		}

		$views = array_map( 'hbd_guides_post_view_model', $query->posts );

		$data[ $term->slug ] = array(
			'term'    => $term,
			'feature' => $views[0],
			'cards'   => array_slice( $views, 1 ),
		);
	}

	return $data;
}
```

- [ ] **Step 2: Syntax-check**

Run: `php -l inc/guides-data.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Manual data check (seed content)**

Create at least one published post: give it a **Category** (e.g. "Guide"), assign an **Audience** (e.g. First-Time Visitor), and set a **Featured image**. This content is needed to verify Task 3. Repeat so at least one audience has 3 posts to confirm the feature/compact split.

- [ ] **Step 4: Commit**

```bash
git add inc/guides-data.php
git commit -m "Add guides data provider grouping posts by audience"
```

---

### Task 3: Render the section dynamically (`patterns/home-guides.php`)

**Files:**
- Modify: `patterns/home-guides.php` (replace the body markup; keep the pattern header comment block)

- [ ] **Step 1: Replace the contents of `patterns/home-guides.php`**

Replace the entire file with:

```php
<?php
/**
 * Title: Home Guides
 * Slug: harbour-bay-downtown/home-guides
 * Categories: harbour-bay-downtown
 * Description: Tabbed guide articles driven by blog posts — one feature card and two stacked compact cards per audience.
 * Block Types:
 * Viewport Width: 1440
 */

$guides_data = function_exists( 'hbd_get_guides_data' ) ? hbd_get_guides_data() : array();

if ( empty( $guides_data ) ) {
	return; // No audiences with posts — render nothing.
}

$posts_page_id = (int) get_option( 'page_for_posts' );
$read_more_url = $posts_page_id ? get_permalink( $posts_page_id ) : home_url( '/' );
?>
<!-- wp:group {"tagName":"section","className":"home-guides","layout":{"type":"default"}} -->
<section class="wp-block-group home-guides">
	<!-- wp:group {"className":"home-guides__head","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group home-guides__head">
		<!-- wp:html -->
		<div class="tabs" data-tabs role="tablist" aria-label="<?php esc_attr_e( 'Guide audience', 'harbour-bay-downtown' ); ?>">
			<?php
			$is_first = true;
			foreach ( $guides_data as $slug => $group ) :
				?>
				<button type="button" class="tab<?php echo $is_first ? ' is-active' : ''; ?>" data-tab="<?php echo esc_attr( $slug ); ?>" role="tab" aria-selected="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="guides-panel-<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $group['term']->name ); ?></button>
				<?php
				$is_first = false;
			endforeach;
			?>
		</div>
		<!-- /wp:html -->

		<!-- wp:buttons {"className":"home-guides__cta"} -->
		<div class="wp-block-buttons home-guides__cta">
			<!-- wp:button {"className":"is-style-pill-big is-style-pill-big-dark"} -->
			<div class="wp-block-button is-style-pill-big is-style-pill-big-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $read_more_url ); ?>"><?php esc_html_e( 'Read More', 'harbour-bay-downtown' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<?php
	$is_first = true;
	foreach ( $guides_data as $slug => $group ) :
		$feature = $group['feature'];
		?>
		<!-- wp:html -->
		<div class="wp-block-group home-guides__grid" id="guides-panel-<?php echo esc_attr( $slug ); ?>" data-panel="<?php echo esc_attr( $slug ); ?>" role="tabpanel"<?php echo $is_first ? '' : ' hidden'; ?>>
			<div class="wp-block-group home-guides__feature">
				<div class="wp-block-group card card--type-4">
					<div class="wp-block-group card__image">
						<figure class="wp-block-image size-full"><a href="<?php echo esc_url( $feature['permalink'] ); ?>"><img src="<?php echo esc_url( $feature['image'] ); ?>" alt="<?php echo esc_attr( $feature['title'] ); ?>"/></a></figure>
						<?php if ( $feature['category'] ) : ?>
							<span class="tag-chip tag-chip--inverse card__chip-tl"><?php echo esc_html( $feature['category'] ); ?></span>
						<?php endif; ?>
					</div>

					<div class="wp-block-group card__content">
						<div class="wp-block-group card__head">
							<h3 class="wp-block-heading card__title"><a href="<?php echo esc_url( $feature['permalink'] ); ?>"><?php echo esc_html( $feature['title'] ); ?></a></h3>
							<div class="wp-block-group card__meta">
								<span class="tag-chip tag-chip--small"><?php echo esc_html( $feature['date'] ); ?></span>
								<span class="tag-chip tag-chip--small"><?php echo esc_html( $feature['read_time'] ); ?></span>
							</div>
						</div>
						<p class="card__body"><?php echo esc_html( $feature['excerpt'] ); ?></p>
					</div>
				</div>
			</div>

			<div class="wp-block-group home-guides__stack">
				<?php foreach ( $group['cards'] as $card ) : ?>
					<div class="wp-block-group card card--type-4 card--type-4-sm">
						<div class="wp-block-group card__image">
							<figure class="wp-block-image size-full"><a href="<?php echo esc_url( $card['permalink'] ); ?>"><img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>"/></a></figure>
						</div>

						<div class="wp-block-group card__content">
							<div class="wp-block-group card__head">
								<?php if ( $card['category'] ) : ?>
									<span class="tag-chip tag-chip--solid-dark"><?php echo esc_html( $card['category'] ); ?></span>
								<?php endif; ?>
								<div class="wp-block-group card__meta">
									<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['date'] ); ?></span>
									<span class="tag-chip tag-chip--small"><?php echo esc_html( $card['read_time'] ); ?></span>
								</div>
							</div>
							<h4 class="wp-block-heading card__title"><a href="<?php echo esc_url( $card['permalink'] ); ?>"><?php echo esc_html( $card['title'] ); ?></a></h4>
							<p class="card__body"><?php echo esc_html( $card['excerpt'] ); ?></p>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- /wp:html -->
		<?php
		$is_first = false;
	endforeach;
	?>
</section>
<!-- /wp:group -->
```

- [ ] **Step 2: Syntax-check**

Run: `php -l patterns/home-guides.php`
Expected: `No syntax errors detected`.

- [ ] **Step 3: Manual check — section renders from posts**

Load the homepage. The first audience's posts appear: newest as the large feature card (category chip top-left, title + date + read time, excerpt), the next two as compact cards. Tabs show one button per non-empty audience. Other panels are present in the DOM but hidden (inspect: they have the `hidden` attribute).

- [ ] **Step 4: Commit**

```bash
git add patterns/home-guides.php
git commit -m "Render home guides section from blog posts by audience"
```

---

### Task 4: Tab switching toggles panels (`src/js/modules/tabs.js`)

**Files:**
- Modify: `src/js/modules/tabs.js` (replace the whole module)

- [ ] **Step 1: Replace `src/js/modules/tabs.js`**

```js
// Click-to-activate tabs. Activating a tab marks it .is-active (and aria-selected),
// then shows the matching [data-panel] within the same section and hides the rest.
// Panels are matched by slug: tab[data-tab="x"] -> [data-panel="x"]. No network.

const SELECTOR_ROOT = '[data-tabs]';
const SELECTOR_TAB = '[data-tab]';
const SELECTOR_PANEL = '[data-panel]';

function initTabsRoot(root) {
	const tabs = Array.from(root.querySelectorAll(SELECTOR_TAB));
	if (tabs.length === 0) return;

	// Panels live alongside the tablist inside the section, not within it.
	const scope = root.closest('section') || document;

	function activate(tab) {
		tabs.forEach((node) => {
			const isActive = node === tab;
			node.classList.toggle('is-active', isActive);
			node.setAttribute('aria-selected', isActive ? 'true' : 'false');
		});

		const slug = tab.getAttribute('data-tab');
		scope.querySelectorAll(SELECTOR_PANEL).forEach((panel) => {
			panel.hidden = panel.getAttribute('data-panel') !== slug;
		});
	}

	root.addEventListener('click', (event) => {
		const tab = event.target.closest(SELECTOR_TAB);
		if (!tab || !root.contains(tab)) return;
		activate(tab);
	});
}

export function initTabs(scope = document) {
	scope.querySelectorAll(SELECTOR_ROOT).forEach(initTabsRoot);
}
```

- [ ] **Step 2: Build**

Run: `npm run build`
Expected: build completes with no errors; `build/.vite/manifest.json` updated.

- [ ] **Step 3: Manual check — clicking tabs swaps cards**

On the homepage, click each tab. The active tab gets the active style and the cards swap instantly to that audience's posts with no page reload and no network request (verify in DevTools Network tab — nothing fires). `aria-selected` updates on the buttons.

- [ ] **Step 4: Commit**

```bash
git add src/js/modules/tabs.js
git commit -m "Toggle guide panels on tab click with ARIA state"
```

---

### Task 5: Hidden-panel SCSS guard

**Files:**
- Modify: `src/scss/sections/_home-guides.scss` (add a `[hidden]` rule to `&__grid`)

- [ ] **Step 1: Add the guard inside the `&__grid` block**

In `src/scss/sections/_home-guides.scss`, find:

```scss
	&__grid {
		display: grid;
		// Figma proportions: 795 / 565 inside a 1384 container with a 24px gap.
		// `fr` units preserve that ratio on any screen size.
		grid-template-columns: 795fr 565fr;
		gap: 24px;
		align-items: stretch; // both columns share the same row height
	}
```

Add a `&[hidden]` rule at the end of that block so it reads:

```scss
	&__grid {
		display: grid;
		// Figma proportions: 795 / 565 inside a 1384 container with a 24px gap.
		// `fr` units preserve that ratio on any screen size.
		grid-template-columns: 795fr 565fr;
		gap: 24px;
		align-items: stretch; // both columns share the same row height

		// The `hidden` attribute on inactive tab panels must win over `display: grid`.
		&[hidden] {
			display: none;
		}
	}
```

- [ ] **Step 2: Build**

Run: `npm run build`
Expected: build completes with no errors.

- [ ] **Step 3: Manual check — only one panel visible at load**

Reload the homepage. Only the first audience's panel is visible (no stacked/overlapping panels). Switching tabs still shows exactly one panel.

- [ ] **Step 4: Commit**

```bash
git add src/scss/sections/_home-guides.scss
git commit -m "Hide inactive guide panels over grid display"
```

---

### Task 6: End-to-end edge-case verification

No code — confirm the acceptance criteria against real content.

- [ ] **Step 1: Fewer-than-3-posts case**

Ensure one audience has exactly 1 post. Load the homepage, switch to that tab: the feature card shows and the right stack is empty, with no layout break or PHP notices.

- [ ] **Step 2: Empty-audience case**

Confirm an audience term with **zero** posts produces **no** tab and no panel.

- [ ] **Step 3: Missing featured image / missing category**

Create a post with no featured image and no category. Confirm it shows the placeholder image and no empty chip pill.

- [ ] **Step 4: Read-time correctness**

Pick a post, count its words / 200, round up. Confirm the chip matches (minimum "1 min read").

- [ ] **Step 5: Read More link**

In **Settings → Reading**, set a Posts page. Confirm the "Read More" button links to it (falls back to the site home when unset).

- [ ] **Step 6: Final build + lint sweep**

Run: `npm run build && php -l patterns/home-guides.php && php -l inc/guides-data.php && php -l functions.php`
Expected: build succeeds; each file reports `No syntax errors detected`.

---

## Self-Review Notes

- **Spec coverage:** taxonomy (T1), chip=category + read time + image fallback (T2), data provider/newest-3/feature (T2), dynamic tabs+panels (T3), client-side toggle+ARIA (T4), hidden-panel guard (T5), Read More + edge cases (T3/T6). All spec sections mapped.
- **Type consistency:** view-model keys (`title`, `permalink`, `excerpt`, `date`, `category`, `read_time`, `image`) defined in T2 and consumed unchanged in T3. `data-tab`/`data-panel` slugs match (`$slug` from the same array in both loops; matched by `tabs.js`).
- **No placeholders:** every code step contains complete code; no TBD/TODO.
