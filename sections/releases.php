<style>
    .releases {
        background-color: var(--c-primary);
        margin-block-start: calc(var(--sand-effect-height) * -1);
        padding-block-start: var(--sand-effect-height);
        position: relative;
        &::after {
            content: '';
            position: absolute;
            top: 0%;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: var(--c-bg);
            box-shadow: 0 0 120px 155px #F0EBD8;
        }
    }
    .releases__content {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 4rem;
    }
    .album-card {
        background: linear-gradient( to bottom, var(--c-text-muted) 0%, color-mix(in srgb, var(--c-primary), white 3%) 100%);
        display: grid;
        gap: 5px;
        padding: 20px;
        border-radius: 12px;
        transition: box-shadow .5s ease, transform 0.5s ease;
        &:hover {
            transform: scale(1.015);
            box-shadow: 0 0 8px var(--c-bg-lt);
            cursor: pointer;
        }
        &:active {
            transform: scale(.97);
        }
    }
    .album-card__cover {
        width: 400px;
        height: 400px;
        border-radius: 12px;
    }
    .album-card__meta {
        display: flex;
    }
    .album-card__year::after,
    .album-card__tracks::before  {
        content: '';
        display: inline-block;
        transform: translateY(-50%);
        width: 5px; height: 5px;
    }
   .album-card__year::after {
        clip-path: circle(50%);
        margin-inline: .5em;
        background-color: var(--c-secondary);
   }
    .album-card__tracks {
        color:  color-mix(in srgb, var(--c-text-muted), white 45%);
        margin: 0;
        &::before {
            background-color: color-mix(in srgb, var(--c-text-muted), white 45%);
            clip-path: polygon(100% 50%, 0 0, 0 100%);
            margin-inline-end: .5em;
        }
    }
    .album-card__year,
    .album-card__label {
        color: var(--c-secondary);
    }
    .album-card__title {
        font-family : var(--font-secondary);
        color: var(--c-text-secondary);
        font-size: 2rem;
        letter-spacing: 5%;
        font-weight: bold;
        margin: 0;
    }
</style>

<section class="releases container">
    <h1 class="section-title">Wydania</h1>
    <div class="releases__content">
        <?php
        $albumy = get_posts([
            'post_type'      => 'album',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        foreach ($albumy as $album) : 
            $img = get_field('album_cover', $album->ID);
        ?>
            <div class="album-card">
                <?php if ($img) : ?>
                    <img class="album-card__cover" src="<?= esc_url($img['url']) ?>" alt="<?= esc_attr($img['alt']) ?>">
                <?php endif; ?>
                <div class="album-card__meta">
                    <span class="album-card__year"><?= esc_html(get_field('album_release_year', $album->ID)) ?></span>
                    <span class="album-card__label"><?= esc_html(get_field('album_label', $album->ID)) ?></span>
                </div>
                <h3 class="album-card__title"><?= esc_html(get_field('album_title', $album->ID)) ?></h3>
                <p class="album-card__tracks"><?= esc_html(get_field('album_track_count', $album->ID)) ?>&nbsp;utworów</p>
            </div>
        <?php endforeach; ?>
    </div>
</section>