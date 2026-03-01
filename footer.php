    </main>
    <!-- Footer -->
    <footer class="pt-5 pb-3">
        <div class="container">
            <div class="row g-4">                <!-- Kolom 1: Branding & Kontak -->
                <div class="col-md-4">
                    <h4 class="fw-bold mb-4 d-flex align-items-center">
                        <?php if (has_site_icon()) : ?>
                            <svg width="35" height="35" viewBox="0 0 192 192" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="96" cy="96" r="96" class="brand-logo-bg"></circle>
                                <text x="94" y="95" class="brand-logo-text" font-family="Arial, Helvetica, sans-serif" font-weight="900" font-size="90" letter-spacing="-15" text-anchor="middle" dominant-baseline="central">
                                    <?php echo esc_html(get_site_initials()); ?>
                                </text>
                            </svg>
                        <?php endif; ?>
                        <span class="ms-2"><?php echo esc_html(get_bloginfo('name')); ?></span>
                    </h4>

                    <?php if ($address = get_option('company_address')): ?>
                        <p class="mb-1"><strong><i class="bi bi-geo-alt"></i> Alamat</strong> <?php echo esc_html($address); ?></p>
                    <?php endif; ?>

                    <?php if ($phone = get_option('company_phone')): ?>
                        <p class="mb-1"><strong><i class="bi bi-telephone"></i> Telepon</strong> <?php echo esc_html($phone); ?></p>
                    <?php endif; ?>

                    <p class="mb-4"><strong><i class="bi bi-envelope"></i> E-mail</strong> <a href="mailto:<?php echo esc_attr(get_option('admin_email')); ?>" class="text-decoration-none"><?php echo esc_html(get_option('admin_email')); ?></a></p>
                    
                    <h5 class="fw-bold mb-3">Social Media</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <?php 
                        $social_platforms = [
                            'facebook'  => ['icon' => 'bi-facebook', 'btn' => 'btn-primary'],
                            'youtube'   => ['icon' => 'bi-youtube', 'btn' => 'btn-danger'],
                            'instagram' => ['icon' => 'bi-instagram', 'btn' => 'btn-warning'],
                            'tiktok'    => ['icon' => 'bi-tiktok', 'btn' => 'btn-dark'],
                        ];

                        foreach ($social_platforms as $key => $style) :
                            $link = get_option('company_' . $key);
                            if ($link) : ?>
                                <a href="<?php echo esc_url($link); ?>" class="btn <?php echo esc_attr($style['btn']); ?> btn-sm rounded-pill px-3 text-white" target="_blank" rel="noopener">
                                    <i class="bi <?php echo esc_attr($style['icon']); ?>"></i> <?php echo esc_html(ucfirst($key)); ?>
                                </a>
                            <?php endif;
                        endforeach;

                        if ($phone):
                            $country_code = get_option('company_country_code', '62');
                            $clean_phone = preg_replace('/[^0-9]/', '', $phone);
                            if (strpos($clean_phone, '0') === 0) {
                                $wa_number = $country_code . substr($clean_phone, 1);
                            } else {
                                $wa_number = $clean_phone;
                            }
                        ?>
                                <a href="https://wa.me/<?php echo esc_attr($wa_number); ?>" class="btn btn-success btn-sm rounded-pill px-3" target="_blank" rel="noopener">
                                    <i class="bi bi-whatsapp"></i> WhatsApp
                                </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Kolom 2: Kategori -->
                <div class="col-md-4">
                    <h4 class="fw-bold mb-4">Kategori</h4>
                    <div class="d-flex flex-wrap gap-2">
                        <?php
                        $categories = get_categories(array(
                            'orderby'    => 'id',
                            'order'      => 'DESC',
                            'number'     => 10,
                            'hide_empty' => false,
                        ));
                        if ($categories) :
                            foreach ($categories as $cat) : ?>
                                <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="tag-cloud-link btn btn-primary text-decoration-none px-3 py-1 rounded-pill small">
                                    <i class="bi bi-tag me-1"></i> <?php echo esc_html($cat->name); ?>
                                </a>
                            <?php endforeach;
                        else :
                            echo '<p class="text-muted small">No categories yet.</p>';
                        endif; ?>
                    </div>
                </div>

                <!-- Kolom 3: Halaman -->
                <div class="col-md-4">
                    <h4 class="fw-bold mb-4">Halaman</h4>
                    <ul class="list-unstyled footer-pages">
                        <?php
                        wp_list_pages(array(
                            'title_li' => '',
                            'link_before' => '• ',
                            'depth' => 1
                        ));
                        ?>
                    </ul>
                </div>
            </div>
            
            <hr class="mt-5 mb-4 border-secondary">
            <div class="text-center">
                <p class="mb-0 small">&copy; <?php echo '2010-'. date('Y'); ?>. <strong><?php bloginfo('name'); ?></strong>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>
    <script>
        // Initialize theme toggle icon
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            if (themeToggle) {
                themeToggle.innerHTML = currentTheme === 'light'
                    ? '<i class="bi bi-brightness-high"></i>'
                    : '<i class="bi bi-moon-stars"></i>';
            }
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (nav) {
                if (window.scrollY > 50) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }
            }
        });

        // Toggle Dark/Light Mode
        const themeToggle = document.getElementById('themeToggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const htmlEl = document.documentElement;
                const currentTheme = htmlEl.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                htmlEl.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                themeToggle.innerHTML = newTheme === 'light'
                    ? '<i class="bi bi-brightness-high"></i>'
                    : '<i class="bi bi-moon-stars"></i>';
            });
        }

        // AJAX Search Implementation
        const searchInput = document.getElementById('productSearch');
        const searchButton = document.getElementById('searchButton');
        const productContainer = document.getElementById('productContainer');
        const searchLoading = document.getElementById('searchLoading');

        if (searchButton && searchInput) {
            const performSearch = () => {
                const searchTerm = searchInput.value;
                if (!searchTerm.trim()) return;

                // Show loading, hide results
                productContainer.classList.add('opacity-0');
                searchLoading.classList.remove('d-none');

                const formData = new FormData();
                formData.append('action', 'aiti_search');
                formData.append('search', searchTerm);
                formData.append('nonce', aiti_ajax.nonce);

                fetch(aiti_ajax.ajax_url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    const cleaned = data
                        .replace(/\s(?:width|height)=["']?(?:0|1)["']?/gi, '')
                        .replace(/<img(?![^>]*style=)([^>]*class=["'][^"']*card-img-top[^"']*["'][^>]*)>/gi, '<img$1 style="height: 200px; object-fit: cover;">');
                    productContainer.innerHTML = cleaned;
                    searchLoading.classList.add('d-none');
                    productContainer.classList.remove('opacity-0');
                })
                .catch(error => {
                    console.error('Error:', error);
                    searchLoading.classList.add('d-none');
                    productContainer.classList.remove('opacity-0');
                });
            };

            searchButton.addEventListener('click', performSearch);
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') performSearch();
            });
        }
    </script>
</body>
</html>
