<?php
    $date = get_field('anni_date');
    $title = get_field('anni_title');
    $sub_title = get_field('anni_sub_title');
    $text = get_field('anni_text');
    $excerpt = get_field('anni_excerpt');
    $author = get_field('anni_author');
    $gallery = get_field('anni_gallery');
    $gallery_id = is_object($gallery) ? $gallery->ID : $gallery;
    $gallery_author = $gallery_id ? get_field('autor_zdjec', $gallery_id) : '';
?>

<section class="anniversary container">
    <div class="anniversary__wrapper">
        <h2 class="section__title section__title--anniversary">Jubileusz</h2>
        <?php if ( $date ) : ?>
            <p class="anniversary__date"><?php echo esc_html( $date ); ?></p>
        <?php endif; ?>
        <div class="anniversary__container">
            <?php if ( $title ) : ?>
                <div class="anniversary__title-wrapper">
                    <h2 class="anniversary__title"><?php echo esc_html( $title ); ?></h2>
                </div>
            <?php endif; ?>
            <div class="anniversary__content">
                <?php if ( $sub_title ) : ?>
                    <h4 class="anniversary__sub-title"><?php echo esc_html( $sub_title ); ?></h4>
                <?php endif; ?>
                <?php if ( $text ) : ?>
                    <div class="anniversary__text">
                        <?php echo wp_kses_post( $text ); ?>
                    </div>
                <?php endif; ?>
                <?php if ( $excerpt ) : ?>
                    <p class="anniversary__excerpt"><?php echo wp_kses_post( $excerpt ); ?></p>
                <?php endif; ?>
                <?php if ( $author ) : ?>
                    <p class="anniversary__author"><?php echo esc_html( $author ); ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="section__divider">
            <span>Zdjęcia z wydarzenia</span>
        </div>
        <div class="anniversary__gallery">
            <?php if ( $gallery ) : ?>
                <?php if (function_exists('foogallery_render_gallery')) {
                    foogallery_render_gallery($gallery_id);
                }?>
            <?php endif; ?>
            <?php if ( $gallery_author ) : ?>
                <p class="anniversary__gallery-author cfg__gallery-author"><?php echo esc_html( $gallery_author ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>