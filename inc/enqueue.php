<?php

function my_theme_enqueue_assets() {

    $css_path = get_template_directory() . '/dist/css/main.min.css';
    $js_path  = get_template_directory() . '/dist/js/main.min.js';

    wp_enqueue_style(
        'my-theme-styles',
        get_template_directory_uri() . '/dist/css/main.min.css',
        array(),
        file_exists($css_path) ? filemtime($css_path) : '1.0.0'
    );

    wp_enqueue_script(
        'my-theme-scripts',
        get_template_directory_uri() . '/dist/js/main.min.js',
        array(),
        file_exists($js_path) ? filemtime($js_path) : '1.0.0',
        true
    );

    wp_localize_script(
        'my-theme-scripts',
        'AlbumAjax',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('album_nonce')
        )
    );

}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_assets');

add_filter('script_loader_tag', 'add_module_to_my_script', 10, 3);
function add_module_to_my_script($tag, $handle, $src) {
    if ('my-theme-scripts' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}

function kliper_enqueue_hero_animation() {
    $js_path = get_template_directory() . '/assets/dist/js/main.min.js';
    $js_uri  = get_template_directory_uri() . '/assets/dist/js/main.min.js';

    wp_enqueue_script(
        'kliper-main',
        $js_uri,
        [],
        file_exists($js_path) ? filemtime($js_path) : '1.0.0',
        true
    );

    $slogans = [];
    for ($i = 1; $i <= 7; $i++) {
        $slogans[] = get_field('slogan_' . $i);
    }

    $icons = [
        get_template_directory_uri() . '/assets/images/icons/helm.png',
        get_template_directory_uri() . '/assets/images/icons/microphone.png',
        get_template_directory_uri() . '/assets/images/icons/note.png',
        get_template_directory_uri() . '/assets/images/icons/pirate.png',
        get_template_directory_uri() . '/assets/images/icons/gituar.png',
        get_template_directory_uri() . '/assets/images/icons/ship.png',
        get_template_directory_uri() . '/assets/images/icons/wave.png',
    ];

    wp_localize_script('kliper-main', 'HeroAnimationData', [
        'slogans' => array_values(array_filter($slogans)),
        'icons'   => $icons,
    ]);
}
add_action('wp_enqueue_scripts', 'kliper_enqueue_hero_animation');

