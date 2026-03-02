<!DOCTYPE html>
<?php
$aiti_lang = get_bloginfo('language');
if (strtolower((string) $aiti_lang) === 'en-us') {
    $aiti_lang = 'id-ID';
}

$aiti_meta_description = '';
if (is_singular()) {
    $aiti_excerpt = trim((string) get_the_excerpt());
    if ($aiti_excerpt !== '') {
        $aiti_meta_description = wp_strip_all_tags($aiti_excerpt);
    } else {
        $aiti_meta_description = wp_trim_words(wp_strip_all_tags((string) get_the_content()), 30, '...');
    }
} elseif (is_front_page() || is_home()) {
    $aiti_meta_description = (string) get_bloginfo('description');
}

if (trim($aiti_meta_description) === '') {
    $aiti_meta_description = (string) get_bloginfo('description');
}
?>
<html lang="<?php echo esc_attr($aiti_lang); ?>" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>" data-bs-theme="dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo esc_attr(wp_trim_words($aiti_meta_description, 30, '...')); ?>">
    <script>
        // Apply theme immediately before rendering
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
        })();
    </script>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

    <!-- Navbar Transparan -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-transparent-nav shadow-none transition-all" id="mainNav">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo esc_url(home_url('/')); ?>">
                <svg width="35" height="35" viewBox="0 0 192 192" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="96" cy="96" r="96" class="brand-logo-bg"></circle>
                    <text x="96" y="95" class="brand-logo-text" font-family="Arial, Helvetica, sans-serif" font-weight="900" font-size="90" letter-spacing="-15" text-anchor="middle" dominant-baseline="central">
                        <?php echo esc_html(get_site_initials()); ?>
                    </text>
                </svg>
                <span class="visually-hidden"><?php echo esc_html(get_bloginfo('name')); ?></span>
            </a>
            <button class="btn btn-toggle rounded-circle py-1 px-2 border-0" id="themeToggle" aria-label="Toggle theme mode">
                <i class="bi bi-brightness-high"></i>
            </button>
        </div>
    </nav>
    <main id="main-content">
