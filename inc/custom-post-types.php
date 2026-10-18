<?php
function register_albumy_cpt() {
    register_post_type('album', [
        'labels' => [
            'name'         => 'Wydania',
            'add_new_item' => 'Dodaj nowe wydanie',
        ],
        'public'       => true,
        'show_in_menu' => true,
        'has_archive'  => false, 
        'rewrite'      => ['slug' => 'albumy'],
        'supports'     => ['title'],
        'menu_icon'    => 'dashicons-album',
    ]);
    
}
add_action('init', 'register_albumy_cpt');

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
        'has_archive'  => false,
        'rewrite'      => ['slug' => 'wpis-aktualnosci'],
    ]);
}
add_action('init', 'register_aktualnosci_cpt');

function register_archiwum_cpt() {
    // 1. Rejestracja Taksonomii (Lata)
    register_taxonomy('rok_archiwum', ['archiwum'], [
        'labels' => [
            'name'          => 'Lata',
            'singular_name' => 'Rok',
            'add_new_item'  => 'Dodaj nowy rok',
        ],
        'public'            => true,
        'hierarchical'      => true, // zachowuje się jak kategorie
        'show_admin_column' => true,
        'show_in_rest'      => true,
    ]);

    // 2. Rejestracja CPT
    register_post_type('archiwum', [
        'labels' => [
            'name'          => 'Archiwum',
            'singular_name' => 'Wydarzenie',
            'add_new_item'  => 'Dodaj nowe wydarzenie',
        ],
        'public'       => true,
        'show_in_menu' => true,
        'supports'     => ['title', 'editor'],
        'menu_icon'    => 'dashicons-archive',
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'archiwum'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'register_archiwum_cpt');

function register_stopka_cpt() {
    register_post_type('stopka', [
        'labels' => [
            'name' => 'Stopka',
        ],
        'capabilities' => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => true,
        'public'       => true,
        'show_in_menu' => true,
        'supports'     => ['title'],
        'menu_icon'    => 'dashicons-layout',
    ]);
}
add_action('init', 'register_stopka_cpt');