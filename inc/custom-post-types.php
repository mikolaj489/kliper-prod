<?php
// Custom Post Types
function register_album_cpt() {
    register_post_type('album', [
        'labels' => [
            'name'         => 'Albumy',
            'add_new_item' => 'Dodaj nowy album',
        ],
        'public'       => true,
        'show_in_menu' => true,
        'supports'     => ['title', 'thumbnail'],
        'menu_icon'    => 'dashicons-album',
    ]);
}

add_action('init', 'register_album_cpt');
