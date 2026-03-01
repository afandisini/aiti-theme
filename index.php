<?php get_header(); ?>

    <!-- Slideshow Section (Carousel) -->
    <div id="heroCarousel" class="carousel slide carousel-fade mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $args = array(
                'posts_per_page' => 5,
                'ignore_sticky_posts' => 1
            );
            $latest_posts = new WP_Query($args);
            $i = 0;
            if ($latest_posts->have_posts()) : while ($latest_posts->have_posts()) : $latest_posts->the_post();
            ?>
            <div class="carousel-item <?php echo ($i == 0) ? 'active' : ''; ?>">
                <div class="carousel-img-overlay"></div>
                <?php if (has_post_thumbnail()) : ?>
                    <?php
                    $thumb_id = get_post_thumbnail_id();
                    $is_first_slide = (0 === $i);
                    $hero_attrs = array(
                        'class' => 'd-block w-100 carousel-height object-fit-cover',
                        'alt' => esc_attr(get_the_title()),
                        'decoding' => 'async',
                        'sizes' => '100vw',
                    );
                    if ($is_first_slide) {
                        $hero_attrs['loading'] = 'eager';
                        $hero_attrs['fetchpriority'] = 'high';
                    } else {
                        $hero_attrs['loading'] = 'lazy';
                    }
                    $thumb_html = $thumb_id ? wp_get_attachment_image($thumb_id, 'large', false, $hero_attrs) : '';
                    if ($thumb_html) {
                        echo $thumb_html;
                    }
                    ?>
                <?php else : ?>
                    <img src="https://mate.tools/img/1920x800?bgcolor=444&fmt=png" class="d-block w-100 carousel-height object-fit-cover" alt="Slide" width="1920" height="800" loading="eager" fetchpriority="high" decoding="async">
                <?php endif; ?>
                
                <div class="carousel-caption d-flex flex-column h-100 align-items-center justify-content-center text-center text-white">
                    <h1 class="display-4 fw-bold mb-3"><?php the_title(); ?></h1>
                    <p class="lead mb-4 d-none d-md-block"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-lg px-4 py-2">
                        <i class="bi bi-eye me-2"></i> Lihat
                    </a>
                </div>
            </div>
            <?php $i++; endwhile; wp_reset_postdata(); else: ?>
                <div class="carousel-item active">
                    <img src="https://mate.tools/img/1920x800?bgcolor=333&textcolor=fff&text=Selamat+Datang+di+RentCorp&fmt=png" class="d-block w-100 carousel-height object-fit-cover" alt="Slide Default" width="1920" height="800" loading="eager" fetchpriority="high" decoding="async">
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

<div class="container py-5">
    <!-- Search Form -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="position-relative shadow-sm rounded-pill overflow-hidden border">
                <!-- Ikon Search -->
                <i class="bi bi-search text-primary position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                
                <!-- Input -->
                <input type="text" id="productSearch" 
                    class="form-control border-0 ps-5 pe-5 py-3 rounded-pill" 
                    placeholder="Cari Produk..." aria-label="Cari produk">
                
                <!-- Tombol Cari -->
                <button class="btn btn-primary px-4 position-absolute top-50 end-0 translate-middle-y me-3 rounded-pill" 
                        type="button" id="searchButton">
                Cari
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="searchLoading" class="text-center d-none my-5">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Mencari produk...</p>
    </div>

    <div class="row g-4 justify-content-center mb-5" id="productContainer">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="col-md-3 col-sm-6">
                <div class="card h-100 shadow-sm transition-hover rounded-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <?php
                        $thumb_id = get_post_thumbnail_id();
                        $thumb_html = $thumb_id ? wp_get_attachment_image($thumb_id, 'medium', false, ['class' => 'card-img-top rounded-top-4', 'style' => 'height: 200px; width: 100%; object-fit: cover;', 'sizes' => '(max-width: 576px) 100vw, (max-width: 992px) 50vw, 265px', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => esc_attr(get_the_title())]) : '';
                        if ($thumb_html) {
                            echo $thumb_html;
                        }
                        ?>
                    <?php else : ?>
                        <div class="aiti-placeholder card-img-top rounded-top-4" style="height: 200px;">
                            <?php echo get_aiti_initials(get_the_title()); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold"><?php the_title(); ?></h3>
                        <p class="card-text text-muted small">
                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                        </p>
                    </div>
                    <div class="card-footer text-center bg-transparent border-0">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                <i class="bi bi-link"></i> Baca
                            </a>
                            <?php 
                            $phone = get_option('company_phone');
                            $wa_phone = preg_replace('/[^0-9]/', '', $phone);
                            ?>
                            <a href="https://wa.me/<?php echo esc_attr($wa_phone); ?>?text=Info%20tentang%20<?php the_title(); ?>" class="btn btn-success btn-sm rounded-pill px-3">
                                <i class="bi bi-whatsapp"></i> Pesan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; else : ?>
            <div class="col-12 text-center py-5">
                <p class="lead text-muted">Belum ada produk untuk ditampilkan.</p>
                <a href="<?php echo home_url(); ?>" class="btn btn-primary rounded-pill px-4">Kembali ke Beranda</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        <div class="btn-group shadow-sm" role="group" aria-label="Product Pagination">
            <?php
            global $wp_query;
            $total_pages = $wp_query->max_num_pages;
            $current_page = max(1, get_query_var('paged'));

            if ($total_pages > 1) {
                for ($i = 1; $i <= $total_pages; $i++) {
                    $url = get_query_var('view_all') 
                        ? ($i == 1 ? home_url('/semua-produk/') : home_url("/semua-produk/page/$i/"))
                        : get_pagenum_link($i);
                    
                    $active_class = ($i == $current_page) ? 'btn-primary' : 'btn-outline-primary';
                    echo '<a href="' . esc_url($url) . '" class="btn ' . $active_class . ' px-3">' . $i . '</a>';
                }
            } else {
                // Always show button 1 even if only one page exists
                echo '<button type="button" class="btn btn-primary px-3" disabled>1</button>';
            }
            ?>
        </div>
    </div>
</div>

<style>
    .btn-group .btn {
        min-width: 45px;
    }
</style>

<?php
$float_phone = get_option('company_phone', '');
$float_digits = preg_replace('/[^0-9]/', '', (string) $float_phone);
if ($float_digits) {
    if (strpos($float_digits, '0') === 0) {
        $float_digits = '62' . substr($float_digits, 1);
    } elseif (strpos($float_digits, '62') !== 0) {
        $float_digits = '62' . $float_digits;
    }
    $float_message = 'Konsultasi tentang ' . get_bloginfo('name') . "\n" . 'Fast Response & Solutif!';
    $float_wa_url = 'https://wa.me/+' . $float_digits . '?text=' . rawurlencode($float_message);
?>
<a href="<?php echo esc_url($float_wa_url); ?>" class="btn btn-success rounded-pill shadow position-fixed d-inline-flex align-items-center gap-2" target="_blank" rel="noopener" style="right: 16px; bottom: 16px; z-index: 1050;">
    <i class="bi bi-whatsapp"></i>
    <span class="d-none d-sm-inline">Hubungi Kami</span>
</a>
<?php } ?>

<?php get_footer(); ?>
