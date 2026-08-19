<?php
// function register_galeria_cpt() {

//     register_post_type('galeria', [

//         'labels' => [
//             'name'               => 'Albumy zdjęć',
//             'add_new_item'       => 'Dodaj nowy album zdjęć',
//         ],

//         'public'       => true,
//         'show_in_menu' => true,

//         'has_archive'  => false,

//         'rewrite' => [
//             'slug' => 'galeria-zdjec',
//         ],

//         'supports' => [
//             'title',
//         ],

//         'menu_icon' => 'dashicons-format-gallery',
//     ]);

// }

// add_action('init', 'register_galeria_cpt');

// function register_galeria_rok_taxonomy() {

//     register_taxonomy(
//         'rok_galerii',
//         ['galeria'],
//         [

//             'labels' => [
//                 'name'              => 'Lata',
//                 'singular_name'     => 'Rok',
//                 'search_items'      => 'Szukaj lat',
//                 'all_items'         => 'Wszystkie lata',
//                 'edit_item'         => 'Edytuj rok',
//                 'update_item'       => 'Aktualizuj rok',
//                 'add_new_item'      => 'Dodaj nowy rok',
//                 'new_item_name'     => 'Nazwa nowego roku',
//                 'menu_name'         => 'Lata',
//             ],

//             // true = hierarchiczna taksonomia, podobna do kategorii
//             'hierarchical' => true,

//             'public'       => true,
//             'show_ui'      => true,

//             // Pokazuje rok w tabeli galerii w panelu WP
//             'show_admin_column' => true,

//             'show_in_rest' => true,

//             'rewrite' => [
//                 'slug' => 'rok-galerii',
//             ],
//         ]
//     );

// }

// add_action('init', 'register_galeria_rok_taxonomy');


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