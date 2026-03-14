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
    }
    .album-card__cover {
        width: 400px;
        height: 400px;
        border-radius: 12px;
    }
    .album-card__year {

    }
</style>
<?php
    $img = get_field('album_cover');
?>
<section class="releases container">
    <h1 class="section-title">Wydania</h1>
    <div class="releases__content">
        <div class="album-card">
            <?php if($img): ?>
                <img class="album-card__cover" src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
            <?php endif; ?>
            <div class="album-card__info">
                <span class="album-card__year"><?php echo get_field('album_release_year'); ?></span>
                <span class="album-card__badge"><?php echo get_field('album_sub_text'); ?></span>
                <h3 class="album-card__title"><?php echo get_field('album_title'); ?></h3>
                <p class="album-card__tracks"><?php echo get_field('album_track_count'); ?></p>
            </div>
        </div>
    </div>
</section>