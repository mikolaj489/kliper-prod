<?php
// Theme setup
function custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

   register_nav_menus([
        'main-menu' => __('Menu Główne', 'kliper'),
    ]);
}
add_action('after_setup_theme', 'custom_theme_setup');

add_action('admin_init', function() {
    remove_post_type_support('page', 'editor');
});

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Ustawienia Stopki',
        'menu_title'    => 'Stopka',
        'menu_slug'     => 'footer-settings',
        'capability'    => 'edit_posts',
        'icon_url'      => 'dashicons-layout',
        'redirect'      => false
    ));
}

