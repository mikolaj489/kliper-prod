<?php 
/*Template Name: Kontakt*/ 
?>

<?php get_header(); ?>

<main class="content-area">
    <section class="contact container">
        <h1 class="section__title"><?= esc_html( get_the_title() ); ?></h1>
    </section>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>