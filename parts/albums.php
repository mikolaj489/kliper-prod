<style>
    .albums {
        background-color: var(--c-primary);
        margin-block-start: calc(var(--sand-effect-height) * -1);
        padding-block-start: var(--sand-effect-height);
        position: relative;
        height: 500px;
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
    .albums__content {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
<?php
    $img = get_field('album_cover');
?>
<section class="albums container">
    <h1 class="section-title">Wydania</h1>
    <div class="albums__content">
        <div class="album-card">
            <?php if($img): ?>
                <img class="album-card__cover" src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
            <?php endif; ?>
            <di3 class="album-card__info">
                <span class="album-card__year">2025r.</span>
                <span class="album-card__badge">Nowa płyta zespołu</span>
                <h3 class="album-card__title">Zapomniany powrót</h3>
                <p class="album-card__tracks">▸ 11 utworów</p>
            </div>
        </div>
    </div>
</section>