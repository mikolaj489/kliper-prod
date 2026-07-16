<section class="news container">
    <h2 class="section__title">Aktualności</h2>
    <div class="news__container">
           <div class="news__content">
                <?php get_template_part('template-parts/components/news_card'); ?>
                <?php $archive_link = get_post_type_archive_link('aktualnosci'); ?>
                <a class="news__card-link" href="<?php echo $archive_link; ?>">
                    <div class="news__card news__card--archive">
                        <h3 class="news__card-title">Archiwum</h3>
                         <p class="news__card-excerpt">Zobacz wszystkie aktualności</p>
                    </div>
                </a>
           </div>
           <?php get_template_part('template-parts/components/news_slider'); ?>
    </div>
    <div style="height: 1000px;"></div>
</section>