<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function render_custom_foogallery_system() {
    $albums_query = new WP_Query([
        'post_type'      => array( 'foogallery_album', 'foogallery-album' ),
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'DESC',
    ]);

    if ( ! $albums_query->have_posts() ) {
        return '<div class="cfg"><p class="cfg__empty">Brak opublikowanych albumów.</p></div>';
    }

    $requested_gallery_id = isset( $_GET['g_id'] ) ? absint( $_GET['g_id'] ) : 0;
    
    $all_galleries = [];
    $nav_structure = [];

    while ( $albums_query->have_posts() ) {
        $albums_query->the_post();
        $album_id    = get_the_ID();
        $album_title = get_the_title();

        $gallery_ids = get_post_meta( $album_id, 'foogallery_album_galleries', true );
        if ( empty( $gallery_ids ) ) {
            $gallery_ids = get_post_meta( $album_id, 'galleries', true );
        }
        if ( empty( $gallery_ids ) ) {
            $gallery_ids = get_post_meta( $album_id, '_foogallery_album_galleries', true );
        }

        if ( ! empty( $gallery_ids ) && is_array( $gallery_ids ) ) {
            $galleries_in_album = [];

            foreach ( $gallery_ids as $g_id ) {
                $g_id = absint( $g_id );
                $g_post = get_post( $g_id );

                if ( $g_post && 'foogallery' === $g_post->post_type && 'publish' === $g_post->post_status ) {
                    $galleries_in_album[] = [
                        'id'    => $g_id,
                        'title' => esc_html( $g_post->post_title ),
                    ];
                    $all_galleries[] = $g_id;
                }
            }

            if ( ! empty( $galleries_in_album ) ) {
                $nav_structure[] = [
                    'album_id'  => $album_id,
                    'year'      => esc_html( $album_title ),
                    'galleries' => $galleries_in_album,
                ];
            }
        }
    }
    wp_reset_postdata();

    if ( empty( $nav_structure ) ) {
        return '<div class="cfg"><p class="cfg__empty">Brak dostępnych galerii.</p></div>';
    }

    $active_gallery_id = ( $requested_gallery_id > 0 && in_array( $requested_gallery_id, $all_galleries, true ) ) 
                          ? $requested_gallery_id 
                          : 0;

    ob_start();
    ?>
    <div class="cfg">
        <!-- PRZYCISKI LAT -->
        <div class="cfg__years">
            <?php foreach ( $nav_structure as $item ) : 
                $has_active = false;
                if ( $active_gallery_id > 0 ) {
                    foreach ( $item['galleries'] as $g ) {
                        if ( $g['id'] === $active_gallery_id ) {
                            $has_active = true;
                            break;
                        }
                    }
                }
            ?>
                <button type="button" 
                        class="cfg__year-btn <?php echo $has_active ? 'cfg__year-btn--active' : ''; ?>" 
                        data-target="cfg-album-<?php echo esc_attr( $item['album_id'] ); ?>">
                    <?php echo $item['year']; ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- ALBUMY W ROKU -->
        <div class="cfg__albums">
            <?php foreach ( $nav_structure as $item ) : 
                $has_active = false;
                if ( $active_gallery_id > 0 ) {
                    foreach ( $item['galleries'] as $g ) {
                        if ( $g['id'] === $active_gallery_id ) {
                            $has_active = true;
                            break;
                        }
                    }
                }
            ?>
                <div class="cfg__album-content <?php echo $has_active ? 'cfg__album-content--active' : ''; ?>" 
                     id="cfg-album-<?php echo esc_attr( $item['album_id'] ); ?>">
                    <div class="cfg__album-buttons">
                        <?php foreach ( $item['galleries'] as $g ) : ?>
                            <button type="button" 
                                    class="cfg__gallery-btn <?php echo ( $g['id'] === $active_gallery_id ) ? 'cfg__gallery-btn--active' : ''; ?>" 
                                    data-gallery-id="<?php echo esc_attr( $g['id'] ); ?>">
                                <?php echo $g['title']; ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- ZDJĘCIA FOOGALLERY -->
        <div class="cfg__display">
            <?php foreach ( $all_galleries as $g_id ) : ?>
                <div class="cfg__gallery-item <?php echo ( $g_id === $active_gallery_id ) ? 'cfg__gallery-item--active' : ''; ?>" 
                     id="cfg-gallery-item-<?php echo esc_attr( $g_id ); ?>">
                    <?php echo do_shortcode( '[foogallery id="' . $g_id . '"]' ); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'custom_foogallery', 'render_custom_foogallery_system' );