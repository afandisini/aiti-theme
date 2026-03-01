<!DOCTYPE html>
<html <?php language_attributes(); ?> data-bs-theme="dark">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
