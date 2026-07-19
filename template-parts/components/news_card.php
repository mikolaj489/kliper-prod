<?php
    if (!defined('ABSPATH')) exit;
    $news = get_posts([
        'post_type'      => 'aktualnosci',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
?>

<?php foreach ($news as $post) : setup_postdata($post); ?>
    <?php
        $content = apply_filters('the_content', get_the_content('', false, $post->ID));
    ?>
    <article class="news__card" data-post-id="<?php echo esc_attr($post->ID); ?>" aria-expanded="false">
        <span class="news__card-date"><?php echo esc_html(get_the_date('d.m.Y')); ?></span>
        <h3 class="news__card-title"><?php echo esc_html(get_the_title()); ?></h3>
        <div class="news__card-body">
            <p class="news__card-excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
            <div class="news__card-content"><?php echo apply_filters('the_content', $content); ?></div>
        </div>
        <button class="news__card-toggle" type="button" aria-expanded="false">Czytaj więcej</button>
    </article>
<?php endforeach; wp_reset_postdata(); ?>
