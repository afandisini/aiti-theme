=== aiti-solutions ===
Contributors: flashponsel
Requires at least: 6.0
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.3.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Aiti-solutions is a lightweight, high-performance, and SEO-optimized WordPress theme specifically designed for heavy equipment rental services, such as Crane rental businesses. Built with a focus on Core Web Vitals, it ensures blazing-fast loading speeds, a secure user experience, and a modern aesthetic that adapts to user preferences.

== Features ==

* **Product & Blog Separation**: Intelligent template-based filtering on the homepage to distinguish between equipment products and informative articles.
* **Custom Product Template**: A dedicated "Product Detail" template with enhanced call-to-actions and pre-filled WhatsApp interest messages.
* **Dark/Light Mode Support**: Native toggle to switch between dark and light themes for better user accessibility and modern style.
* **SEO Optimizer**: Built-in structured data support, optimized heading hierarchy, and fast loading to help your site rank higher on search engines.
* **Advanced Performance**: Local assets loading (no external CDNs), selective non-blocking icon CSS, and deferred JS execution.
* **Modern Formats**: Native support for WebP and AVIF images to reduce bandwidth and speed up mobile browsing.
* **Security Hardened**: AJAX search with Nonce protection and full XSS output escaping.
* **Dynamic Branding**: Automatic initials generator for the site logo (e.g., "Scy" from "Sewa Crane Yogyakarta").
* **Easy Configuration**: Manage company address, phone, and social media directly from the WordPress Settings menu with automatic WhatsApp link generation.
* **Responsive**: Fully mobile-friendly design using Bootstrap 5.3.2.

== Installation ==

1. Upload the theme folder to the `/wp-content/themes/` directory.
2. Activate 'aiti-solutions' via the Appearance -> Themes menu.
3. Set your company details in the theme options or customizer.

== Theme Configuration & Patching ==

This theme uses custom fields in the WordPress Settings to simplify site management. Configure these options in **Settings -> General**:

* **Company Address (`company_address`)**: Enter the full address (e.g., "Yogyakarta"). This address is used both in the Footer and automatically in the "Lokasi Kami" Google Maps iframe on the Front Page.
* **Company Phone (`company_phone`)**: Enter your phone number (e.g., "08123456789"). The theme automatically generates a WhatsApp link based on this value.
* **Social Media**: Enter your full URLs for `company_facebook`, `company_youtube`, `company_instagram`, and `company_tiktok` to display icons in the footer.

=== Product vs Article Differentiation ===
To make a post appear in the "Produk Crane Kami" section on the Front Page:
1. Go to **Edit Post**.
2. In the **Template** dropdown (under Post Attributes), select **Product Detail**.
3. Posts without this template selected (or using Default Template) will automatically appear in the "Artikel & Berita Terbaru" section.

=== Dynamic FAQ Selection ===
The FAQ section at the bottom of the Front Page is dynamic. To change the content:
1. Create or edit a Post in the WordPress Dashboard.
2. Note the **ID** of the post (visible in the URL when editing).
3. Open `front-page.php` and update the ID in the following line:
   `$privacy_post = get_post(54); // Replace 54 with your Post ID`
4. The content of that post (including Accordion HTML) will be rendered in the FAQ section.

=== Google Maps Location ===
The "Lokasi Kami" section uses the address from `company_address`:
* Ensure the address is clear (e.g., "Jl. Kaliurang No. 10, Yogyakarta").
* The map uses a dynamic search query, so it will automatically center on the address you provide in the settings.

== Frequently Asked Questions ==

= How do I change the logo initials? =
The initials (e.g., "Scy") are automatically generated from the "Site Title" in Settings -> General.

= Does this theme support Gutenberg? =
Yes, but it is optimized for speed by dequeueing unnecessary block library styles when not needed.

== Changelog ==

= 1.3.3 =
* Added robust frontend SEO meta output in `wp_head`:
  - Canonical URL, robots, author, and geo country.
  - Open Graph (`og:*`) and Twitter meta (`twitter:*`) with dynamic page values.
* Added cross-platform favicon/search icon tags:
  - `icon` (32x32), `icon` (192x192), `shortcut icon`, and `apple-touch-icon`.
  - `msapplication-TileColor`, `msapplication-TileImage`, and `theme-color`.
* Added cleanup layer to remove empty SEO tags (`content=""` / `href=""`) injected by third-party plugins.
* Improved heading semantics in hero carousel:
  - First slide uses `<h1>`, subsequent slides use `<h2>`.
* Improved hero image delivery:
  - Kept `fetchpriority="high"` for the first hero image.
  - Tuned responsive `sizes` and switched hero rendering target to `medium_large` to reduce oversized image downloads.

= 1.3.2 =
* SEO revision update focused on Core Web Vitals and media delivery.
* Improved image delivery pipeline for WebP uploads:
  - Added intermediate WebP size generation (`thumbnail`, `medium`, `medium_large`, `large`) in MU-plugin metadata flow.
  - Added lazy metadata backfill for existing WebP attachments missing size metadata.
* Improved responsive image output in card components using `wp_get_attachment_image()` with proper `srcset`/`sizes` to avoid loading oversized originals.
* Reduced CLS risk:
  - Stabilized hero image rendering with fixed aspect-ratio behavior (`.carousel-height`).
  - Ensured attachment-based image outputs retain intrinsic `width`/`height` attributes.
* Improved LCP handling on homepage by preloading first hero image (`imagesrcset` + `imagesizes="100vw"`).
* Deferred Google Maps embed on front page using click-to-load pattern so heavy map payload is not loaded during initial paint.
* Fixed FOUC regression:
  - Restored `bootstrap.min.css` and main theme stylesheet as render-blocking.
  - Kept only `bootstrap-icons.css` as non-blocking with fallback.

= 1.3.1 =
* Fixed image rendering edge case where some thumbnails could output `width="1" height="1"` and become invisible.
* Improved thumbnail fallback logic in Front Page, Index, Single, and Product templates using attachment URL fallback when metadata is incomplete.
* Hardened AJAX search result rendering to sanitize invalid image attributes before output and before DOM injection.
* Redesigned "Produk Terkait" and "Artikel Terkait" cards to horizontal clickable layout (image left, text right) without CTA buttons.
* Added reusable `card-terkait` component styles with touch-friendly horizontal scrolling (`related-scroll`) and dark/light mode support.
* Refined related-content logic:
  - Product Detail now shows only **Produk Terkait** (same category + `product.php` template).
  - Single post now shows only **Artikel Terkait** (same category + non-`product.php` template).
* Added adaptive `.btn-outline-dark` styles for consistent contrast and hover/focus behavior across dark and light mode.

= 1.3.0 =
* Added 'Product Detail' post template for enhanced conversion and product-specific layouts.
* Refactored front-page.php to separate Products and Blog Articles using template metadata.
* Improved product card styling and WhatsApp interest message integration.

= 1.2.1 =
* Implemented AJAX Nonce for search security.
* Enhanced XSS hygiene via consistent output escaping.
* Added wp_body_open() and comments.php for repository compliance.

= 1.2.0 =
* Initial release with performance and SEO optimizations.

== License ==

aiti-solutions is a WordPress Theme, Copyright (C) 2026 flashponsel.
aiti-solutions is distributed under the terms of the GNU GPL.
