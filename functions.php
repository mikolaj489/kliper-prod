<?php
function enqueue_google_fonts() {
    wp_enqueue_style(
        'bricolage-grotesque',
        'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,700&display=swap',
        [],
        null
    );
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');
function my_theme_assets() {
  add_image_size('album_cover', 600, 600, true);
  wp_enqueue_style(
      'theme-style',
      get_stylesheet_uri(),
      [],
      filemtime(get_template_directory() . '/style.css')
  );
  wp_enqueue_style(
    'main-style',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    filemtime(get_template_directory() . '/assets/css/main.css')
  );

  wp_enqueue_script(
    'main-js',
    get_template_directory_uri() . '/assets/js/main.js',
    [],
    filemtime(get_template_directory() . '/assets/js/main.js'),
    true
  );

}
add_action('wp_enqueue_scripts', 'my_theme_assets');

add_theme_support('title-tag');
add_theme_support('post-thumbnails');

register_nav_menus([
  'main-menu' => 'Menu główne',
]);

function register_album_cpt() {
    register_post_type('album', [
        'labels' => [
            'name'          => 'Albumy',
            'add_new_item'  => 'Dodaj nowy album',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'supports'      => ['title', 'thumbnail'],
        'menu_icon'     => 'dashicons-album',
    ]);
}
add_action('init', 'register_album_cpt');