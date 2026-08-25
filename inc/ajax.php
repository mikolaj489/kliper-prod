<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function cfg_load_gallery_ajax() {
    check_ajax_referer( 'cfg_load_gallery', 'nonce' );

    $gallery_id = isset( $_POST['gallery_id'] ) ? absint( $_POST['gallery_id'] ) : 0;
    $gallery = get_post( $gallery_id );

    if ( ! $gallery_id ) {
        wp_send_json_error( array( 'message' => 'Brak ID galerii.' ), 400 );
    }

    if ( ! $gallery || 'foogallery' !== $gallery->post_type || 'publish' !== $gallery->post_status ) {
        wp_send_json_error( array( 'message' => 'Galeria nie istnieje lub nie jest opublikowana.' ), 404 );
    }

    $html = do_shortcode( '[foogallery id="' . $gallery_id . '"]' );

    if ( ! trim( $html ) ) {
        wp_send_json_error( array( 'message' => 'Galeria zwróciła pustą zawartość.' ), 500 );
    }

    wp_send_json_success( array( 'gallery_id' => $gallery_id, 'html' => $html ) );
}

add_action( 'wp_ajax_cfg_load_gallery', 'cfg_load_gallery_ajax' );
add_action( 'wp_ajax_nopriv_cfg_load_gallery', 'cfg_load_gallery_ajax' );

function ajax_get_album_detail() {
    check_ajax_referer( 'album_nonce', 'nonce' );

    $album_id = isset( $_POST['album_id'] ) ? absint( $_POST['album_id'] ) : 0;
    $album = get_post( $album_id );

    if ( ! $album_id || ! $album || 'album' !== $album->post_type ) {
        wp_send_json_error( array( 'message' => 'Album nie został znaleziony.' ), 404 );
    }

    ob_start();
    get_template_part( 'template-parts/components/album_card_expanded', null, array( 'album_id' => $album_id ) );
    wp_send_json_success( array( 'html' => ob_get_clean() ) );
}

add_action( 'wp_ajax_get_album_detail', 'ajax_get_album_detail' );
add_action( 'wp_ajax_nopriv_get_album_detail', 'ajax_get_album_detail' );
