<?php
if (!defined('ABSPATH')) exit;

$album_id = $args['album_id'] ?? null;
if (!$album_id) return;

$img    = get_field('album_cover', $album_id);
$year   = get_field('album_release_year', $album_id);
$label  = get_field('album_label', $album_id);
$title  = get_field('album_title', $album_id);
$tracks = get_field('album_track_count', $album_id);
?>

<div class="album-card album-card--expanded" data-album-id="<?= esc_attr($album_id) ?>">
    <?php if ($img): ?>
        <img class="album-card__cover"
             src="<?= esc_url($img['url']) ?>"
             alt="<?= esc_attr($img['alt']) ?>">
    <?php endif; ?>
    <div class="album-card__meta">
        <span class="album-card__year"><?= esc_html($year) ?></span>
        <span class="album-card__label"><?= esc_html($label) ?></span>
    </div>
    <h3 class="album-card__title"><?= esc_html($title) ?></h3>
    <p class="album-card__tracks"><?= esc_html($tracks) ?>&nbsp;utworów</p>
    <button class="album-card__close">✕ Zamknij</button>
    {{-- tutaj możesz dodać dodatkowe pola: opis, tracklista itp. --}}
</div>