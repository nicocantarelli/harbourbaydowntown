# Events & Promotions — Design Spec (P2, Phase 1)

## Context

The launch audit's **P2** is the set of sections currently hardcoded or option-driven with no
editable detail pages. The client's direction: **Special Promotions and Events should be separate
pages** with simple information — one picture, information, date, time, location, and a link (an
external URL or an uploaded file).

Today the "What's On" (events) and "Special Promotions" sections are powered by two **option-based
admin pages** ([inc/events-admin.php](../../../inc/events-admin.php),
[inc/promotions-admin.php](../../../inc/promotions-admin.php)) with free-text dates and no detail
pages. This phase replaces that with a real content type + detail pages.

P2 is being built in four phases under the agreed **"reuse + extend / three focused content types"**
architecture. **This spec is Phase 1 only.** Later phases (not built here): 2) Listings detail pages,
3) Dine/Shop category tabs, 4) Ferries.

## Goal

One **Events & Promotions** content type whose items each render a shareable detail page, and which
feeds every events/promotions section across the site — replacing the two option-based admin pages.

## Content type

**CPT `hbd_event`** — menu label "Events & Promotions" (modeled on
[inc/listings.php](../../../inc/listings.php)):
- `public => true`, `publicly_queryable => true`, `show_in_rest => true` (block editor),
  `has_archive => false`, `rewrite => array( 'slug' => 'events' )` (slug easily changeable; chosen to
  avoid clashing with the existing `/whats-on` page).
- `supports => array( 'title', 'editor', 'thumbnail' )`.
- Field mapping: **title** = name · **featured image** = the picture · **editor/content** = the
  "information" (rich text).

**Taxonomy `event_type`** (hierarchical, category-like, `show_admin_column => true`) attached to
`hbd_event`, seeded once with **Event** and **Promotion** (one-time seed guarded by an option flag,
like `hbd_seed_listing_types()`). Each item is tagged one or the other; sections query by it.

**Meta** (registered + sanitized, shown in an "Event details" meta box):
| Key | Field | Sanitize |
|---|---|---|
| `_hbd_event_date` | Date (date input, stored `YYYY-MM-DD`) | date validation |
| `_hbd_event_time` | Time (free text, e.g. "7:00 PM", "Fri–Sat, 9 PM") | `sanitize_text_field` |
| `_hbd_event_location` | Location (text, drives the map) | `sanitize_text_field` |
| `_hbd_event_link_url` | External link URL | `esc_url_raw` |
| `_hbd_event_link_file` | Uploaded file (attachment ID, media picker) | `absint` |
| `_hbd_event_link_label` | CTA label (default "Find out more") | `sanitize_text_field` |

## Data layer — `inc/events.php` (new)

Holds the CPT, taxonomy, seed, meta box, save handler, and query helpers (mirrors
`inc/listings.php`). Required from [functions.php](../../../functions.php).

- **`hbd_get_events( $args )`** — `args`: `type` (`event` | `promotion` | `''`), `number`,
  `upcoming` (bool), `order`. Queries `hbd_event` filtered by the `event_type` term. When
  `upcoming`, adds a `meta_query` for date ≥ today and `orderby` meta date **ASC**; otherwise date
  **DESC** (newest first). Returns view models: `id, title, permalink, image, date_raw,
  date_display, time, location, type`.
- **`hbd_event_cta( $id )`** — resolves the CTA to `array( url, label, is_file, new_tab )` from
  `_hbd_event_link_url` (external, new tab) or `_hbd_event_link_file` (download); returns empty when
  neither is set.
- **`hbd_map_embed( $query )`** — shared Google-map embed helper extracted from
  [patterns/contact-location.php](../../../patterns/contact-location.php) (reuses
  `hbd_contact_map_query`/`hbd_contact_map_key` logic) so the detail page and Contact page share one
  implementation.

## Detail page — `single-hbd_event.php` (new)

Theme-consistent layout: featured image (hero) → title + type chip → date (formatted) / time →
**location text + auto Google map** (via `hbd_map_embed`) → `the_content()` (information) → **CTA
button** from `hbd_event_cta()` (external URL in a new tab, or file download). CTA hidden when no
link is set. New styles in a `src/scss/sections/_event.scss` partial (`@use`d from `main.scss`).

