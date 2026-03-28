<style>
    .album-card--expanded {
        background-color: red;
    }
    .carousel {
        display: grid;
        grid-template-columns: 48px 1fr 48px;
        grid-template-rows: auto auto;
        gap: 16px;
    }
    .carousel__card {
        flex: 1;
    }
    .carousel__btn {
        width: 55px; height: 55px;
        font-size: 24px;
        cursor: pointer;
        background-color: #414750;
        color: #919191;
        border: 2px solid transparent;
        border-radius: 50%;
        align-self: center;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: border stroke-width  .3s;
        stroke-width: 2;
        &:hover {
            stroke-width: 2.5;
            border: 2px solid #919191;
        }
       &:active {
            transform: scale(.97);
        }
    }

    .carousel__btn:disabled {
        opacity: 0.3;
        pointer-events: none;
    }
    .carousel__status {
        grid-column: 2 / 3;
        grid-row: 2;
        display: flex;
        justify-self: center;
        gap: 10px;
        margin-block-start: 16px;
    }

    .carousel__dot {
        padding-inline: 5px;
        padding-block: 5px;
        border-radius: 20px;
        border: none;
        background-color: #5C5C5C;
        cursor: pointer;
        transition: background-color 0.2s, padding-inline 0.2s;
        &:hover {
            filter: brightness(1.3);
        }

    }
    .carousel__dots,
    .carousel__close {
        background-color: #414750;
        border-radius: 20px;
        padding-inline: 15px;
        padding-block: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
        gap: 10px;
        color: #919191;
    }
    .carousel__close {
        cursor: pointer;
        &:hover {
            color: #bbbbbb;
        };
        &:active {
            transform: scale(.97);
        }
    }
    .carousel__dot--active {
        background-color: #919191;
        padding-inline: 10px;
        pointer-events: none;
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