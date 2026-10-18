<?php
$years = get_terms([
    'taxonomy'   => 'rok_archiwum',
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'DESC',
]);

if (!empty($years) && !is_wp_error($years)) :
    foreach ($years as $year) : ?>
        
        <div class="archive-year-block">
            <h3 class="year-title">ROK <?php echo esc_html($year->name); ?></h3>
            
            <div class="events-card">
                <ul class="events-list">
                    <?php
                    // Pobieramy wydarzenia dla danego roku
                    $events = new WP_Query([
                        'post_type'      => 'archiwum',
                        'posts_per_page' => -1,
                        'tax_query'      => [[
                            'taxonomy' => 'rok_archiwum',
                            'field'    => 'term_id',
                            'terms'    => $year->term_id,
                        ]],
                        'orderby'        => 'date',
                        'order'          => 'ASC',
                    ]);

                    if ($events->have_posts()) :
                        while ($events->have_posts()) : $events->the_post();
                            $event_date = get_post_meta(get_the_ID(), 'data_wydarzenia', true);
                            ?>
                            <li class="event-item">
                                <?php if ($event_date) : ?>
                                    <span class="event-badge"><?php echo esc_html($event_date); ?></span>
                                <?php endif; ?>
                        
                                <span class="event-dot">•</span>
                                
                                <a href="<?php the_permalink(); ?>" class="event-link">
                                    <?php the_title(); ?>
                                </a>
                                <div id="modal-<?php the_ID(); ?>" class="archive__modal-box" style="display: none;">
                                    <div class="modal-content">
                                        <span class="modal-box__close">&times;</span>
                                        <h2><?php the_title(); ?></h2>
                                        <div class="modal-body">
                                            <?php the_content();  ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </ul>
            </div>
        </div>

    <?php endforeach;
endif;
?>