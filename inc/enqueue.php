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
    $is_front_page = is_page_template('front-page.php');
    $is_news_archive = is_post_type_archive('aktualnosci') || is_tax() || is_archive();

    // front-page
    if ($is_front_page) {
        // styles
        wp_enqueue_style('album-card', get_template_directory_uri() . '/assets/css/components/album_card.css', [], filemtime(get_template_directory() . '/assets/css/components/album_card.css'));
        wp_enqueue_style('album-card-expanded', get_template_directory_uri() . '/assets/css/components/album_card_expanded.css', [], filemtime(get_template_directory() . '/assets/css/components/album_card_expanded.css'));
        wp_enqueue_style('kliper-welcome', get_template_directory_uri() . '/assets/css/components/welcome.css', [], filemtime(get_template_directory() . '/assets/css/components/welcome.css'));
        wp_enqueue_style('kliper-releases', get_template_directory_uri() . '/assets/css/section-styles/releases.css', [], filemtime(get_template_directory() . '/assets/css/section-styles/releases.css'));
        wp_enqueue_style('hero-animation', get_template_directory_uri() . '/assets/css/components/hero_animation.css', [], filemtime(get_template_directory() . '/assets/css/components/hero_animation.css'));
        wp_enqueue_style('kliper-hero', get_template_directory_uri() . '/assets/css/section-styles/hero.css', [], filemtime(get_template_directory() . '/assets/css/section-styles/hero.css'));
        wp_enqueue_style('kliper-news', get_template_directory_uri() . '/assets/css/section-styles/news.css', [], filemtime(get_template_directory() . '/assets/css/section-styles/news.css'));
        wp_enqueue_style('news-card', get_template_directory_uri() . '/assets/css/components/news_card.css', [], filemtime(get_template_directory() . '/assets/css/components/news_card.css'));
        wp_enqueue_style('news-slider', get_template_directory_uri() . '/assets/css/components/news_slider.css', [], filemtime(get_template_directory() . '/assets/css/components/news_slider.css'));
        wp_enqueue_style('kliper-about', get_template_directory_uri() . '/assets/css/section-styles/about.css', [], filemtime(get_template_directory() . '/assets/css/section-styles/about.css'));
        //scripts   
        wp_enqueue_script('kliper-album', get_template_directory_uri() . '/assets/js/modules/album.js', [], filemtime(get_template_directory() . '/assets/js/modules/album.js'), true);
        wp_enqueue_script('kliper-releases', get_template_directory_uri() . '/assets/js/modules/releases.js', [], filemtime(get_template_directory() . '/assets/js/modules/releases.js'), true);
        wp_enqueue_script('hero-animation', get_template_directory_uri() . '/assets/js/modules/hero_animation.js', [], filemtime(get_template_directory() . '/assets/js/modules/hero_animation.js'), true);
        wp_enqueue_script('news-slider', get_template_directory_uri() . '/assets/js/modules/news_slider.js', [], filemtime(get_template_directory() . '/assets/js/modules/news_slider.js'), true);
        wp_enqueue_script('about-image', get_template_directory_uri() . '/assets/js/modules/about_image.js', [], filemtime(get_template_directory() . '/assets/js/modules/about_image.js'), true);
    }

    if ($is_news_archive || $is_front_page) {
        wp_enqueue_style('kliper-news', get_template_directory_uri() . '/assets/css/section-styles/news.css', [], filemtime(get_template_directory() . '/assets/css/section-styles/news.css'));
        wp_enqueue_style('news-card', get_template_directory_uri() . '/assets/css/components/news_card.css', [], filemtime(get_template_directory() . '/assets/css/components/news_card.css'));
    }

    // AJAX data
    wp_localize_script('main-js', 'AlbumAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('album_nonce'),
    ]);
}

add_action('wp_enqueue_scripts', 'enqueue_google_fonts');
add_action('wp_enqueue_scripts', 'my_theme_assets');
