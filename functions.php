<?php
function aiti_solutions_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('automatic-feed-links');
}
add_action('after_setup_theme', 'aiti_solutions_setup');

/**
 * Register Custom Theme Settings in Settings > General
 */
function aiti_solutions_register_settings() {
    $settings = [
        'company_address'      => 'Alamat Perusahaan',
        'company_country_code' => 'Kode Negara (Contoh: 62)',
        'company_phone'        => 'Nomor Telepon/WA (Tanpa kode negara, contoh: 08123456789)',
        'company_facebook'     => 'Link Facebook',
        'company_instagram'    => 'Link Instagram',
        'company_youtube'      => 'Link Youtube',
        'company_tiktok'       => 'Link TikTok',
        'meta_google_adsense_account' => 'Meta Google Adsense Account',
        'meta_google_site_verification' => 'Meta Google Site Verification',
        'meta_msvalidate_01'          => 'Meta Bing/MS Validate',
        'meta_yandex_verification'    => 'Meta Yandex Verification',
    ];

    foreach ($settings as $id => $label) {
        register_setting('general', $id, 'sanitize_text_field');
        add_settings_field(
            $id,
            $label,
            function() use ($id) {
                $value = get_option($id, '');
                echo '<input type="text" name="' . esc_attr($id) . '" value="' . esc_attr($value) . '" class="regular-text">';
            },
            'general'
        );
    }
}
add_action('admin_init', 'aiti_solutions_register_settings');

/**
 * Output editable verification meta tags.
 * Values can be managed from Settings > General.
 */
function aiti_solutions_output_verification_meta() {
    $google_adsense = trim((string) get_option('meta_google_adsense_account', ''));
    $google_site_verify = trim((string) get_option('meta_google_site_verification', ''));
    $msvalidate     = trim((string) get_option('meta_msvalidate_01', ''));
    $yandex_verify  = trim((string) get_option('meta_yandex_verification', ''));

    if ($google_adsense === '') {
        $google_adsense = 'ca-pub-9287208024388942';
    }
    if ($google_site_verify === '') {
        $google_site_verify = '-RzYWVoAqqdZswsb-0mK_fvsz6kamJRobLPDOD0lgSU';
    }
    if ($msvalidate === '') {
        $msvalidate = '25D5661750985BDDC7F3A471E5F61FCB';
    }
    if ($yandex_verify === '') {
        $yandex_verify = '2c4e50f51b8d6b62';
    }

    echo "\n" . '<meta name="google-adsense-account" content="' . esc_attr($google_adsense) . '">' . "\n";
    echo '<meta name="google-site-verification" content="' . esc_attr($google_site_verify) . '">' . "\n";
    echo '<meta name="msvalidate.01" content="' . esc_attr($msvalidate) . '">' . "\n";
    echo '<meta name="yandex-verification" content="' . esc_attr($yandex_verify) . '">' . "\n";
}
add_action('wp_head', 'aiti_solutions_output_verification_meta', 1);

/**
 * Build robust frontend meta tags (SEO + social + favicon).
 */
function aiti_solutions_current_canonical_url() {
    if (is_front_page()) {
        return home_url('/');
    }

    if (is_singular()) {
        $canonical = get_permalink();
        if ($canonical) {
            return $canonical;
        }
    }

    global $wp;
    if (!isset($wp) || !is_object($wp) || !isset($wp->request)) {
        return home_url('/');
    }

    $path = (string) $wp->request;
    $url = home_url($path ? '/' . ltrim($path, '/') . '/' : '/');
    $query = isset($_SERVER['QUERY_STRING']) ? trim((string) wp_unslash($_SERVER['QUERY_STRING'])) : '';
    if ($query !== '') {
        $url = $url . '?' . $query;
    }
    return $url;
}

