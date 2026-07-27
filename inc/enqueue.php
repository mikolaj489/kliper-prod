<?php

function my_theme_enqueue_assets() {

    $css_path = get_template_directory() . '/dist/css/main.min.css';
    $js_path  = get_template_directory() . '/dist/js/main.min.js';

    // 1. Rejestracja skompresowanego CSS z Vite
    wp_enqueue_style(
        'my-theme-styles',
        get_template_directory_uri() . '/dist/css/main.min.css',
        array(),
        file_exists($css_path) ? filemtime($css_path) : '1.0.0'
    );

    // 2. Rejestracja skompresowanego JS z Vite
    wp_enqueue_script(
        'my-theme-scripts',
        get_template_directory_uri() . '/dist/js/main.min.js',
        array(),
        file_exists($js_path) ? filemtime($js_path) : '1.0.0',
        true // ładowanie w footerze
    );

    // 3. Przekazanie danych AJAX do skryptu pod nazwą obiektu AlbumAjax
    wp_localize_script(
        'my-theme-scripts', // Musi być dokładnie taka sama nazwa jak w wp_enqueue_script
        'AlbumAjax',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('album_nonce')
        )
    );

}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_assets');

// Dodanie type="module" dla skryptu Vite
add_filter('script_loader_tag', 'add_module_to_my_script', 10, 3);
function add_module_to_my_script($tag, $handle, $src) {
    if ('my-theme-scripts' === $handle) {
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    }
    return $tag;
}
