<?php 
/*Template Name: Historia*/ 
    get_header();
?>

<main class="content-area">
    <div class="page-welcome container">
        <h1 class="page-welcome__title"><?= esc_html( get_the_title() ); ?></h1>
        <?php $welcome_text = get_field('section_subtext'); if ($welcome_text) : ?>
        <div class="page-welcome__text">
            <?php echo wp_kses_post($welcome_text); ?>
        </div>
        <?php endif; ?>
    </div>
    <section class="plot container">
        <div class="plot__wrapper"> 
            <span class="plot__trigger"></span>
            <?php
                $plot_box_index = 0;
                for ( $i = 1; $i <= 8; $i++ ) {
                    $title   = get_field( 'plot_title_' . $i );
                    $content = get_field( 'plot_content_' . $i );

                    if ( $title || $content) {
                        $plot_box_index++;
                        echo '<div class="plot__box">';
                        if ( $title ) {
                            echo '<h3 class="plot__title">' . esc_html( $title ) . '</h3>';
                        }
                        if ( $content ) {
                            echo '<div class="plot__content">' . wp_kses_post( $content ) . '</div>';
                        }
                        if ( 1 === $plot_box_index ) {
                            $plot_icon_path = get_template_directory() . '/assets/images/plot-icons/plot-icon1.svg';
                            if ( file_exists( $plot_icon_path ) ) {
                                echo '<span class="plot__icon" aria-hidden="true">' . file_get_contents( $plot_icon_path ) . '</span>';
                            }
                        }
                        echo '</div>';
                    }
                }
                $end = get_field('plot_end');
                if ( $end ) {
                    $plot_box_index++;
                    echo '<div class="plot__box plot__end plot__content">' . wp_kses_post( $end ) . '</div>';
                }
            ?>
        </div>
    </section>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>