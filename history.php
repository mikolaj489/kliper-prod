<?php 
/*Template Name: Historia*/ 
    get_header();
?>

<main class="content-area">
    <section class="connoisseur container">
        <h1 class="section__title--first"><?= esc_html( get_the_title() ); ?> </h1>
        <div class="section__subtext">
            <?php
            $welcome_text = get_field('section_subtext');
            if ($welcome_text) :
            ?>
                <div class="section__subtext-content">
                    <?php echo wp_kses_post($welcome_text); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>