function aiti_solutions_featured_or_site_image() {
    if (is_singular()) {
        $thumb_id = (int) get_post_thumbnail_id();
        if ($thumb_id > 0) {
            $img = wp_get_attachment_image_url($thumb_id, 'large');
            if (!empty($img)) {
                return $img;
            }
        }
    }

    $site_icon = (int) get_option('site_icon');
    if ($site_icon > 0) {
        $icon_url = wp_get_attachment_image_url($site_icon, 'full');
        if (!empty($icon_url)) {
            return $icon_url;
        }
    }

    if (has_custom_logo()) {
        $logo_id = (int) get_theme_mod('custom_logo');
        if ($logo_id > 0) {
            $logo = wp_get_attachment_image_url($logo_id, 'full');
            if (!empty($logo)) {
                return $logo;
            }
        }
    }

    return '';
}

function aiti_solutions_meta_description_text() {
    if (is_singular()) {
        $excerpt = trim((string) get_the_excerpt());
        if ($excerpt !== '') {
            return wp_strip_all_tags($excerpt);
        }
        $content = trim((string) get_the_content());
        if ($content !== '') {
            return wp_trim_words(wp_strip_all_tags($content), 30, '...');
        }
    }
    return (string) get_bloginfo('description');
}

function aiti_solutions_output_seo_meta() {
    if (is_admin()) {
        return;
    }

    $site_name = (string) get_bloginfo('name');
    $title = wp_get_document_title();
    if (trim($title) === '') {
        $title = $site_name;
    }

    $desc = aiti_solutions_meta_description_text();
    if (trim($desc) === '') {
        $desc = $site_name;
    }
    $desc = wp_trim_words($desc, 35, '...');

    $canonical = aiti_solutions_current_canonical_url();
    $image = aiti_solutions_featured_or_site_image();
    $locale = str_replace('-', '_', (string) get_bloginfo('language'));
    if ($locale === '') {
        $locale = 'id_ID';
    }
    $og_type = is_singular() ? 'article' : 'website';

    $author = (string) get_bloginfo('name');
    if (is_singular()) {
        $author_name = get_the_author_meta('display_name', (int) get_post_field('post_author', get_the_ID()));
        if (is_string($author_name) && trim($author_name) !== '') {
            $author = $author_name;
        }
    }

    $theme_color = '#0d6efd';
    $site_icon_id = (int) get_option('site_icon');
    $icon_32 = $site_icon_id > 0 ? wp_get_attachment_image_url($site_icon_id, array(32, 32)) : '';
    $icon_192 = $site_icon_id > 0 ? wp_get_attachment_image_url($site_icon_id, array(192, 192)) : '';
    $icon_270 = $site_icon_id > 0 ? wp_get_attachment_image_url($site_icon_id, array(270, 270)) : '';
    $apple_180 = $site_icon_id > 0 ? wp_get_attachment_image_url($site_icon_id, array(180, 180)) : '';
    $fallback_icon = aiti_solutions_featured_or_site_image();
    if ($icon_32 === '' && $fallback_icon !== '') {
        $icon_32 = $fallback_icon;
    }
    if ($icon_192 === '' && $fallback_icon !== '') {
        $icon_192 = $fallback_icon;
    }
    if ($apple_180 === '' && $fallback_icon !== '') {
        $apple_180 = $fallback_icon;
    }

    echo "\n" . '<!-- AITI SEO Meta -->' . "\n";
    echo '<meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">' . "\n";
    echo '<meta name="author" content="' . esc_attr($author) . '">' . "\n";
    echo '<meta content="id" name="geo.country">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";
    echo '<meta property="og:locale" content="' . esc_attr($locale) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    if ($image !== '') {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    }
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($canonical) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($desc) . '">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    if ($image !== '') {
        echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
    }
    echo '<meta name="msapplication-TileColor" content="' . esc_attr($theme_color) . '">' . "\n";
    if (!empty($icon_270)) {
        echo '<meta name="msapplication-TileImage" content="' . esc_url($icon_270) . '">' . "\n";
    }
    echo '<meta name="theme-color" content="' . esc_attr($theme_color) . '">' . "\n";

    if (!empty($icon_32)) {
        echo '<link rel="icon" href="' . esc_url($icon_32) . '" sizes="32x32">' . "\n";
        echo '<link rel="shortcut icon" href="' . esc_url($icon_32) . '">' . "\n";
    }
    if (!empty($icon_192)) {
        echo '<link rel="icon" href="' . esc_url($icon_192) . '" sizes="192x192">' . "\n";
    }
    if (!empty($apple_180)) {
        echo '<link rel="apple-touch-icon" href="' . esc_url($apple_180) . '">' . "\n";
    }
}
add_action('wp_head', 'aiti_solutions_output_seo_meta', 3);

