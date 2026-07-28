<?php
// Theme setup
function custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

   register_nav_menus([
        'main-menu' => __('Menu Główne', 'kliper'),
    ]);
}

function add_menu_link_class($atts, $item, $args) {
    if (isset($args->items_class)) {
        $atts['class'] = isset($atts['class']) 
            ? $atts['class'] . ' ' . $args->items_class 
            : $args->items_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 10, 3);

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

