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
    <div class="news__card">
        <span class="news__card-date"><?= esc_html(get_the_date('d.m.Y')) ?></span>
        <h3 class="news__card-title"><?= esc_html(get_the_title()) ?></h3>
        <p class="news__card-excerpt"><?= esc_html(get_the_excerpt()) ?></p>
        <!-- <div class="news__card__editor"><?= get_the_content() ?></div> -->
    </div>
<?php endforeach; wp_reset_postdata(); ?>