/**
 * Remove empty SEO meta/link tags injected by third-party plugins.
 */
function aiti_solutions_cleanup_empty_head_tags($html) {
    if (!is_string($html) || $html === '') {
        return $html;
    }

    $patterns = array(
        '/<meta[^>]+name=["\']description["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']author["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']robots["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:locale["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:type["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:title["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:description["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:url["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+property=["\']og:site_name["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']twitter:description["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']twitter:title["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']twitter:image["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']msapplication-TileImage["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<meta[^>]+name=["\']theme-color["\'][^>]+content=["\']\s*["\'][^>]*>\s*/i',
        '/<link[^>]+rel=["\']canonical["\'][^>]+href=["\']\s*["\'][^>]*>\s*/i',
    );

    return preg_replace($patterns, '', $html);
}

add_action('template_redirect', function() {
    if (is_admin() || wp_doing_ajax() || (defined('REST_REQUEST') && REST_REQUEST)) {
        return;
    }
    ob_start('aiti_solutions_cleanup_empty_head_tags');
}, 0);

/**
 * Admin UI tweaks:
 * - Hide top admin bar in wp-admin.
 * - Add quick "Log Out" and "Collapse Menu" items on sidebar top.
 */
function aiti_solutions_admin_ui_css() {
    if (!is_admin()) {
        return;
    }
    echo '<style id="aiti-admin-ui-fix">
        #wpadminbar { display: none !important; }
        html.wp-toolbar { padding-top: 0 !important; }
        #wpcontent, #wpfooter { margin-top: 0 !important; }
    </style>';
}
add_action('admin_head', 'aiti_solutions_admin_ui_css', 99);

function aiti_solutions_admin_shortcuts_menu() {
    if (!is_admin()) {
        return;
    }

    add_menu_page(
        'View Website',
        'View',
        'read',
        'aiti-view-site',
        '__return_null',
        'dashicons-admin-site-alt3',
        998
    );

    add_menu_page(
        'Log Out',
        'Log Out',
        'read',
        'aiti-admin-logout',
        '__return_null',
        'dashicons-exit',
        999
    );
}
add_action('admin_menu', 'aiti_solutions_admin_shortcuts_menu', 1);

function aiti_solutions_handle_admin_shortcuts() {
    if (!is_admin() || !isset($_GET['page'])) {
        return;
    }

    $page = sanitize_key(wp_unslash($_GET['page']));

    if ('aiti-view-site' === $page) {
        wp_safe_redirect(home_url('/'));
        exit;
    }

    if ('aiti-admin-logout' === $page) {
        wp_safe_redirect(wp_logout_url(wp_login_url()));
        exit;
    }

}
add_action('admin_init', 'aiti_solutions_handle_admin_shortcuts');

function aiti_solutions_admin_menu_link_targets() {
    if (!is_admin()) {
        return;
    }
    ?>
    <script>
    (function() {
        var viewLink = document.querySelector('#toplevel_page_aiti-view-site > a');
        if (viewLink) {
            viewLink.setAttribute('target', '_blank');
            viewLink.setAttribute('rel', 'noopener noreferrer');
            viewLink.setAttribute('href', <?php echo wp_json_encode(home_url('/')); ?>);
        }
    })();
    </script>
    <?php
}
add_action('admin_print_footer_scripts', 'aiti_solutions_admin_menu_link_targets');

function aiti_solutions_admin_footer_text($text) {
    if (!is_admin()) {
        return $text;
    }

    return '<span id="footer-thankyou">CSM Modified by <a href="https://aiti-solutions.com" target="_blank" rel="noopener noreferrer">Aiti-Solutions</a></span>';
}
add_filter('admin_footer_text', 'aiti_solutions_admin_footer_text', 99);

/**
 * 2. Optimized Enqueue Scripts & Styles
 */
function aiti_solutions_scripts() {
    // Safety guard: never load frontend assets in wp-admin.
    if (is_admin()) {
        return;
    }

    $theme_version = wp_get_theme()->get('Version');

    // Styles
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.3.2');
    wp_enqueue_style('bootstrap-icons', get_template_directory_uri() . '/assets/css/bootstrap-icons.css', array(), '1.11.1');
    wp_enqueue_style('aiti-style', get_stylesheet_uri(), array(), $theme_version);
    
    // 3. Defer JS: Load in footer with 'true' parameter
    wp_enqueue_script('bootstrap-bundle', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), '5.3.2', true);
    
    // Localize for AJAX with Nonce
    wp_localize_script('bootstrap-bundle', 'aiti_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('aiti_search_nonce')
    ));

    // Custom Professional Admin Bar CSS (Frontend Only)
    if (is_admin_bar_showing() && !is_admin()) {
        $custom_admin_bar_css = "
            #wpadminbar {
                background: #0f172a !important;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            }
            #wpadminbar .ab-item, #wpadminbar a.ab-item {
                color: #e2e8f0 !important;
                font-size: 13px !important;
                font-weight: 500 !important;
            }
            #wpadminbar .ab-icon:before, #wpadminbar .ab-item:before {
                color: #94a3b8 !important;
            }
            #wpadminbar .quicklinks li:hover > a, #wpadminbar .quicklinks li.hover > a {
                background: #1e293b !important;
                color: #3b82f6 !important;
            }
            #wpadminbar .ab-sub-wrapper, #wpadminbar ul.ab-submenu {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
                border-radius: 12px !important;
                margin-top: 5px !important;
                padding: 8px 0 !important;
                overflow: hidden !important;
            }
            #wpadminbar .ab-submenu .ab-item {
                color: #475569 !important;
                padding: 8px 20px !important;
            }
            #wpadminbar .ab-submenu li:hover > .ab-item {
                background: #f1f5f9 !important;
                color: #2563eb !important;
            }
            #wpadminbar #wp-admin-bar-my-account.with-avatar > .ab-item img {
                border-radius: 50% !important;
                width: 26px !important;
                height: 26px !important;
            }
        ";
        wp_add_inline_style('aiti-style', $custom_admin_bar_css);
    }
}
add_action('wp_enqueue_scripts', 'aiti_solutions_scripts', 100);

