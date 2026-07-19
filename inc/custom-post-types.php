<?php
// Custom Post Types
function register_albumy_cpt() {
    register_post_type('album', [
        'labels' => [
            'name'         => 'Albumy',
            'add_new_item' => 'Dodaj nowy album',
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
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'aktualnosci'],
    ]);
}
add_action('init', 'register_aktualnosci_cpt');

function register_zespol_cpt() {
    // Sprawdzamy, czy użytkownik próbuje dodać nowy wpis przez URL i jeśli tak, to go blokujemy
    if ( isset($_GET['post_type']) && $_GET['post_type'] == 'zespol' && strpos($_SERVER['REQUEST_URI'], 'post-new.php') !== false ) {
        wp_die('Możesz edytować tylko istniejący wpis "O nas". Tworzenie nowych jest zablokowane.');
    }

    register_post_type('zespol', [
        'labels' => [
            'name'               => 'O Zespole',
            'edit_item'          => 'Edytuj informacje o zespole',
        ],
        'public'       => true,
        'show_in_menu' => true,
        'supports'     => ['title', 'editor', 'excerpt', 'thumbnail'], 
        'menu_icon'    => 'dashicons-groups', 
        'has_archive'  => false, 
        'rewrite'      => ['slug' => 'zespol'],
        'capabilities' => [
            'create_posts' => 'do_not_allow', 
        ],
        'map_meta_cap' => true,
    ]);
}
add_action('init', 'register_zespol_cpt');