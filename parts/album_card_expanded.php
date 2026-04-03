<style>
    .album-card--expanded {
        display: flex;
        gap: 70px;
        max-width: 950px;
    }
    .carousel {
        display: grid;
        grid-template-columns: minmax(55px, 80px) 1fr minmax(55px, 80px);
        grid-template-rows: auto auto;
        gap: 5px;
    }
    .carousel__track {
        min-height: 525px;
        overflow: visible;
        display: flex;
        align-items: center;
    }
    .carousel__card {
        width: auto;
    }
    .carousel__card--prev,
    .carousel__card--next {
        opacity: 0.5;
        filter: brightness(0.6);
        z-index: 1;
        pointer-events: none;
        display: none;
    }
    .carousel__card--prev {
        transform: translateX(-40px) scale(0.88);
    }
    .carousel__card--next {
        transform: translateX(40px) scale(0.88);
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
        transition: border, stroke-width  .3s;
        stroke-width: 2;
        z-index: 2;
        &:hover {
            stroke-width: 2.5;
            border: 2px solid #919191;
        }
       &:active {
            transform: scale(.97);
        }
        &:disabled {
            opacity: 0.3;
            pointer-events: none;
    }
    }
    .carousel__btn--next {
        justify-self: end;
    }
    .carousel__status {
        grid-column: 2 / 3;
        grid-row: 2;
        display: flex;
        justify-self: center;
        gap: 10px;
        margin-block-start: 30px;
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

    .album-card__content {
        width: 500px;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: repeat(4, min-content);
        gap: 10px;
        color: #E6E6E6;
    }
    .album-card__cover--expanded {
        width: 400px; height: 400px;
        place-self: center;
        border-radius: 12px;
         box-shadow: 4px 4px 12px rgba(0,0,0,0.3);
    }
    .album-card__title--expanded {
        color: var(--c-secondary);
        font-size: var(--fs-lg);
        letter-spacing: 5%;
        text-transform: uppercase;
        line-height: 60px;
        font-weight: bold;
        margin: 0;
    }
    .album-card__meta--expanded {
        color: color-mix(in srgb, var(--c-text-secondary), rgb(0,0,0) 20%);
        font-weight: 300;
        padding-block-end: 10px;
        position: relative;
        display: flex;
         &::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 100%; height: 1px;
            background-color:  var(--c-bg-lt);
        }
    }
    .album-card__year--expanded::after {
        content: '';
        display: inline-block;
        transform: translateY(-50%);
        width: 5px; height: 5px;
        clip-path: circle(50%);
        margin-inline: .5em;
        background-color: color-mix(in srgb, var(--c-text-secondary), rgb(0,0,0) 20%);
   }
   .album-card__description--expanded,
   .album-card__tracks-title  {
        letter-spacing: 5%;
   }
   .album-card__tracks--expanded {
        padding: .5em;
        border-radius: 12px;
        background-color: color-mix(in srgb, var(--c-primary-lt), transparent 70%);
        margin-block-start: 10px;
   }
   .album-card__tracks-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-flow: column;
        grid-template-rows: repeat(9, auto);
        gap: .1em;
        padding-inline-start: 30px;
        padding-block-start: 10px;
   }
   .album-card__track--hidden {
    display: none;
}

.album-card__tracks-toggle {
    background: none;
    border: 1px solid var(--c-bg-lt);
    border-radius: 20px;
    color: color-mix(in srgb, var(--c-text-secondary), rgb(0,0,0) 20%);
    font-size: 0.8em;
    padding: 2px 10px;
    cursor: pointer;
    margin-inline-start: 8px;
    transition: border-color 0.2s, color 0.2s;
    &:hover {
        color: #bbbbbb;
        border-color: #bbbbbb;
    }
}

/* Na to: */
.album-card__description--expanded .album-card__description-text {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 4; /* ← zawsze zaciśnięty domyślnie */
}

.album-card__description-toggle {
    background: none;
    border: 1px solid var(--c-bg-lt);
    border-radius: 20px;
    color: color-mix(in srgb, var(--c-text-secondary), rgb(0,0,0) 20%);
    font-size: 0.8em;
    padding: 2px 10px;
    cursor: pointer;
    margin-block-start: 6px;
    display: none;
    transition: border-color 0.2s, color 0.2s;

    &:hover {
        color: #bbbbbb;
        border-color: #bbbbbb;
    }
}

.album-card__description-toggle--visible {
    display: inline-block;
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
    $description = get_field('album_description', $album_id);
    $tracklist = get_field('album_tracklist', $album_id);
?>

<div class="album-card--expanded" data-album-id="<?= esc_attr($album_id) ?>">
    <?php if ($img): ?>
        <img class="album-card__cover--expanded" src="<?= esc_url($img['url']) ?>" alt="<?= esc_attr($img['alt']) ?>">
    <?php endif; ?>
    <div class="album-card__content">
        <h3 class="album-card__title--expanded"><?= esc_html($title) ?></h3>
        <div class="album-card__meta--expanded">
            <span class="album-card__year--expanded"><?= esc_html($year) ?></span>
            <span class="album-card__label"><?= esc_html($label) ?></span>
        </div>
        <div class="album-card__description--expanded">
            <p class="album-card__description-text"><?= esc_html($description) ?></p>
            <button class="album-card__description-toggle" data-expanded="false">Czytaj więcej</button>
        </div>
       <?php
            $tracks = array_filter(explode("\n", $tracklist));
            $tracks = array_values($tracks);
            $count = count($tracks);
            $limit = 18;
            $has_more = $count > $limit;
            $rows = ceil(min($count, $limit) / 2);
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