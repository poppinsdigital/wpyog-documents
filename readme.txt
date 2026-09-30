=== WPYog Documents ===

Contributors: wpyog
Donate link: https://poppinsdigital.com/
Tags: documents, document management, pdf, file download, document library
Requires at least: 5.0
Tested up to: 7.1
Stable tag: 1.5.4
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Upload, organize, and display documents (PDF, Word, Excel, PowerPoint) on any page using a simple shortcode.

== Description ==
WPYog Documents is a free, versatile WordPress document listing and management plugin. Upload, organize, and display PDF, Word, Excel, PowerPoint, and any other file type directly from your WordPress dashboard using a simple shortcode.

[View Live Demo](https://demo.poppinsdigital.com/wpyog-documents/)

**Key Features**

* Display documents on any post, page, or widget area using the `[wpyog-document-list]` shortcode
* Organize documents into categories
* Filter, sort, and limit the document list via shortcode attributes
* Secure file downloads via nonce-verified AJAX
* Supports all common file types: PDF, DOCX, XLSX, PPTX, images, audio, video, zip archives, and more
* No programming knowledge required — works out of the box

**Shortcode: [wpyog-document-list]**

Place this shortcode on any post or page to list documents. Available attributes:

* `category` — filter by category ID. Example: `[wpyog-document-list category="7"]`
* `desc` — show/hide description. `1` = show, `0` = hide. Example: `[wpyog-document-list desc="1"]`
* `date` — show/hide upload date. `1` = show, `0` = hide. Example: `[wpyog-document-list date="1"]`
* `orderby` — field to sort by. Accepts `date`. Example: `[wpyog-document-list orderby="date"]`
* `order` — sort direction. `DESC` or `ASC`. Example: `[wpyog-document-list order="ASC"]`
* `download` — show/hide download button. `1` = show, `0` = hide. Example: `[wpyog-document-list download="1"]`
* `limit` — maximum number of documents to show. Example: `[wpyog-document-list limit="5"]`
* `pagination` — set to `1` to split the list into pages. `limit` then sets the documents per page (default 10). Example: `[wpyog-document-list limit="10" pagination="1"]`
* `columns` — number of columns (1–4). Default is 1. Example: `[wpyog-document-list columns="2"]`

To display a single document, use the `[wpyog-document]` shortcode:

* `id` — document ID to display. Example: `[wpyog-document id="4"]`

**Supported File Types**

* Microsoft Word (DOC, DOCX, DOCM, DOTM, DOTX)
* Microsoft Excel (XLS, XLSX, XLSB, XLSM)
* Microsoft PowerPoint (PPT, PPTX, PPSX, PPS, PPTM, POTM, PPAM, POTX, PPSM)
* Adobe PDF
* Images (PNG, JPG, GIF, WEBP, SVG)
* Audio (MP3, WAV)
* Video (MP4, WEBM, AVI, MOV, WMV)
* Archives (ZIP, RAR, TAR, GZ, 7Z)
* Plain text and more


== Installation ==

1. Download the plugin and unzip it.
2. Place the `wpyog-documents` folder in your `wp-content/plugins` folder.
3. Activate the plugin from the Plugins tab of your WordPress admin.
4. Go to **WPYog Documents** in the admin menu and add your documents.
5. Place `[wpyog-document-list]` on any post or page to display documents.

You can find each document's ID in the Shortcode column of the Documents list in your admin.

== Frequently Asked Questions ==

= Can I request a feature? =
Yes — we'd love to hear from you.

= Does it support all file types? =
Yes. Any file you can upload to WordPress can be listed. Icons are shown for the most common types.

= Is it compatible with page builders? =
Yes. The shortcode works in any editor or page builder that supports WordPress shortcodes.

== Screenshots ==

1. WPYog Documents List — admin view of all uploaded documents with shortcode column.
2. Add / Edit Document — upload a file and set title and description from the admin.
3. Shortcode Generator — live admin tool to build shortcodes with all parameters and one-click copy.
4. Document List (Frontend) — card-row layout with color-coded file type icons and download buttons.
5. Single Document (Frontend) — individual document box with left accent border and description.
6. Category Document List (Frontend) — filtered list with date badge, download button, and description.

== Changelog ==

= 1.5.4 =
Security

* Hardened download handler: sanitized filename used in Content-Disposition header to strip CRLF and quote characters that could enable header injection.
* Hardened download handler: sanitized MIME type string with a character allowlist before writing it into the Content-Type header.

= 1.5.3 =
Security

* Fixed path traversal vulnerability in the file download handler — the resolved file path is now verified to remain within the WordPress uploads directory using realpath(). Stored document links that do not originate from the uploads base URL are also rejected at save time and at download time.
* Fixed unauthenticated access to unpublished documents — the download handler now verifies the requested post is a published wpyog_document before serving the file.

= 1.5.2 =
* New: pagination. Add `pagination="1"` to `[wpyog-document-list]` and use `limit` as documents per page. Works with several lists on one page.
* New: pagination option in the Shortcode Generator.
* Fixed: pagination links now work inside Divi 5 (page links no longer carry a #fragment, which Divi's smooth scroll intercepted).
* Pagination CSS uses its own `wpyog-doc-pagination` class so it does not clash with other WPYog plugins.
* Improved: frontend styles now load inside the Divi visual builder and Elementor editor preview.
* Checked: classic editor, block editor (Shortcode block), Elementor Shortcode widget, Divi 4 and Divi 5 code/text modules.

= 1.5.1 =
Bug Fixes

* Fixed Plugin Check slow query warning — added phpcs:ignore for tax_query (required for taxonomy-based category filtering; no alternative approach exists in WP_Query).
* Updated "Tested up to" to WordPress 7.1 to ensure the plugin appears in WordPress.org search results.

= 1.5.0 =
New Features

* Added `columns` shortcode attribute — display documents in a 2, 3, or 4 column grid layout. Example: `[wpyog-document-list columns="2"]`. Responsive: collapses to 2 columns on tablet, 1 column on mobile.
* Added live Shortcode Generator admin page (replaces static Shortcode Reference). Includes category dropdown populated from real categories, columns selector, limit, sort, and display options with a one-click copy button.
* Added "More Plugins" section to the Shortcode Generator page showcasing WPYog Team, WPYog News, and poppinsdigital.com.

Design / CSS

* Complete frontend CSS redesign — replaced plain bullet list with a professional card-row layout.
* Color-coded file type icon badges: PDF (red), Word (blue), Excel (green), PowerPoint (orange), Images (purple), ZIP (yellow).
* Hover effects: accent left-bar, icon scale, download button lift shadow.
* Download action rendered as a pill icon button with aria-label.
* Date displayed as a rounded badge.
* Description shown with a light hairline separator.
* Single document box styled with left accent border and hover lift shadow.
* Fully responsive — mobile (≤768px) collapses all layouts to 1 column; tablet (≤900px) collapses 3–4 columns to 2.

Admin UX

* Admin sidebar menu label changed from "WPYog Documents" to "Documents".
* Admin sidebar icon now renders correctly on all admin pages (not just document screens).
* Updated Author and Author URI to poppinsdigital.com.
* Updated plugin description shown in the WordPress Plugins list screen.
* Shortcode column in the document list retained for quick copy.

Bug Fixes

* Fixed missing `wp_reset_postdata()` after both WP_Query loops — was corrupting the global `$post` for anything rendered after the shortcode.
* Fixed incorrect `esc_html()` on an array in the single document shortcode.
* Fixed `wpautop()` wrapping shortcode output — was injecting `<p>` tags inside `<ul>/<li>` causing invalid HTML.
* Fixed `$wpdb->prepare()` usage — SHOW TABLES query now uses `prepare()` with `%s` placeholder and `esc_like()`.
* Fixed unsafe `$wpdb` direct table name interpolation in legacy upgrade routine — now uses `esc_sql()`.
* Fixed description overflow in multi-column layouts — switched from `margin-left` to `padding-left` with `box-sizing: border-box`.
* Fixed title text rendering vertically in document list — added `flex: 1; min-width: 0` to title link.

Code Quality / Security

* Removed `extract()` from shortcode function — replaced with explicit variable assignments.
* Scoped admin CSS and JS to wpyog_document post type screens only (was loading on all admin pages).
* Added `WPYOG_DOCUMENTS_VERSION` constant for proper asset cache-busting on updates.
* Added `if ( ! defined( 'ABSPATH' ) ) exit;` guard.
* Prefixed all template variables with `wpyog_` for WordPress coding standards compliance.
* Renamed `save_wpyog_document_meta_data` → `wpyog_save_document_meta_data`.
* Added translators comment for aria-label sprintf call.
* Frontend CSS now loads only when a shortcode is present on the page (lazy load).
* All upgrade notices trimmed to under 300 characters.
* Tested on WordPress 7.0. Requires WordPress 5.0+.

= 1.3.7 =
* Added other file type icons.
* Tested on WordPress 6.9.

= 1.3.6 =
* Security enhancements.
* Added wp_unslash() to unslash user input.
* Added text domain for translation.

= 1.3.5 =
* Added new route to download the file.
* Security enhancements.
* Added nonce to meta fields of the plugin.

= 1.3.4 =
* Added sanitize function for the text input field.

== Upgrade Notice ==

= 1.5.4 =
Security hardening: header injection prevention in the file download handler. Recommended update.

= 1.5.3 =
Security release. Fixes path traversal and unpublished document disclosure vulnerabilities in the file download handler. Update immediately.

= 1.5.2 =
Adds pagination (`pagination="1"`) and builder compatibility improvements. Safe to update.

= 1.5.1 =
Minor fix — updates "Tested up to" to WordPress 7.1 and resolves Plugin Check warnings. Safe to update.

= 1.5.0 =
Major update — new column layout, Shortcode Generator, full CSS redesign, and multiple bug fixes. Fully backward compatible. Safe to update.

= 1.3.7 =
Added other file icons. Tested on WordPress 6.9.

= 1.3.6 =
Security enhancements. Added text domain for translation.

= 1.3.5 =
Files can now be downloaded safely with nonce. Security enhancements.

= 1.3.4 =
Sanitized the text input field to prevent XSS attacks.
