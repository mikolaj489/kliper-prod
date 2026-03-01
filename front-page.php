<?php get_header(); ?>

<main>
    <h1><?= esc_html( get_the_title() ); ?></h1>
</main>


<?php get_template_part('parts/hero'); ?>
<?php get_template_part('parts/about'); ?>
<?php get_template_part('parts/gallery'); ?>

<?php get_footer(); ?>