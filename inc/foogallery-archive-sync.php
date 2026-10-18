<?php
function custom_sync_archiwum_foogallery() {

    $gallery_id = 376;

    // Sprawdź, czy galeria istnieje.
    $gallery = get_post($gallery_id);

    if (!$gallery || $gallery->post_type !== 'foogallery') {
        return;
    }

    // Pobierz wszystkie wpisy archiwum.
    $events = get_posts([
        'post_type'      => 'archiwum',
        'post_status'    => ['publish', 'draft', 'private'],
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'ASC',
    ]);

    $found_ids = [];

    foreach ($events as $event_id) {

        $content = get_post_field('post_content', $event_id);

        if (empty($content)) {
            continue;
        }

        // Wykryj identyfikatory zdjęć, np. wp-image-123.
        if (preg_match_all(
            '/wp-image-(\d+)/',
            $content,
            $matches
        )) {
            foreach ($matches[1] as $attachment_id) {
                $found_ids[] = (int) $attachment_id;
            }
        }

        // Wykryj zdjęcia po adresach URL w znacznikach img.
        if (preg_match_all(
            '/<img\b[^>]*>/i',
            $content,
            $images
        )) {
            foreach ($images[0] as $image_html) {

                if (preg_match(
                    '/\bsrc\s*=\s*["\']([^"\']+)["\']/i',
                    $image_html,
                    $src
                )) {
                    $attachment_id = attachment_url_to_postid(
                        html_entity_decode($src[1])
                    );

                    if ($attachment_id) {
                        $found_ids[] = (int) $attachment_id;
                    }
                }
            }
        }
    }

    // Usuń duplikaty i nieprawidłowe identyfikatory.
    $found_ids = array_unique(array_filter($found_ids));

    $valid_ids = [];

    foreach ($found_ids as $attachment_id) {
        if (
            get_post_type($attachment_id) === 'attachment'
            && wp_attachment_is_image($attachment_id)
        ) {
            $valid_ids[] = (int) $attachment_id;
        }
    }

    // Pobierz dotychczasowe zdjęcia galerii.
    $existing_ids = get_post_meta(
        $gallery_id,
        'foogallery_attachments',
        true
    );

    if (!is_array($existing_ids)) {
        $existing_ids = [];
    }

    $existing_ids = array_map('intval', $existing_ids);

    // Połącz stare i nowe zdjęcia bez duplikatów.
    $all_ids = array_values(array_unique($valid_ids));

    // Zapisz aktualną listę zdjęć.
    if ($all_ids !== $existing_ids) {
        update_post_meta(
            $gallery_id,
            'foogallery_attachments',
            $all_ids
        );
    }
}
add_action('save_post_archiwum', function ($post_id, $post, $update) {

    if (
        wp_is_post_revision($post_id)
        || wp_is_post_autosave($post_id)
    ) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    custom_sync_archiwum_foogallery();

}, 20, 3);

// Jednorazowa synchronizacja istniejących wpisów po dodaniu kodu.
add_action('admin_init', function () {

    if (!current_user_can('manage_options')) {
        return;
    }

    if (get_option('custom_archiwum_foogallery_synced')) {
        return;
    }

    custom_sync_archiwum_foogallery();

    update_option('custom_archiwum_foogallery_synced', 1);

});

?>