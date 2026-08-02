<?php 
    /*Template Name: Strona główna*/ 
?>
<?php get_header(); ?>
<main class="content-area">
    <?php get_template_part('template-parts/section-templates/hero'); ?>
    <?php get_template_part('template-parts/section-templates/releases'); ?>
    <?php get_template_part('template-parts/section-templates/news'); ?>
    <?php get_template_part('template-parts/section-templates/about'); ?>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>