<style>
    .album-card--expanded {
        background-color: red;
    }
    .carousel {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .carousel__card {
        flex: 1;
    }

    .carousel__btn {
        flex-shrink: 0;
        width: 48px;
        height: 48px;
        font-size: 24px;
        cursor: pointer;
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        border-radius: 50%;
    }

    .carousel__btn:disabled {
        opacity: 0.3;
        cursor: default;
    }
    .carousel__status {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 16px;
    }

.carousel__dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.3);
    cursor: pointer;
    transition: background 0.2s;
}

.carousel__dot--active {
    background: #fff;
    transform: scale(1.3);
}
</style>
<?php
    if (!defined('ABSPATH')) exit;

    $album_id = $args['album_id'] ?? null;
    if (!$album_id) return;

    $img    = get_field('album_cover', $album_id);
    $year   = get_field('album_release_year', $album_id);
    $label  = get_field('album_label', $album_id);
    $title  = get_field('album_title', $album_id);
?>

<div class="album-card--expanded" data-album-id="<?= esc_attr($album_id) ?>">
    <?php if ($img): ?>
        <img class="album-card__cover" src="<?= esc_url($img['url']) ?>" alt="<?= esc_attr($img['alt']) ?>">
    <?php endif; ?>
    <div class="album-card__meta">
        <span class="album-card__year"><?= esc_html($year) ?></span>
        <span class="album-card__label"><?= esc_html($label) ?></span>
    </div>
    <h3 class="album-card__title"><?= esc_html($title) ?></h3>
     <div></div>
    {{-- tutaj możesz dodać dodatkowe pola: opis, tracklista itp. --}}
</div>