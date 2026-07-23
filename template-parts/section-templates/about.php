<?php
    if (!defined('ABSPATH')) exit;
    $about_posts = get_posts([
        'post_type'      => 'zespol',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    if (!empty($about_posts)) : 
        $about_post = $about_posts[0];
        $post_id = $about_post->ID;   
?>

<section class="about container">
    <h2 class="section__title">O Zespole</h2>
    <div class="about__container">
        <div class="about__wrapper">
            <div class="about__content">
                <p class="about__excerpt"><?php echo esc_html(get_the_excerpt($post_id)); ?></p>
                <div class="about__text">
                    <span class="about__arrow">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/read-arrow.svg'); ?>" alt="Strzałka">
                    </span>
                    <?php $content = apply_filters('the_content', $about_post->post_content); echo wp_kses_post($content);?>
                </div>
            </div>
            <div class="about__image-container">
                <?php $image_url = get_the_post_thumbnail_url($post_id, 'full'); if ($image_url) :?>
                    <img class="about__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>"/>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>