/**
 * Preload first hero image (homepage) to improve LCP.
 */
function aiti_solutions_preload_lcp_image() {
    if (is_admin() || !is_front_page()) {
        return;
    }

    $hero_query = new WP_Query(array(
        'posts_per_page' => 1,
        'ignore_sticky_posts' => 1,
        'no_found_rows' => true,
        'fields' => 'ids',
    ));

    if (!$hero_query->have_posts()) {
        return;
    }

    $post_id = (int) $hero_query->posts[0];
    $thumb_id = (int) get_post_thumbnail_id($post_id);
    if ($thumb_id <= 0) {
        return;
    }

    $src = wp_get_attachment_image_url($thumb_id, 'medium_large');
    if (!$src) {
        return;
    }

    $srcset = wp_get_attachment_image_srcset($thumb_id, 'medium_large');
    echo '<link rel="preload" as="image" href="' . esc_url($src) . '"';
    if ($srcset) {
        echo ' imagesrcset="' . esc_attr($srcset) . '"';
    }
    echo ' imagesizes="(max-width: 767px) 100vw, (max-width: 1200px) 90vw, 676px">' . "\n";
}
add_action('wp_head', 'aiti_solutions_preload_lcp_image', 2);

/**
 * 2b. Preload Critical CSS Filter
 */
add_filter('style_loader_tag', function($tag, $handle) {
    if (is_admin()) {
        return $tag;
    }

    if ('bootstrap-icons' === $handle) {
        if (preg_match('/href=(["\'])(.*?)\1/i', $tag, $matches)) {
            $href = $matches[2];
            return '<link rel="preload" as="style" href="' . esc_url($href) . '" onload="this.onload=null;this.rel=\'stylesheet\'">' .
                '<noscript><link rel="stylesheet" href="' . esc_url($href) . '"></noscript>';
        }
        return $tag;
    }
    return $tag;
}, 10, 2);

