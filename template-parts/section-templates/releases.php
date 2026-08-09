<section class="releases container">
    <h2 id="releases" class="section__title">Wydania</h2>
    <div class="releases__container releases--loading">
        <div class="releases__scroll-wrapper">
            <div class="releases__content">
                <?php get_template_part('template-parts/components/album_card'); ?>
            </div>
        </div>
        <div class="releases__nav">
            <button class="carousel__btn carousel__btn--prev"   aria-label="Poprzednie wydanie">
                <?php echo file_get_contents( get_template_directory() . '/assets/images/icons/album-arrow.svg' ); ?>
            </button>
            <button class="carousel__btn carousel__btn--next" aria-label="Następne  wydanie">
                <?php echo file_get_contents( get_template_directory() . '/assets/images/icons/album-arrow.svg' ); ?>
            </button>
        </div>
    </div>
    <div class="releases__skeletons">
        <?php for ($i = 0; $i < 5; $i++) : ?>
            <div class="album-card--skeleton"></div>
        <?php endfor; ?>
    </div>
</section>