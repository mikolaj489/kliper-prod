<?php
function kliper_glightbox_content($html, $gallery) {
    // usuń istniejące linki owijające obrazki (WP często je dodaje)
    $html = preg_replace('/<a[^>]*>\s*(<img[^>]*>)\s*<\/a>/i', '$1', $html);

    return preg_replace_callback('/<img[^>]*>/i', function ($m) use ($gallery) {
        $img = $m[0];
        $src = '';

        // pełny rozmiar po ID z klasy wp-image-XX
        if (preg_match('/wp-image-(\d+)/', $img, $id)) {
            $src = wp_get_attachment_image_url((int) $id[1], 'full');
        }
        // awaryjnie zwykły src
        if (!$src && preg_match('/src="([^"]+)"/', $img, $s)) {
            $src = $s[1];
        }
        if (!$src) {
            return $img;
        }

        return '<a href="' . esc_url($src) . '" class="glightbox" data-gallery="' . esc_attr($gallery) . '">' . $img . '</a>';
    }, $html);
}?>