## Sections rewired (cards now link to the detail page)

| Section | File | Change |
|---|---|---|
| Homepage "What's On" | [patterns/home-events.php](../../../patterns/home-events.php) | `hbd_get_events( type=event, number=4 )`; first = wide feature, next 3 = narrow; cards link to permalink. Feature chips become **type + formatted date** (replaces the old free-text tags). Keep Customizer intro (`hbd_events_title`/`_decor`). |
| Homepage "Special Promotions" | [patterns/home-promotions.php](../../../patterns/home-promotions.php) | `hbd_get_events( type=promotion )`; card button → permalink. Keep carousel + Customizer intro (`hbd_promotions_title`/`_text`). |
| What's On — Featured Events | [patterns/whats-on-events.php](../../../patterns/whats-on-events.php) | Build the real grid from `hbd_get_events( type=event, upcoming=true )`; replaces the placeholder note. Keep editable heading/tag. |
| What's On — Promotions | page-whats-on.php (reuses home-promotions) | CPT-driven automatically once the above lands. |
| Dine / Shop "Special Promotions" | [patterns/dine-promotions.php](../../../patterns/dine-promotions.php), [shop-promotions.php](../../../patterns/shop-promotions.php) | Replace hardcoded cards with `hbd_get_events( type=promotion, number=3 )` (newest). Per-page targeting deferred to Phase 3 (categories). |

Section **intro text** (titles / decor words) stays in the Customizer unchanged.

## Admin replacement

- Delete `inc/events-admin.php`, `inc/promotions-admin.php`, `assets/admin/events.js`,
  `assets/admin/promotions.js`; remove their `require_once` lines in `functions.php`.
- Retire the now-unused helpers/options they provided (`hbd_get_events_data`,
  `hbd_events_image_url`, `hbd_default_promotions`, `hbd_promotion_image_url`, options
  `hbd_events_data` / `hbd_promotions`) — replaced by `hbd_get_events()`.
- No data migration: current content is placeholder.

## Rules / edge cases

- **Newest = featured** on the homepage (no separate "featured" flag).
- A type with no published items → the section renders nothing (early `return`), matching the
  existing guides pattern.
- Date stored zero-padded (`YYYY-MM-DD`) so meta sorting is correct; displayed via
  `date_i18n`/site format.
- Detail-page CTA is optional (hidden when no link/file).
- Card/detail images fall back to a bundled placeholder when no featured image is set.

## Files

- **New:** `inc/events.php`, `single-hbd_event.php`, `src/scss/sections/_event.scss`.
- **Edit:** `functions.php`, `src/scss/main.scss`, `patterns/home-events.php`,
  `home-promotions.php`, `whats-on-events.php`, `dine-promotions.php`, `shop-promotions.php`
  (+ minor SCSS for the Featured Events grid).
- **Delete:** `inc/events-admin.php`, `inc/promotions-admin.php`, `assets/admin/events.js`,
  `assets/admin/promotions.js`.
- **Build:** `npm run build` (detail-page + Featured Events styles).

## Verification

1. Add several Events and Promotions in wp-admin (set date/time/location and one with a URL link,
   one with an uploaded file).
2. Homepage "What's On" shows the newest event as the wide feature + 3 narrow; all cards open their
   detail page.
3. Homepage, What's On, and Dine/Shop promotions show promotions; the button opens the detail page.
4. What's On "Featured Events" lists upcoming events soonest-first.
5. Detail page renders image, information, date/time, location + map, and the CTA (verify both the
   URL and the file-download variants; verify no CTA when none set).
6. Old "Events"/"Promotions" admin menus are gone; `php -l` clean on changed files; `npm run build`
   succeeds.

## Later phases (context only — not built here)

2. **Listings** detail pages + external-wins/else-detail behavior + fields (description, location,
   open hours) + `nightlife` type + K Square nearby.
3. **Dine/Shop category tabs** — listing sub-category taxonomy + tab filtering (depends on Phase 2).
4. **Ferries** — operator/route/duration/counter/logo content type.
