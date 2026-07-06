<?php
    $albumy = get_posts([
        'post_type'      => 'album',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    foreach ($albumy as $album) : 
        $img = get_field('album_cover', $album->ID);
    if (!defined('ABSPATH')) exit;
?>

<div class="album-card" data-album-id="<?= esc_attr($album->ID) ?>">
    <?php if ($img) : ?>
        <img class="album-card__cover" src="<?= esc_url($img['url']) ?>" alt="<?= esc_attr($img['alt']) ?>" crossOrigin="anonymous">
    <?php endif; ?>
    <div class="album-card__meta">
        <span class="album-card__year"><?= esc_html(get_field('album_release_year', $album->ID)) ?></span>
        <span class="album-card__label"><?= esc_html(get_field('album_label', $album->ID)) ?></span>
    </div>
    <h3 class="album-card__title"><span class="album-card__title-text"><?= esc_html(get_field('album_title', $album->ID)) ?></span></h3>
    <p class="album-card__tracks"><?= esc_html(get_field('album_trackcount', $album->ID)) ?>&nbsp;utworów</p>
</div>

<?php endforeach; ?>