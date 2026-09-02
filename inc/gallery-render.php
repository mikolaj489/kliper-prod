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
            // Pobieramy pole ACF 'opis_albumu' z edytowanego albumu FooGallery
            $acf_description = get_field( 'opis_albumu', $album_id );

            // Jeśli pole ACF jest puste, jako fallback bierzemy standardową treść posta
            if ( empty( $acf_description ) ) {
                $acf_description = get_post_field( 'post_content', $album_id );
            }

            $nav_structure[] = array(
                'album_id'    => $album_id,
                'year'        => esc_html( get_the_title() ),
                'description' => wp_kses_post( apply_filters( 'the_content', $acf_description ) ),
                'galleries'   => $galleries,
            );
        }
    }

    wp_reset_postdata();

    if ( ! $nav_structure ) {
        return '<div class="cfg"><p class="cfg__empty">Brak dostępnych galerii.</p></div>';
    }

    $active_gallery_id = in_array( $requested_gallery_id, $all_galleries, true ) ? $requested_gallery_id : 0;
    $active_album_id = 0;

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
    <div class="cfg" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'cfg_load_gallery' ) ); ?>" data-initial-gallery="<?php echo $active_gallery_id ? esc_attr( $active_gallery_id ) : ''; ?>">
        <div class="arrow-line container">
            <div class="arrow-line-small container">
              <svg class="arrow-line-small__flexible-segment" viewBox="0 0 100 2" preserveAspectRatio="none">
                <rect width="100" height="2" fill="#B58B4C" />
              </svg>
              <svg class="arrow-line-small__static-right" viewBox="277 0 60 48">
                <path d="M277.004 46.8222L277 47.8222L277.016 47.8222L277.031 47.8218L277.004 46.8222ZM277.94 46.7966L277.912 45.797L277.912 45.797L277.94 46.7966ZM328.437 0.292907C328.046 -0.0976167 327.413 -0.0976165 327.022 0.292908L320.659 6.65687C320.268 7.0474 320.268 7.68056 320.659 8.07109C321.049 8.46161 321.682 8.46161 322.073 8.07108L327.73 2.41423L333.386 8.07108C333.777 8.4616 334.41 8.4616 334.801 8.07108C335.191 7.68056 335.191 7.04739 334.801 6.65687L328.437 0.292907ZM277.004 46.8222L277.031 47.8218L277.967 47.7962L277.94 46.7966L277.912 45.797L276.977 45.8225L277.004 46.8222ZM277.94 46.7966L277.967 47.7962C286.901 47.5523 294.549 47.3448 300.961 46.4682C307.377 45.5911 312.67 44.0314 316.849 41.0056C325.262 34.9139 328.73 23.217 328.73 1.00001L327.73 1.00001L326.73 1.00001C326.73 23.2202 323.206 33.9328 315.676 39.3857C311.883 42.1321 306.967 43.6285 300.69 44.4866C294.409 45.3453 286.882 45.5521 277.912 45.797L277.94 46.7966Z" fill="#B58B4C"/>
              </svg>
            </div>
          <svg class="arrow-line__static-left" viewBox="0 0 419 53">
            <path d="M316.5 51.8639L316.5 52.8639L316.588 52.8639L316.674 52.8487L316.5 51.8639ZM419 7.36395L419 8.36395L419 7.36395ZM158.25 51.8639L158.25 52.8639V52.8639L158.25 51.8639ZM316.5 51.8639L316.674 52.8487C328.765 50.7119 336.696 46.8152 342.933 42.1497C349.103 37.5349 353.663 32.1073 358.796 27.1684C363.967 22.1935 369.891 17.5152 379.047 14.0656C388.222 10.6088 400.702 8.36395 419 8.36395L419 7.36395L419 6.36395C400.548 6.36395 387.812 8.62621 378.342 12.194C368.854 15.7689 362.705 20.6324 357.41 25.7272C352.077 30.8579 347.779 36.0276 341.735 40.5481C335.76 45.0179 328.122 48.7944 316.326 50.8792L316.5 51.8639ZM6.73196e-09 51.8639L-3.02229e-08 52.8639L158.25 52.8639L158.25 51.8639L158.25 50.8639L4.37159e-08 50.8639L6.73196e-09 51.8639ZM158.25 51.8639L158.25 52.8639L316.5 52.8639L316.5 51.8639L316.5 50.8639L158.25 50.8639L158.25 51.8639Z" fill="#B58B4C"/>
          </svg>
    
          <svg class="arrow-line__flexible-segment" viewBox="0 0 100 2" preserveAspectRatio="none">
            <rect width="100" height="2" fill="#B58B4C" />
          </svg>
        
          <svg class="arrow-line__static-arrow" viewBox="1310 0 10 15">
            <path d="M1319.71 8.07106C1320.1 7.68053 1320.1 7.04737 1319.71 6.65685L1313.34 0.292883C1312.95 -0.0976408 1312.32 -0.0976409 1311.93 0.292883C1311.54 0.683408 1311.54 1.31657 1311.93 1.7071L1317.59 7.36395L1311.93 13.0208C1311.54 13.4113 1311.54 14.0445 1311.93 14.435C1312.32 14.8255 1312.95 14.8255 1313.34 14.435L1319.71 8.07106Z" fill="#B58B4C"/>
          </svg>
        </div>
        <div class="cfg__years-wrapper">
            <button type="button" class="cfg__scroll-btn cfg__scroll-btn--prev" aria-label="Przewiń w lewo">&#10094;</button>
            <div class="cfg__years container">
                <?php foreach ( $nav_structure as $item ) : ?>
                    <button type="button" class="cfg__year-btn gallery-button <?php echo $item['album_id'] === $active_album_id ? 'cfg__year-btn--active' : ''; ?>" data-target="cfg-album-<?php echo esc_attr( $item['album_id'] ); ?>"><?php echo $item['year']; ?></button>
                <?php endforeach; ?>
            </div>
            <button type="button" class="cfg__scroll-btn cfg__scroll-btn--next" aria-label="Przewiń w prawo">&#10095;</button>
        </div>
        <div class="cfg__container container">
            <div class="cfg__albums">
                <?php foreach ( $nav_structure as $item ) : ?>
                    <?php $has_expand = count( $item['galleries'] ) > 3; ?>
                    <div class="cfg__album-content <?php echo $item['album_id'] === $active_album_id ? 'cfg__album-content--active' : ''; ?> <?php echo $has_expand ? 'cfg__album-content--has-expand' : ''; ?>" id="cfg-album-<?php echo esc_attr( $item['album_id'] ); ?>">
                        <div class="cfg__album-buttons">
                            <?php foreach ( $item['galleries'] as $gallery ) : ?>
                                <button type="button" class="cfg__gallery-btn gallery-button <?php echo $gallery['id'] === $active_gallery_id ? 'cfg__gallery-btn--active' : ''; ?>" data-gallery-id="<?php echo esc_attr( $gallery['id'] ); ?>"><?php echo $gallery['title']; ?></button>
                            <?php endforeach; ?>
                        </div>
                        <?php if ( $has_expand ) : ?>
                            <button type="button" class="cfg__album-expand" aria-expanded="false" aria-label="Rozwiń listę albumów"><span class="cfg__album-expand-icon" aria-hidden="true">&#10094;</span><span class="cfg__album-count"><?php echo count( $item['galleries'] ); ?></span></button>
                        <?php endif; ?>
                    </div>
                    <?php if ( $item['description'] ) : ?>
                        <div class="cfg__album-description <?php echo $item['album_id'] === $active_album_id ? 'cfg__album-description--active' : ''; ?>" data-album-id="<?php echo esc_attr( $item['album_id'] ); ?>">
                            <?php echo $item['description']; ?>
                        </div>
                    <?php endif; ?>
                    
                <?php endforeach; ?>
            </div>
            <div class="cfg__display" aria-live="polite">
                <div class="cfg__gallery-loading" role="status" aria-label="Ładowanie galerii" hidden>
                    <span></span><span></span><span></span><span></span>
                </div>
                <p class="cfg__gallery-error" hidden></p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode( 'custom_foogallery', 'render_custom_foogallery_system' );