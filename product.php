<?php
/*
Template Name: Product Detail
Template Post Type: post, page
*/
get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!-- Parallax Header -->
    <?php 
    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
    ?>
    <header class="parallax-header mb-5 <?php echo !$thumb_url ? 'aiti-placeholder' : ''; ?>" 
            style="<?php echo $thumb_url ? "background-image: url('" . esc_url($thumb_url) . "');" : 'font-size: 5rem;'; ?>">
        <?php if (!$thumb_url) echo get_aiti_initials(get_the_title()); ?>
        <div class="parallax-overlay"></div>
        <div class="container parallax-content text-center">
            <h1 class="display-3 fw-bold"><?php the_title(); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>" class="text-white text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">Produk: <?php the_title(); ?></li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <article <?php post_class(); ?>>
                        <div class="entry-meta mb-4 text-muted border-bottom pb-3 d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-box-seam me-1"></i> Produk Unggulan</span>
                            <span><i class="bi bi-calendar3 me-1"></i> <?php echo get_the_date(); ?></span>
                        </div>

                        <div class="entry-content fs-5 lh-lg">
                            <?php the_content(); ?>
                        </div>
                        
                        <?php
                            $company_phone = get_option('company_phone', '');
                            $wa_digits = preg_replace('/[^0-9]/', '', (string) $company_phone);
                            if ($wa_digits) {
                                if (strpos($wa_digits, '0') === 0) {
                                    $wa_digits = '62' . substr($wa_digits, 1);
                                } elseif (strpos($wa_digits, '62') !== 0) {
                                    $wa_digits = '62' . $wa_digits;
                                }
                                $wa_message = 'Saya tertarik untuk menyewa produk: ' . get_the_title() . '' . "\n" . 'Mohon informasi ketersediaan dan harga terbaiknya. Terima kasih.';
                                $wa_url = 'https://wa.me/+' . $wa_digits . '?text=' . rawurlencode($wa_message);
                        ?>
                        <div class="mt-4 p-4 bg-light rounded-4 border border-success border-opacity-25 text-center">
                            <h4 class="fw-bold mb-3">Siap Untuk Memulai Proyek Anda?</h4>
                            <p class="text-muted mb-4">Dapatkan penawaran harga terbaik khusus untuk Anda hari ini.</p>
                            <a href="<?php echo esc_url($wa_url); ?>" class="btn btn-success btn-lg px-5 py-3 rounded-pill fw-bold shadow-sm" target="_blank" rel="noopener">
                                <i class="bi bi-whatsapp me-2"></i> Pesan Produk Ini Sekarang
                            </a>
                        </div>
                        <?php } ?>

                        <div class="entry-footer mt-5 pt-4 border-top">
                            <div class="d-flex flex-wrap gap-2">
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                    foreach ($tags as $tag) : ?>
                                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="badge text-bg-primary text-decoration-none px-3 py-2 rounded-pill">
                                            <i class="bi bi-tag"></i> <?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php endforeach;
                                else : ?>
                                    <span class="text-muted small italic">Kategori: Crane</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php
                        // Produk Terkait: hanya post yang memakai template product.php dan kategori yang sama.
                        $category_ids = wp_get_post_categories(get_the_ID());
                        if (!empty($category_ids)) :
                            $related_query = new WP_Query(array(
                                'post_type'           => 'post',
                                'posts_per_page'      => 8,
                                'post__not_in'        => array(get_the_ID()),
                                'category__in'        => $category_ids,
                                'ignore_sticky_posts' => true,
                                'meta_query'          => array(
                                    array(
                                        'key'   => '_wp_page_template',
                                        'value' => 'product.php'
                                    )
                                )
                            ));
                            if ($related_query->have_posts()) :
                        ?>
                        <!-- Produk Terkait -->
                        <div class="mt-4">
                            <h3 class="h5 fw-bold mb-3">Produk Terkait</h3>
                            <div class="related-scroll pb-2">
                                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                                <div class="related-item">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" class="card card-terkait rounded-4 shadow-sm text-decoration-none overflow-hidden h-100">
                                        <div class="card-terkait-media">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <?php
                                                $thumb_id = get_post_thumbnail_id();
                                                $thumb_html = $thumb_id ? wp_get_attachment_image($thumb_id, 'medium', false, array('class' => 'card-terkait-thumb', 'alt' => esc_attr(get_the_title()))) : '';
                                                if ($thumb_html) {
                                                    echo $thumb_html;
                                                } elseif ($thumb_id) {
                                                    $thumb_url = wp_get_attachment_url($thumb_id);
                                                    if ($thumb_url) {
                                                        echo '<img src="' . esc_url($thumb_url) . '" class="card-terkait-thumb" alt="' . esc_attr(get_the_title()) . '" loading="lazy" decoding="async">';
                                                    }
                                                }
                                                ?>
                                            <?php else : ?>
                                                <div class="aiti-placeholder card-terkait-thumb" style="font-size: 2rem;">
                                                    <?php echo get_aiti_initials(get_the_title()); ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body card-terkait-body">
                                            <h4 class="h6 fw-bold mb-1"><?php echo esc_html(get_the_title()); ?></h4>
                                            <p class="mb-0 small text-muted"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 10)); ?></p>
                                        </div>
                                    </a>
                                </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                        <?php
                            endif;
                            wp_reset_postdata();
                        endif;
                        ?>

                        <div class="mt-5 text-center">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline-dark px-4 py-2 rounded-pill">
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Katalog Produk
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        .btn-success {
            background: #25d366;
            border-color: #25d366;
        }
        .btn-success:hover {
            background: #128c7e;
            border-color: #128c7e;
        }
    </style>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
