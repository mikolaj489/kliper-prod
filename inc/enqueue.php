<?php
// Enqueue styles and scripts
function enqueue_google_fonts() {
    wp_enqueue_style('bricolage-grotesque', 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,300;12..96,400;12..96,700&display=swap', [], null);
}

function my_theme_assets() {
    // global
    wp_enqueue_style('theme-style', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', [], filemtime(get_template_directory() . '/assets/css/main.css'));

    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', [], filemtime(get_template_directory() . '/assets/js/main.js'), true);
    // front-page
    if (is_page_template('front-page.php')) {
        add_image_size('album_cover', 600, 600, true);

        wp_enqueue_style('album-card', get_template_directory_uri() . '/assets/css/components/album_card.css', [], filemtime(get_template_directory() . '/assets/css/components/album_card.css'));
        wp_enqueue_style('album-card-expanded', get_template_directory_uri() . '/assets/css/components/album_card_expanded.css', [], filemtime(get_template_directory() . '/assets/css/components/album_card_expanded.css'));
        wp_enqueue_style('welcome', get_template_directory_uri() . '/assets/css/components/welcome.css', [], filemtime(get_template_directory() . '/assets/css/components/welcome.css'));
        wp_enqueue_style('releases', get_template_directory_uri() . '/assets/css/components/releases.css', [], filemtime(get_template_directory() . '/assets/css/components/releases.css'));
        wp_enqueue_style('hero-animation', get_template_directory_uri() . '/assets/css/components/hero_animation.css', [], filemtime(get_template_directory() . '/assets/css/components/hero_animation.css'));
        wp_enqueue_style('hero', get_template_directory_uri() . '/assets/css/components/hero.css', [], filemtime(get_template_directory() . '/assets/css/components/hero.css'));
        wp_enqueue_style('news', get_template_directory_uri() . '/assets/css/components/news.css', [], filemtime(get_template_directory() . '/assets/css/components/news.css'));

        wp_enqueue_script('album', get_template_directory_uri() . '/assets/js/modules/album.js', [], filemtime(get_template_directory() . '/assets/js/modules/album.js'), true);
        wp_enqueue_script('releases', get_template_directory_uri() . '/assets/js/modules/releases.js', [], filemtime(get_template_directory() . '/assets/js/modules/releases.js'), true);
        wp_enqueue_script('hero-animation', get_template_directory_uri() . '/assets/js/modules/hero_animation.js', [], filemtime(get_template_directory() . '/assets/js/modules/hero_animation.js'), true);
    }

    // AJAX data
    wp_localize_script('main-js', 'AlbumAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('album_nonce'),
    ]);
}

add_action('wp_enqueue_scripts', 'enqueue_google_fonts');
add_action('wp_enqueue_scripts', 'my_theme_assets');
