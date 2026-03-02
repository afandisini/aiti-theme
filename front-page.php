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
                <?php $is_first_slide = (0 === $i); ?>
                <?php if (has_post_thumbnail()) : ?>
                    <?php
                    $thumb_id = get_post_thumbnail_id();
                    $hero_attrs = array(
                        'class' => 'd-block w-100 carousel-height object-fit-cover',
                        'alt' => esc_attr(get_the_title()),
                        'decoding' => 'async',
                        'sizes' => '(max-width: 767px) 100vw, (max-width: 1200px) 90vw, 676px',
                    );
                    if ($is_first_slide) {
                        $hero_attrs['loading'] = 'eager';
                        $hero_attrs['fetchpriority'] = 'high';
                        $hero_attrs['data-no-optimize'] = '1';
                        $hero_attrs['data-no-lazy'] = '1';
                        $hero_attrs['data-skip-lazy'] = '1';
                    } else {
                        $hero_attrs['loading'] = 'lazy';
                    }
                    $thumb_html = $thumb_id ? wp_get_attachment_image($thumb_id, 'medium_large', false, $hero_attrs) : '';
                    if ($thumb_html) {
                        echo $thumb_html;
                    }
                    ?>
                <?php else : ?>
                    <div class="d-block w-100 carousel-height object-fit-cover aiti-placeholder" style="font-size: 8rem;">
                        <?php echo get_aiti_initials(get_the_title()); ?>
                    </div>
                <?php endif; ?>
                
                <div class="carousel-caption d-flex flex-column h-100 align-items-center justify-content-center text-center text-white">
                    <?php if ($is_first_slide) : ?>
                        <h1 class="display-4 fw-bold mb-3"><?php the_title(); ?></h1>
                    <?php else : ?>
                        <h2 class="display-4 fw-bold mb-3"><?php the_title(); ?></h2>
                    <?php endif; ?>
                    <p class="lead mb-4 d-none d-md-block"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                    <a href="<?php the_permalink(); ?>" class="btn btn-primary rounded-pill">
                        <i class="bi bi-eye me-1"></i> Lihat
                    </a>
                </div>
            </div>
            <?php $i++; endwhile; wp_reset_postdata(); else: ?>
                <div class="carousel-item active">
                    <div class="d-block w-100 carousel-height object-fit-cover aiti-placeholder" style="font-size: 8rem;">
                        <?php echo get_aiti_initials(get_bloginfo('name')); ?>
                    </div>
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

    <!-- layanan Section -->
    <section id="features" class="container py-5">
        <h2 class="text-center mb-4">Mengapa Memilih <?php bloginfo('name'); ?>?</h2>
        <div class="row g-4 mt-5">

            <!-- Tepat Waktu -->
            <div class="col-md-3 col-sm-6">
            <div class="card h-100 text-center shadow-sm transition-hover rounded-4">
                <div class="card-body">
                <i class="bi bi-clock-history display-4 text-primary"></i>
                <h3 class="h5 mt-3">Tepat Waktu</h3>
                <p class="mb-0">Kami pastikan pengiriman crane sesuai jadwal proyek Anda.</p>
                </div>
            </div>
            </div>

            <!-- Tim Profesional -->
            <div class="col-md-3 col-sm-6">
            <div class="card h-100 text-center shadow-sm transition-hover rounded-4">
                <div class="card-body">
                <i class="bi bi-person-check display-4 text-success"></i>
                <h3 class="h5 mt-3">Tim Profesional</h3>
                <p class="mb-0">Operator berpengalaman siap mendukung kebutuhan konstruksi Anda.</p>
                </div>
            </div>
            </div>

            <!-- Harga Transparan -->
            <div class="col-md-3 col-sm-6">
            <div class="card h-100 text-center shadow-sm transition-hover rounded-4">
                <div class="card-body">
                <i class="bi bi-cash-stack display-4 text-warning"></i>
                <h3 class="h5 mt-3">Harga Transparan</h3>
                <p class="mb-0">Biaya sewa jelas dan tanpa biaya tersembunyi.</p>
                </div>
            </div>
            </div>

            <!-- Dukungan Teknis -->
            <div class="col-md-3 col-sm-6">
            <div class="card h-100 text-center shadow-sm transition-hover rounded-4">
                <div class="card-body">
                <i class="bi bi-tools display-4 text-danger"></i>
                <h3 class="h5 mt-3">Dukungan Teknis</h3>
                <p class="mb-0">Tim kami siap membantu jika ada kendala di lapangan.</p>
                </div>
            </div>
            </div>

        </div>
    </section>  
   <hr class="my-5 border-secondary">
    <!-- Produk Section -->
    <section class="py-5" id="offers">
        <div class="container">
            <h2 class="text-center fw-bold"><i class="bi bi-box-seam"></i> Produk <u>Crane</u> Kami</h2>
            <p class="text-center mb-5 text-muted fw-light h5">Penawaran Terbaik dari <strong><?php bloginfo('name'); ?></strong> untuk Kebutuhan Proyek Anda</p>
            
            <!-- Search Form -->
            <div class="row justify-content-center mb-5">
                <div class="col-md-6">
                    <div class="position-relative shadow-sm rounded-pill overflow-hidden border">
                        <i class="bi bi-search text-primary position-absolute top-50 start-0 translate-middle-y ms-3"></i>
                        <input type="text" id="productSearch" 
                            class="form-control border-0 ps-5 pe-5 py-3 rounded-pill" 
                            placeholder="Cari Produk..." aria-label="Cari produk">
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

            <div class="row g-3 justify-content-center py-5" id="productContainer">

                <?php
                // Query for Products (posts with product.php template)
                $product_args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 4,
                    'meta_query' => array(
                        array(
                            'key' => '_wp_page_template',
                            'value' => 'product.php'
                        )
                    )
                );
                $product_query = new WP_Query($product_args);

                if ($product_query->have_posts()) : while ($product_query->have_posts()) : $product_query->the_post(); ?>
                <!-- Card Produk -->
                <div class="col-md-3 col-sm-4">
                    <div class="card h-100 shadow-sm transition-hover rounded-4">
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-primary rounded-pill">Produk</span>
                        </div>
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
                            <h3 class="card-title h5 fw-bold text-truncate"><?php the_title(); ?></h3>
                            <p class="card-text text-muted small">
                                <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                            </p>
                        </div>
                        <div class="card-footer text-center bg-transparent border-0 pb-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                    Detail
                                </a>
                                <?php 
                                $phone = get_option('company_phone');
                                if ($phone) :
                                    $wa_number = preg_replace('/[^0-9]/', '', $phone);
                                    if (strpos($wa_number, '0') === 0) $wa_number = '62' . substr($wa_number, 1);
                                    $wa_text = rawurlencode('Halo ' . get_bloginfo('name') . ', saya ingin tanya tentang produk ' . get_the_title());
                                ?>
                                <a href="https://wa.me/<?php echo esc_attr($wa_number); ?>?text=<?php echo esc_attr($wa_text); ?>" class="btn btn-success btn-sm rounded-pill px-3">
                                    <i class="bi bi-whatsapp"></i> Pesan
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); else : ?>
                    <div class="col-12 text-center">
                        <p class="text-muted">Gunakan template "Product Detail" pada saat mengedit post agar muncul di sini.</p>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Lihat Semua Button -->
            <div class="text-center mt-3">
                <a href="<?php echo esc_url(home_url('/semua-produk/')); ?>" class="btn btn-link border rounded-4 text-decoration-none">
                    Lihat Semua Produk <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Artikel Section -->
    <?php
    // Query for Articles (posts WITHOUT product.php template)
    $article_args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => '_wp_page_template',
                'value' => 'product.php',
                'compare' => '!='
            ),
            array(
                'key' => '_wp_page_template',
                'compare' => 'NOT EXISTS'
            )
        )
    );
    $article_query = new WP_Query($article_args);

    if ($article_query->have_posts()) : ?>
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Artikel & Berita Terbaru</h2>
            <div class="row g-4 justify-content-center">
                <?php while ($article_query->have_posts()) : $article_query->the_post(); ?>
                <div class="col-md-3 col-sm-4">
                    <div class="card h-100 shadow-sm rounded-4">
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
                        <div class="card-body p-4">
                            <div class="mb-2 text-primary small fw-bold">
                                <i class="bi bi-calendar3 me-1"></i> <?php echo get_the_date(); ?>
                            </div>
                            <h3 class="card-title h5 fw-bold text-truncate"><?php the_title(); ?></h3>
                            <p class="card-text text-muted small">
                                <?php echo wp_trim_words(get_the_excerpt(), 12); ?>
                            </p>
                            <div class="d-flex justify-content-end">
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline-secondary btn-sm rounded-pill">Baca <i class="bi bi-arrow-right-short"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); endif; ?>

    <hr class="my-5 border-secondary">
        <div class="container py-4">
            <div class="row g-3 justify-content-center mb-5">
                <div class="col-md-6 text-center">
                    <?php
                        $privacy_post = get_post(54);
                        if ($privacy_post) :
                            echo apply_filters('the_content', $privacy_post->post_content);
                        else :
                            echo '<p class="text-center text-muted">FAQ tidak ditemukan.</p>';
                        endif;
                    ?>
                </div>
                <div class="col-md-6">
                    <h2 class="h3 mb-4 text-center">Lokasi Kami</h2>
                    <?php $address = get_option('company_address'); ?>
                    <div class="card shadow-sm rounded-4">
                        <div class="card-body p-0">
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden aiti-map-embed" data-map-src="https://maps.google.com/maps?q=<?php echo urlencode($address); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed">
                                <button type="button" class="btn btn-outline-primary border-0 rounded-4 aiti-map-load" data-map-load>
                                    Lihat Peta
                                </button>
                                <noscript>
                                    <iframe title="Lokasi kantor di Google Maps"
                                        src="https://maps.google.com/maps?q=<?php echo urlencode($address); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                                        style="border:0;" 
                                        allowfullscreen 
                                        loading="lazy"
                                        fetchpriority="low"
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </noscript>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
    document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-map-load]');
        if (!trigger) {
            return;
        }

        var wrapper = trigger.closest('.aiti-map-embed');
        if (!wrapper) {
            return;
        }

        var src = wrapper.getAttribute('data-map-src');
        if (!src) {
            return;
        }

        if (wrapper.getAttribute('data-loading') === '1') {
            return;
        }
        wrapper.setAttribute('data-loading', '1');
        wrapper.setAttribute('aria-busy', 'true');

        wrapper.innerHTML = '' +
            '<div class="aiti-map-skeleton" role="status" aria-live="polite">' +
                '<div class="spinner-border" role="status">' +
                    '<span class="visually-hidden">Loading...</span>' +
                '</div>' +
            '</div>';

        var iframe = document.createElement('iframe');
        iframe.setAttribute('title', 'Lokasi kantor di Google Maps');
        iframe.setAttribute('style', 'border:0; width:100%; height:100%; display:block; opacity:0; transition:opacity .25s ease;');
        iframe.setAttribute('loading', 'lazy');
        iframe.setAttribute('fetchpriority', 'low');
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
        wrapper.appendChild(iframe);

        var revealMap = function () {
            var skeleton = wrapper.querySelector('.aiti-map-skeleton');
            if (skeleton) {
                skeleton.remove();
            }
            iframe.style.opacity = '1';
            wrapper.removeAttribute('aria-busy');
            wrapper.removeAttribute('data-loading');
        };

        iframe.addEventListener('load', function () {
            revealMap();
        });

        iframe.setAttribute('src', src);
        window.setTimeout(revealMap, 5000);
    });
    </script>

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
    <a href="<?php echo esc_url($float_wa_url); ?>" class="btn btn-success rounded-pill shadow position-fixed d-inline-flex align-items-center gap-2 aiti-wa-float" target="_blank" rel="noopener" style="right: 16px; bottom: 16px; z-index: 1050;">
        <i class="bi bi-whatsapp"></i>
        <span class="d-none d-sm-inline">Hubungi Kami</span>
    </a>
    <?php } ?>

<?php get_footer(); ?>
