<?php

function my_theme_assets() {

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
