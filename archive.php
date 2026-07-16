<?php
get_header();
?>
<main class="content-area">
    <section class="news container">
        <h1 class="section__title">Archiwum</h1>

        <?php if (have_posts()) : ?>
            <div class="news__container">
                <div class="news__content">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php
                            $content = apply_filters('the_content', get_the_content('', false, get_the_ID()));
                        ?>
                        <article class="news__card" data-post-id="<?php echo esc_attr(get_the_ID()); ?>" aria-expanded="false">
                            <span class="news__card-date"><?php echo esc_html(get_the_date('d.m.Y')); ?></span>
                            <h2 class="news__card-title"><?php echo esc_html(get_the_title()); ?></h2>
                            <div class="news__card-body">
                                <p class="news__card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
                                <div class="news__card-content"><?php echo wp_kses_post($content); ?></div>
                            </div>
                            <button class="news__card-toggle" type="button" aria-expanded="false">Czytaj więcej</button>
                        </article>
                    <?php endwhile; ?>
                </div>
            </div>

            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p>Brak aktualności do wyświetlenia.</p>
        <?php endif; ?>
    </section>
</main>

<?php
get_footer();
