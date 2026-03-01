<?php get_header(); ?>

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
                    <li class="breadcrumb-item active text-white-50" aria-current="page"><?php the_title(); ?></li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <article <?php post_class(); ?>>
                        <div class="entry-meta mb-4 text-muted border-bottom pb-3 d-flex justify-content-between">
                            <span><i class="bi bi-calendar3 me-1"></i> <?php echo get_the_date(); ?></span>
                            <span><i class="bi bi-person me-1"></i> <?php the_author(); ?></span>
                        </div>

                        <div class="entry-content fs-5 lh-lg">
                            <?php the_content(); ?>
                        </div>

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
                                    <span class="text-muted small italic">No tags</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Artikel Terkait -->
                        <?php
                        $category_ids = wp_get_post_categories(get_the_ID());
                        if (!empty($category_ids)) :
                            $related_query = new WP_Query(array(
                                'post_type'           => 'post',
                                'posts_per_page'      => 8,
                                'post__not_in'        => array(get_the_ID()),
                                'category__in'        => $category_ids,
                                'ignore_sticky_posts' => true,
                                'meta_query'          => array(
                                    'relation' => 'OR',
                                    array(
                                        'key'     => '_wp_page_template',
                                        'value'   => 'product.php',
                                        'compare' => '!='
                                    ),
                                    array(
                                        'key'     => '_wp_page_template',
                                        'compare' => 'NOT EXISTS'
                                    )
                                )
                            ));
                            if ($related_query->have_posts()) :
                        ?>
                        <div class="mt-4">
                            <h3 class="h5 fw-bold mb-3">Artikel Terkait</h3>
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
                                <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
    <?php
    $float_phone = get_option('company_phone', '');
    $float_digits = preg_replace('/[^0-9]/', '', (string) $float_phone);
    if ($float_digits) {
        if (strpos($float_digits, '0') === 0) {
            $float_digits = '62' . substr($float_digits, 1);
        } elseif (strpos($float_digits, '62') !== 0) {
            $float_digits = '62' . $float_digits;
        }
        $float_message = 'Konsultasi tentang ' . get_the_title() . "\n" . 'Fast Response & Solutif!';
        $float_wa_url = 'https://wa.me/+' . $float_digits . '?text=' . rawurlencode($float_message);
    ?>
    <a href="<?php echo esc_url($float_wa_url); ?>" class="btn btn-success rounded-pill shadow position-fixed d-inline-flex align-items-center gap-2" target="_blank" rel="noopener" style="right: 16px; bottom: 16px; z-index: 1050;">
        <i class="bi bi-whatsapp"></i>
        <span class="d-none d-sm-inline">Hubungi Kami</span>
    </a>
    <?php } ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>
