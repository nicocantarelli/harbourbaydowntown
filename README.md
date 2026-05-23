# Harbour Bay Downtown

A custom WordPress block theme for **Harbour Bay Downtown** — the waterfront district in Batam, Indonesia. The theme pairs a hand-built, Customizer-driven front end with custom post types, lead-capture forms, and a venue importer, so almost all content (text, images, listings, events, ferries) is editable from the WordPress admin.

- **Requires:** WordPress 6.4+, PHP 8.0+
- **Build tooling:** Node.js 18+, [Vite](https://vitejs.dev/) 5, [Sass](https://sass-lang.com/)
- **Text domain:** `harbour-bay-downtown`

---

## Quick start

```bash
# 1. Install build dependencies
npm install

# 2. Build the front-end assets (CSS + JS)
npm run build
```

Then, in WordPress:

1. Activate **Harbour Bay Downtown** under **Appearance → Themes**.
2. **Settings → Permalinks → Save Changes** once (registers the custom post type URLs).
3. Edit content under **Appearance → Customize** and the custom post type menus (Listings, Events, Ferries).

### npm scripts

| Script | What it does |
| --- | --- |
| `npm run build` | Production build → hashed assets in `build/`. |
| `npm run dev` | Rebuild on file change (`vite build --watch`, development mode). |
| `npm run preview` | Vite preview server. |

---

## Build system

SCSS and JS source live in [`src/`](src/). Vite compiles them to **`build/`** with content-hashed filenames, and PHP resolves the current hashed file through `build/.vite/manifest.json` (see `hbd_vite_asset()` in [`functions.php`](functions.php)).

> **`build/` and `node_modules/` are git-ignored.** A fresh clone has no compiled assets, so the site won't render styles until you run `npm install && npm run build`. If you need a "drop the folder on the server" deployment (no Node available at deploy time), commit the `build/` directory as well.

Admin-only JavaScript in [`assets/admin/`](assets/admin/) is **not** bundled by Vite — it's enqueued directly.

---

## Project structure

```
harbour-bay-downtown/
├── functions.php           # Theme setup, asset loading, includes
├── front-page.php          # Homepage (renders patterns)
├── page-*.php              # One template per secondary page (stay, dine, contact, …)
├── single-hbd_*.php        # Detail pages for listings / events
├── index.php, single.php   # Blog archive + single post
├── search.php, 404.php
├── header.php, footer.php
├── patterns/               # PHP "patterns" rendered via do_blocks()
├── inc/
│   ├── customizer.php       # All Customizer panels/controls
│   ├── listings.php         # Listings CPT + taxonomies
│   ├── events.php           # Events & Promotions CPT
│   ├── ferries.php          # Ferries CPT + FAQ data
│   ├── buildings.php        # Buildings CPT
│   ├── guides-data.php      # Blog/guide taxonomies + view models
│   ├── forms.php            # Lead-form handler + Enquiries CPT
│   ├── import-listings.php  # WP-CLI venue importer
│   ├── data/hbd-venues.json # Bundled venue data for the importer
│   └── *-admin.php          # Admin UIs (map pins, explore cards, FAQ widget)
├── assets/                  # Bundled images, fonts, icons, admin JS
├── src/scss, src/js         # Front-end source (compiled by Vite)
├── build/                   # Compiled assets (git-ignored)
└── theme.json               # Block settings, color/typography presets
```

---

## Editing content

### Customizer
Most front-end text and images are editable under **Appearance → Customize**, organized into per-page panels (Homepage, Stay, Dine, Contact, Advertising, etc.). Editable images fall back to bundled defaults until an upload replaces them (`hbd_resolve_image()`).

### Custom post types

| Post type | Menu | Taxonomies |
| --- | --- | --- |
| `hbd_listing` | **Listings** | `listing_type` (Stay / Dine / Shop / Wellness / Nightlife), `listing_category` |
| `hbd_event` | **Events** | `event_type` (Event / Promotion) |
| `hbd_ferry` | **Ferries** | `ferry_direction` (International / Domestic) |
| `hbd_building` | **Buildings** | — |
| `hbd_enquiry` | **Enquiries** | — (form submissions; see below) |

Blog posts use two extra taxonomies: **`audience`** (drives the homepage Guides tabs) and **`guide_section`** (drives the Guides carousels on secondary pages such as Stay / Dine).

---

## Lead-capture forms

Four front-end forms (Contact, Advertising, Sales & Leasing, Live & Work) submit over AJAX. Each submission:

1. is emailed via `wp_mail()` to a recipient chosen by **topic routing** (e.g. media enquiries → marcomm, sales/leasing → leasing manager), and
2. is saved as an **Enquiry** post (`hbd_enquiry`) as a permanent backup.

> **Production email:** `wp_mail()` will not deliver on most local/fresh installs without SMTP configured. Install and configure an SMTP plugin (e.g. WP Mail SMTP) so the emails actually send. The **Enquiries** admin list guarantees no lead is lost regardless.

---

## Listings importer (WP-CLI)

The theme ships with venue data in [`inc/data/hbd-venues.json`](inc/data/hbd-venues.json) and a WP-CLI command to create Listings from it (idempotent by title, so it is safe to re-run):

```bash
wp hbd import-listings              # create everything, sideloading photos
wp hbd import-listings --dry-run    # preview only, creates nothing
wp hbd import-listings --no-photos  # skip photo downloads (faster)
wp hbd import-listings --limit=5    # only the first 5 (test run)
wp hbd import-listings --fresh      # delete ALL existing Listings first, then import
```

> Running under **Local by Flywheel**: use the site's shell (right-click the site → *Open site shell*) so WP-CLI can reach the database. After importing, visit **Settings → Permalinks → Save** (or `wp rewrite flush`).

---

## Blog setup

The homepage is always rendered by `front-page.php`, so to expose a blog you must assign a dedicated Posts page:

1. **Pages → Add New** → create an empty page (e.g. "Blog") → Publish.
2. **Settings → Reading** → *Your homepage displays* = **A static page** → set **Homepage** to your home page and **Posts page** to the Blog page.
3. **Settings → Permalinks → Save**.

Posts render as guide-style cards on the archive ([`index.php`](index.php)) and as a left-aligned editorial article on the single view ([`single.php`](single.php)). The category, featured image, and an estimated reading time are shown automatically.

---

## Deployment checklist

- [ ] `npm install && npm run build` (or commit `build/` for a no-Node deploy)
- [ ] Activate the theme and **save Permalinks** once
- [ ] Configure SMTP so form emails deliver
- [ ] Assign **Homepage** + **Posts page** under Settings → Reading
- [ ] (Optional) run `wp hbd import-listings` to seed Listings

---

## License

GNU General Public License v2 or later. See the header in [`style.css`](style.css).
