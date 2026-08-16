<?php 
/*Template Name: Galeria*/ 
get_header();
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
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>

<?php get_footer(); ?>