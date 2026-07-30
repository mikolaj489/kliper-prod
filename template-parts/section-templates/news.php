<section class="news container">
    <h2 class="section__title">Aktualności</h2>
    <div class="news__container">
           <div class="news__content">
                <?php get_template_part('template-parts/components/news_card'); ?>
                <?php 
                $archiwum_page = get_page_by_path('archiwum');
                $archive_link  = $archiwum_page ? get_permalink($archiwum_page) : '#';
                ?>
                <a class="news__card-link" href="<?php echo esc_url($archive_link); ?>">
                    <div class="news__card news__card--archive">
                        <h3 class="news__card-title">Archiwum</h3>
                         <p class="news__card-excerpt">Zobacz wszystkie aktualności</p>
                    </div>
                </a>
           </div>
           <?php get_template_part('template-parts/components/news_slider'); ?>
    </div>
</section>