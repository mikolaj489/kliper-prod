<?php
// Theme setup
function custom_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');

    register_nav_menus([
        'main-menu' => 'Menu główne',
    ]);
}

add_action('after_setup_theme', 'custom_theme_setup');
