<?php 
/*Template Name: Koneser*/ 
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

    <section class="conno-info container">
        <div class="conno-info__content">
            <?php if ( $tytul_1 = get_field('shanty_title-1') ) : ?>
                <h2 class="conno-info__title"><?php echo esc_html($tytul_1); ?></h2>
            <?php endif; ?>
            <?php if ( $tresc_1 = get_field('shanty_content-1') ) : ?>
                <p class="conno-info__text"><?php echo wp_kses_post($tresc_1); ?></p>
            <?php endif; ?>
        </div>
        <div class="conno-info__content">
            <?php if ( $tytul_2 = get_field('shanty_title-2') ) : ?>
                <h2 class="conno-info__title"><?php echo esc_html($tytul_2); ?></h2>
            <?php endif; ?>
            <?php if ( $tresc_2 = get_field('shanty_content-2') ) : ?>
                <p class="conno-info__text"><?php echo wp_kses_post($tresc_2); ?></p>
            <?php endif; ?>
        </div>
    </section>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>