/**
 * 3b. Defer JS Filter
 */
add_filter('script_loader_tag', function($tag, $handle) {
    if (is_admin()) {
        return $tag;
    }

    if ('bootstrap-bundle' === $handle) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}, 10, 2);

/**
 * 5. WebP & AVIF Support
 */
add_filter('upload_mimes', function($mimes) {
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    return $mimes;
});

// Image performance defaults for better page speed/SEO signals.
add_filter('wp_get_attachment_image_attributes', function($attr, $attachment, $size) {
    if (is_admin()) {
        return $attr;
    }

    if (empty($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }

    if (empty($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }

    // Prevent broken 1x1 intrinsic size from invalid metadata.
    $has_bad_width  = isset($attr['width']) && (int) $attr['width'] <= 1;
    $has_bad_height = isset($attr['height']) && (int) $attr['height'] <= 1;
    if ($has_bad_width || $has_bad_height) {
        $resolved = false;
        if ($attachment instanceof WP_Post && !empty($attachment->ID)) {
            $downsize = image_downsize((int) $attachment->ID, $size);
            if (is_array($downsize) && !empty($downsize[1]) && !empty($downsize[2]) && (int) $downsize[1] > 1 && (int) $downsize[2] > 1) {
                $attr['width'] = (int) $downsize[1];
                $attr['height'] = (int) $downsize[2];
                $resolved = true;
            }
        }

        if (!$resolved) {
            unset($attr['width'], $attr['height']);
        }
    }

    return $attr;
}, 10, 3);

// Final HTML guard: strip invalid 1x1 size attributes if any plugin/filter re-adds them later.
add_filter('wp_get_attachment_image', function($html) {
    if (is_admin() || !is_string($html) || $html === '') {
        return $html;
    }
    return preg_replace('/\s(?:width|height)=["\'](?:0|1)["\']/i', '', $html);
}, 999, 1);

// Disable Gutenberg Block Library CSS
add_action('wp_enqueue_scripts', function() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
}, 100);

// Custom excerpt length for cards
add_filter('excerpt_length', function($length) {
    return 20;
}, 999);

add_filter('excerpt_more', function($more) {
    return '...';
});

// Cache helper: detect external object cache availability.
function aiti_solutions_is_object_cache() {
    return function_exists('wp_using_ext_object_cache') && wp_using_ext_object_cache();
}

// Cache helper: object cache first, transient fallback.
function aiti_solutions_cache_get($key, $group) {
    if (aiti_solutions_is_object_cache()) {
        return wp_cache_get($key, $group);
    }
    return get_transient($key);
}

function aiti_solutions_cache_set($key, $value, $ttl, $group) {
    if (aiti_solutions_is_object_cache()) {
        return wp_cache_set($key, $value, $group, $ttl);
    }
    return set_transient($key, $value, $ttl);
}

// AJAX Search Handler
function aiti_ajax_search() {
    // Nonce Check for security
    check_ajax_referer('aiti_search_nonce', 'nonce');

    $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '0.0.0.0';
    $rate_key = 'aiti_search_rl_' . substr(sha1($ip), 0, 16);
    $rate_hits = (int) get_transient($rate_key);
    if ($rate_hits >= 25) {
        status_header(429);
        echo '<div class="col-12 text-center"><p class="text-muted">Terlalu banyak permintaan. Coba lagi dalam 1 menit.</p></div>';
        wp_die();
    }
    set_transient($rate_key, $rate_hits + 1, 60);

    $raw_search = isset($_POST['search']) ? sanitize_text_field(wp_unslash($_POST['search'])) : '';
    $search = trim($raw_search);
    if (function_exists('mb_substr')) {
        $search = mb_substr($search, 0, 40);
        $search_len = mb_strlen($search);
    } else {
        $search = substr($search, 0, 40);
        $search_len = strlen($search);
    }

    if ($search_len < 3) {
        echo '<div class="col-12 text-center"><p class="text-muted">Kata kunci minimal 3 karakter.</p></div>';
        wp_die();
    }

    // Post type selection: prioritize "produk", fallback to "post".
    $post_type = post_type_exists('produk') ? 'produk' : 'post';
    $post_type = apply_filters('aiti_search_post_type', $post_type);
    if (!is_string($post_type) || !post_type_exists($post_type)) {
        $post_type = 'post';
    }

    $posts_per_page = (int) apply_filters('aiti_search_posts_per_page', 4);
    if ($posts_per_page < 1) {
        $posts_per_page = 4;
    }

    $cache_ttl = (int) apply_filters('aiti_search_cache_ttl', 120);
    if ($cache_ttl < 1) {
        $cache_ttl = 120;
    }

    $salt = 'v3';
    $locale = function_exists('determine_locale') ? determine_locale() : get_locale();
    $cache_key = 'aiti_search:' . $salt . ':' . $locale . ':' . $post_type . ':' . sha1(strtolower($search));
    $cache_group = 'aiti-solutions';

    $cached_html = aiti_solutions_cache_get($cache_key, $cache_group);
    if (false !== $cached_html && '' !== $cached_html) {
        echo $cached_html;
        wp_die();
    }

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $posts_per_page,
        's' => $search,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
    );

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $title = get_the_title();
            $permalink = get_permalink();
            $excerpt = wp_trim_words(wp_strip_all_tags(get_the_excerpt()), 15);
            ?>
            <div class="col-md-3 col-sm-4">
                <div class="card h-100 shadow-sm transition-hover rounded-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php
                        $thumb_id = get_post_thumbnail_id();
                        $thumb_html = $thumb_id ? wp_get_attachment_image($thumb_id, 'medium', false, ['class' => 'card-img-top rounded-top-4', 'style' => 'height: 200px; width: 100%; object-fit: cover;', 'sizes' => '(max-width: 576px) 100vw, (max-width: 992px) 50vw, 265px', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => esc_attr($title)]) : '';
                        if ($thumb_html) {
                            echo $thumb_html;
                        }
                        ?>
                    <?php else : ?>
                        <div class="aiti-placeholder card-img-top rounded-top-4" style="height: 200px;">
                            <?php echo get_aiti_initials($title); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold"><?php echo esc_html($title); ?></h3>
                        <p class="card-text text-muted">
                            <?php echo esc_html($excerpt); ?>
                        </p>
                    </div>
                    <div class="card-footer text-center bg-transparent border-0 pb-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="<?php echo esc_url($permalink); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-link"></i> Baca
                            </a>
                            <?php 
                            $phone = get_option('company_phone');
                            $wa_phone = preg_replace('/[^0-9]/', '', (string) $phone);
                            $wa_link = 'https://wa.me/' . rawurlencode($wa_phone) . '?text=' . rawurlencode('Info tentang ' . $title);
                            ?>
                            <a href="<?php echo esc_url($wa_link); ?>" class="btn btn-success btn-sm rounded-pill px-3">
                                <i class="bi bi-whatsapp"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile;
    else : ?>
        <div class="col-12 text-center">
            <p class="text-muted">Produk "<?php echo esc_html($search); ?>" tidak ditemukan.</p>
        </div>
    <?php endif;
    wp_reset_postdata();

    $html = ob_get_clean();
    $html = preg_replace('/\s(?:width|height)=["\']?(?:0|1)["\']?/i', '', $html);
    aiti_solutions_cache_set($cache_key, $html, $cache_ttl, $cache_group);
    echo $html;
    wp_die();
}
add_action('wp_ajax_aiti_search', 'aiti_ajax_search');
add_action('wp_ajax_nopriv_aiti_search', 'aiti_ajax_search');

