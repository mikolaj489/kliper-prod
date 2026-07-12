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
        'supports'     => ['title'],
        'menu_icon'    => 'dashicons-album',
    ]);
}
add_action('init', 'register_album_cpt');

function register_aktualnosci_cpt() {
    register_post_type('aktualnosci', [
        'labels' => [
            'name' => 'Aktualności',
            'add_new_item' => 'Dodaj nową aktualność',
        ],
        'public'       => true,
        'show_in_menu' => true,
        'supports'     => ['title', 'editor', 'excerpt'],
        'menu_icon'    => 'dashicons-megaphone',
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'aktualnosci'],

    ]);
}
add_action('init', 'register_aktualnosci_cpt');