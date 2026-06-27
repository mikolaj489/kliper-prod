<?php
// AJAX handler
add_action('wp_ajax_get_album_detail', 'ajax_get_album_detail');
add_action('wp_ajax_nopriv_get_album_detail', 'ajax_get_album_detail');

function ajax_get_album_detail() {
    check_ajax_referer('album_nonce', 'nonce');

    $album_id = intval($_POST['album_id']);
    if (!$album_id) {
        wp_die('Invalid ID');
    }

    $album = get_post($album_id);
    if (!$album || $album->post_type !== 'album') {
        wp_die('Not found');
    }

    ob_start();
    get_template_part('template-parts/components/album_card_expanded', null, [
        'album_id' => $album_id,
    ]);
    $html = ob_get_clean();

    wp_send_json_success(['html' => $html]);
}