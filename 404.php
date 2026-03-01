<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package aiti-solutions
 */

get_header();
?>

<section class="py-5 min-vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <p class="text-uppercase text-muted fw-semibold mb-2">Error 404</p>
                <h1 class="display-3 fw-bold mb-3">Halaman Tidak Ditemukan</h1>
                <p class="lead text-muted mb-4">
                    Maaf, halaman yang Anda cari tidak tersedia atau sudah dipindahkan.
                </p>

                <div class="d-flex justify-content-center gap-2 flex-wrap mb-4">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary rounded-pill px-4">
                        Kembali ke Beranda
                    </a>
                    <a href="<?php echo esc_url(home_url('/semua-produk/')); ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        Lihat Semua Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