// SEO Friendly URL for Semua Produk
function aiti_custom_rewrite_rules() {
    add_rewrite_rule('^semua-produk/page/([0-9]+)/?', 'index.php?view_all=1&paged=$matches[1]', 'top');
    add_rewrite_rule('^semua-produk/?$', 'index.php?view_all=1', 'top');
}
add_action('init', 'aiti_custom_rewrite_rules');

function aiti_query_vars($vars) {
    $vars[] = 'view_all';
    return $vars;
}
add_filter('query_vars', 'aiti_query_vars');

// Limit archive/search to 8 posts per page
function aiti_limit_archive_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_search() || is_category() || is_tag() || get_query_var('view_all')) {
            $query->set('posts_per_page', 8);
        }
    }
}
add_action('pre_get_posts', 'aiti_limit_archive_posts');

// Force index.php template when view_all is present
function aiti_template_redirect($template) {
    if (get_query_var('view_all')) {
        $new_template = locate_template(array('index.php'));
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'aiti_template_redirect');

// Remove old localize function as it's merged above

/**
 * Get site initials from blog name
 * Example: "Sewa Crane Yogyakarta" -> "Scy"
 * "Aiti Solutions" -> "Ais"
 * "Google" -> "Goo"
 */
function get_site_initials() {
    $name = get_bloginfo('name');
    $words = array_values(array_filter(explode(' ', $name)));
    $initials = '';
    
    if (count($words) >= 3) {
        // First letter of each of the first 3 words
        $initials = strtoupper(substr($words[0], 0, 1)) . 
                    strtolower(substr($words[1], 0, 1)) . 
                    strtolower(substr($words[2], 0, 1));
    } elseif (count($words) == 2) {
        // First 2 letters of first word + first letter of second word
        $initials = strtoupper(substr($words[0], 0, 2)) . 
                    strtolower(substr($words[1], 0, 1));
    } else {
        // First 3 letters of the only word
        $initials = ucfirst(substr($words[0] ?? $name, 0, 3));
    }
    
    return $initials;
}

/**
 * Generate dynamic JSON-LD Schema
 */
function aiti_generate_json_ld() {
    $site_name    = get_bloginfo('name');
    $site_url     = home_url('/');
    $site_desc    = get_bloginfo('description');
    $site_logo    = get_site_icon_url() ?: (has_custom_logo() ? wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full')[0] : '');
    $phone        = get_option('company_phone');
    $address_text = get_option('company_address');
    
    $schema = [];

    if (is_front_page()) {
        // LocalBusiness Schema for Homepage
        $schema = [
            "@context" => "https://schema.org",
            "@type"    => "LocalBusiness",
            "name"     => $site_name,
            "url"      => $site_url,
            "logo"     => $site_logo,
            "image"    => $site_logo,
            "description" => $site_desc,
            "telephone"   => $phone,
            "address"     => [
                "@type"           => "PostalAddress",
                "streetAddress"   => $address_text,
                "addressLocality" => "Yogyakarta",
                "addressRegion"   => "DIY",
                "addressCountry"  => "ID"
            ],
            "openingHours" => "Mo-Su 00:00-23:59"
        ];
    } elseif (is_single()) {
        // Service Schema for Articles/Posts
        $schema = [
            "@context"    => "https://schema.org",
            "@type"       => "Service",
            "serviceType" => get_the_title(),
            "provider"    => [
                "@type"     => "LocalBusiness",
                "name"      => $site_name,
                "url"       => $site_url,
                "telephone" => $phone
            ],
            "areaServed" => [
                "@type" => "Place",
                "name"  => "Yogyakarta"
            ],
            "description" => wp_trim_words(wp_strip_all_tags(get_the_excerpt() ?: get_the_content()), 30)
        ];
    }

    if (!empty($schema)) {
        echo "\n" . '<!-- AITI Schema -->' . "\n";
        echo '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . '</script>' . "\n";
    }
}
add_action('wp_head', 'aiti_generate_json_ld');

/**
 * Get initials from title
 */
function get_aiti_initials($title) {
    $words = explode(' ', $title);
    $initials = '';
    foreach ($words as $w) {
        if (!empty($w)) {
            $initials .= strtoupper(substr($w, 0, 1));
        }
    }
    return substr($initials, 0, 3); // Limit to 3 characters
}
