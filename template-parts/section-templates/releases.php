<section class="releases container">
    <h2 class="section__title">Wydania</h2>
    <div class="releases__scroll-wrapper">
        <div class="releases__content">
            <?php get_template_part('template-parts/components/album_card'); ?>
        </div>
    </div>
    <div class="releases__nav">
        <button class="carousel__btn carousel__btn--prev" aria-label="Poprzednie wydanie">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="carousel__btn carousel__btn--next" aria-label="Następne wydanie">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
</section>