<?php
    if (!defined('ABSPATH')) exit;

    $album_id = $args['album_id'] ?? null;
    if (!$album_id) return;

    $img         = get_field('album_cover', $album_id);
    $year        = get_field('album_release_year', $album_id);
    $label       = get_field('album_label', $album_id);
    $title       = get_field('album_title', $album_id);
    $description = get_field('album_description', $album_id);
    $tracklist   = get_field('album_tracklist', $album_id);
?>

<div class="album-card--expanded" data-album-id="<?= esc_attr($album_id) ?>">
    <h3 class="album-card__title--expanded"><?= esc_html($title) ?></h3>
    <?php if ($img): ?>
        <img class="album-card__cover--expanded" src="<?= esc_url($img['url']) ?>" alt="<?= esc_attr($img['alt']) ?>">
    <?php endif; ?>
    <div class="album-card__content">
        <div class="album-card__meta--expanded">
            <span class="album-card__year--expanded"><?= esc_html($year) ?></span>
            <span class="album-card__label"><?= esc_html($label) ?></span>
        </div>
        <div class="album-card__description--expanded">
            <p class="album-card__description-text"><?= esc_html($description) ?></p>
            <button class="album-card__description-toggle" data-expanded="false">Czytaj więcej</button>
        </div>
        <?php
            $tracks   = array_filter(explode("\n", $tracklist));
            $tracks   = array_values($tracks);
            $count    = count($tracks);
            $limit    = 18;
            $has_more = $count > $limit;
            $rows     = ceil(min($count, $limit) / 2);
        ?>
        <div class="album-card__tracks--expanded">
            <p class="album-card__tracks-title">
                Spis utworów:
                <?php if ($has_more): ?>
                    <button class="album-card__tracks-toggle" data-expanded="false">
                        + <?= $count - $limit ?> więcej
                    </button>
                <?php endif; ?>
            </p>
            <ol class="album-card__tracks-list" style="grid-template-rows: repeat(<?= $rows ?>, auto)">
                <?php foreach ($tracks as $i => $track): ?>
                    <li class="<?= $i >= $limit ? 'album-card__track--hidden' : '' ?>">
                        <?= esc_html(trim($track)) ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>