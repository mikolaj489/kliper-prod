<?php
$events = new WP_Query([
    'post_type'      => 'archiwum',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC',
]);

if ($events->have_posts()) :
    $grouped_events = [];
    while ($events->have_posts()) : $events->the_post();
        $terms = get_the_terms(get_the_ID(), 'rok_archiwum');
        if ($terms && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $grouped_events[$term->name][] = [
                    'id'          => get_the_ID(),
                    'title'       => get_the_title(),
                    'permalink'   => get_permalink(),
                    'content'     => get_the_content(),
                    'event_date'  => get_post_meta(get_the_ID(), 'data_wydarzenia', true),
                ];
            }
        }
    endwhile;
    wp_reset_postdata();
    krsort($grouped_events);
    foreach ($grouped_events as $year_name => $year_events) : ?>
        <div class="archive-year-block">
            <h3 class="year-title">ROK <?php echo esc_html($year_name); ?></h3>
            
            <div class="events-card">
                <ul class="events-list">
                    <?php foreach ($year_events as $event) : 
                        $has_content = !empty(trim($event['content']));
                    ?>
                        <li class="event-item">
                            <?php if ($event['event_date']) : ?>
                                <span class="event-badge"><?php echo esc_html($event['event_date']); ?></span>
                            <?php endif; ?>
                    
                            <span class="event-dot">•</span>
                            
                            <?php if ($has_content) : ?>
                                <a href="<?php echo esc_url($event['permalink']); ?>" class="event-link" data-modal-id="modal-<?php echo $event['id']; ?>">
                                    <?php echo esc_html($event['title']); ?>
                                </a>
                                
                                <div id="modal-<?php echo $event['id']; ?>" class="modal-box container" style="display: none;">
                                    <div class="modal-box__container">
                                        <div class="modal-box__content">
                                            <span class="modal-box__close">&times;</span>
                                            <h2><?php echo esc_html($event['title']); ?></h2>
                                            <?php echo apply_filters('the_content', $event['content']); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                             
                                <span class="event-title-no-link"><?php echo esc_html($event['title']); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach;
endif;
?>