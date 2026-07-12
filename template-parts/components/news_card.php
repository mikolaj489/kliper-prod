<?php
    if (!defined('ABSPATH')) exit;
    $news = get_posts([
        'post_type'      => 'aktualnosci',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
?>

<div class="news-card">
    <?php foreach ($news as $post) : setup_postdata($post); ?>
        <div class="news-card_container">
            <h3 class="news-card__title"><?= esc_html(get_the_title()) ?></h3>
            <p class="news-card__excerpt"><?= esc_html(get_the_excerpt()) ?></p>
            <!-- <div class="news-card__editor"><?= get_the_content() ?></div> -->
        </div>
    <?php endforeach; wp_reset_postdata(); ?>
</div>
