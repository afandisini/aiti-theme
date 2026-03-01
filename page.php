<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <!-- Parallax Header -->
    <?php 
    $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'full'); 
    if (!$thumb_url) {
        $thumb_url = 'https://mate.tools/img/1920x800?bgcolor=333&textcolor=fff&text='.get_the_title().'&fmt=png';
    }
    ?>
    <header class="parallax-header mb-5" style="background-image: url('<?php echo esc_url($thumb_url); ?>');">
        <div class="container text-center pt-5">
            <h1 class="display-4 fw-bold"><?php the_title(); ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>" class="px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-4 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><span class="px-2 py-1 fw-semibold text-success-emphasis bg-success-subtle border border-success-subtle rounded-4 text-decoration-none"><?php the_title(); ?></span></li>
                </ol>
            </nav>
        </div>
    </header>

    <section class="pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9 col-lg-8">
                    <article <?php post_class(); ?>>
                        <div class="entry-content fs-5 lh-lg text-dark-emphasis">
                            <?php the_content(); ?>
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
