<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function render_custom_foogallery_system() {
    if ( function_exists( 'foogallery_enqueue_core_gallery_template_script' ) ) {
        foogallery_enqueue_core_gallery_template_script();
    }

    if ( function_exists( 'foogallery_enqueue_core_gallery_template_style' ) ) {
        foogallery_enqueue_core_gallery_template_style();
    }

    $albums_query = new WP_Query(
        array(
            'post_type'      => array( 'foogallery_album', 'foogallery-album' ),
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'DESC',
        )
    );

    if ( ! $albums_query->have_posts() ) {
        return '<div class="cfg"><p class="cfg__empty">Brak opublikowanych albumów.</p></div>';
    }

    $requested_gallery_id = isset( $_GET['g_id'] ) ? absint( $_GET['g_id'] ) : 0;
    $all_galleries = array();
    $nav_structure = array();

    while ( $albums_query->have_posts() ) {
        $albums_query->the_post();
        $album_id = get_the_ID();
        $gallery_ids = get_post_meta( $album_id, 'foogallery_album_galleries', true );

        if ( empty( $gallery_ids ) ) {
            $gallery_ids = get_post_meta( $album_id, 'galleries', true );
        }

        if ( empty( $gallery_ids ) ) {
            $gallery_ids = get_post_meta( $album_id, '_foogallery_album_galleries', true );
        }

        if ( empty( $gallery_ids ) || ! is_array( $gallery_ids ) ) {
            continue;
        }

        $galleries = array();
        foreach ( $gallery_ids as $gallery_id ) {
            $gallery_id = absint( $gallery_id );
            $gallery = get_post( $gallery_id );

            if ( $gallery && 'foogallery' === $gallery->post_type && 'publish' === $gallery->post_status ) {
                $galleries[] = array(
                    'id'    => $gallery_id,
                    'title' => esc_html( $gallery->post_title ),
                );
                $all_galleries[] = $gallery_id;
            }
        }

        if ( $galleries ) {
            $nav_structure[] = array(
                'album_id'  => $album_id,
                'year'      => esc_html( get_the_title() ),
                'galleries' => $galleries,
            );
        }
    }

    wp_reset_postdata();

    if ( ! $nav_structure ) {
        return '<div class="cfg"><p class="cfg__empty">Brak dostępnych galerii.</p></div>';
    }

    $active_gallery_id = in_array( $requested_gallery_id, $all_galleries, true ) ? $requested_gallery_id : 0;
    $active_album_id = $nav_structure[0]['album_id'];

    if ( $active_gallery_id ) {
        foreach ( $nav_structure as $item ) {
            foreach ( $item['galleries'] as $gallery ) {
                if ( $gallery['id'] === $active_gallery_id ) {
                    $active_album_id = $item['album_id'];
                    break 2;
                }
            }
        }
    }

    ob_start();
    ?>
    <div class="cfg" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'cfg_load_gallery' ) ); ?>" data-initial-gallery="<?php echo esc_attr( $active_gallery_id ); ?>">
        <div class="cfg__years-wrapper">
            <button type="button" class="cfg__scroll-btn cfg__scroll-btn--prev" aria-label="Przewiń w lewo">&#10094;</button>
            <div class="cfg__years">
                <?php foreach ( $nav_structure as $item ) : ?>
                    <button type="button" class="cfg__year-btn gallery-button <?php echo $item['album_id'] === $active_album_id ? 'cfg__year-btn--active' : ''; ?>" data-target="cfg-album-<?php echo esc_attr( $item['album_id'] ); ?>"><?php echo $item['year']; ?></button>
                <?php endforeach; ?>
            </div>
            <button type="button" class="cfg__scroll-btn cfg__scroll-btn--next" aria-label="Przewiń w prawo">&#10095;</button>
        </div>
        <div class="cfg__container container">
            <div class="cfg__albums">
                <?php foreach ( $nav_structure as $item ) : ?>
                    <?php $has_expand = count( $item['galleries'] ) > 2; ?>
                    <div class="cfg__album-content <?php echo $item['album_id'] === $active_album_id ? 'cfg__album-content--active' : ''; ?> <?php echo $has_expand ? 'cfg__album-content--has-expand' : ''; ?>" id="cfg-album-<?php echo esc_attr( $item['album_id'] ); ?>">
                        <div class="cfg__album-buttons">
                            <?php foreach ( $item['galleries'] as $gallery ) : ?>
                                <button type="button" class="cfg__gallery-btn gallery-button <?php echo $gallery['id'] === $active_gallery_id ? 'cfg__gallery-btn--active' : ''; ?>" data-gallery-id="<?php echo esc_attr( $gallery['id'] ); ?>"><?php echo $gallery['title']; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <?php if ( $has_expand ) : ?>
                            <button type="button" class="cfg__album-expand" aria-expanded="false" aria-label="Rozwiń listę albumów"><span class="cfg__album-expand-icon" aria-hidden="true">&#9660;</span><span class="cfg__album-count"><?php echo count( $item['galleries'] ); ?></span></button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cfg__display" aria-live="polite">
                <p class="cfg__gallery-loading" hidden>Ładowanie galerii...</p>
                <p class="cfg__gallery-error" hidden></p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'custom_foogallery', 'render_custom_foogallery_system' );
