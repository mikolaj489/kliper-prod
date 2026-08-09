<?php
/*Template Name: Archiwum*/ 
get_header();

$archiwum_query = new WP_Query([
    'post_type'      => 'aktualnosci',
    'posts_per_page' => 100,
    'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
]);
?>
<main class="content-area">
    <section class="news container">
        <h1 class="section__title--first"><?= esc_html( get_the_title() ); ?></h1>
        <div class="section__subtext">
            <?php
                $welcome_text = get_field('section_subtext');
                if ($welcome_text) :
            ?>
            <p class="section__subtext-content"><?php echo esc_html($welcome_text); ?></p>
            <?php endif; ?>
        </div>
        <?php if ($archiwum_query->have_posts()) : ?>
            <div class="news__container">
                <div class="news__content">
                    <?php while ($archiwum_query->have_posts()) : $archiwum_query->the_post(); ?>
                        <?php
                            $content = apply_filters('the_content', get_the_content('', false, get_the_ID()));
                        ?>
                        <article class="news__card" data-post-id="<?php echo esc_attr(get_the_ID()); ?>" aria-expanded="false">
                            <span class="news__card-date"><?php echo esc_html(get_the_date('d.m.Y')); ?></span>
                            <h2 class="news__card-title"><?php echo esc_html(get_the_title()); ?></h2>
                            <div class="news__card-body">
                                <p class="news__card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                                <div class="news__card-content"><?php echo apply_filters('the_content', $content); ?></div>
                            </div>
                            <button class="news__card-toggle" type="button" aria-expanded="false">Czytaj więcej</button>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>

            <?php
            echo paginate_links([
                'total'     => $archiwum_query->max_num_pages,
                'current'   => max(1, get_query_var('paged')),
                'prev_text' => '←',
                'next_text' => '→',
            ]);
            ?>

        <?php else : ?>
            <p>Brak aktualności do wyświetlenia.</p>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </section>
    <?php get_template_part('template-parts/components/go_top'); ?>
</main>
<?php get_footer();?>