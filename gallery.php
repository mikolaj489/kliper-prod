<?php 
/*Template Name: Galeria*/ 
get_header();
$tekst_wstepu = get_field('text_intro'); 
$logo_image = get_field('intro_logo');
?>
<main class="content-area">
    <div class="page-welcome container">
        <h1 class="page-welcome__title"><?= esc_html( get_the_title() ); ?></h1>
        <?php $welcome_text = get_field('section_subtext'); if ($welcome_text) : ?>
        <div class="page-welcome__text">
            <?php echo apply_filters('the_content', $welcome_text); ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="gallery__wrapper">
        <?php echo render_custom_foogallery_system(); ?>
        <div class="gallery__intro container">
            <div class="gallery__intro-subtext">Uchwycone chwile zespołu</div>
            <?php if ( ! empty( $tekst_wstepu ) ) : ?>
                <div class="gallery__intro-text">
                    <?php if ( ! empty( $logo_image['url'] ) ) : ?>
                        <div class="gallery__intro-img__container">
                            <img class="spiral-arrow" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/spiral-arrow.svg' ); ?>" alt="" loading="lazy">
                            <img 
                                class="gallery__intro-img"
                                src="<?php echo esc_url( $logo_image['url'] ); ?>" 
                                alt="<?php echo ! empty( $logo_image['alt'] ) ? esc_attr($logo_image['alt'] ) : ''; ?>" 
                                loading="lazy"
                            />
                        </div>
                    <?php endif; ?>
                    <?php echo wp_kses_post( $tekst_wstepu ); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>
<?php get_footer(); ?>