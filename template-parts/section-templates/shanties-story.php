<?php
$tytul_1 = get_field('story_title_1');
$tresc_1 = get_field('story_content_1');
$stats_1 = get_field('story_stats_1');

$tytul_2 = get_field('story_title_2');
$subtext = get_field('story_subtext');
$tresc_2 = get_field('story_content_2');
$stats_2 = get_field('story_stats_2');
?>

<section class="shanties-story container">
    <!-- <div class="shanties-story__content">
        <?php if ( $tytul_1 ) : ?>
            <h2 class="shanties-story__title"><?= esc_html($tytul_1) ?></h2>
        <?php endif; ?>
        <?php if ( $tresc_1 ) : ?>
            <p class="shanties-story__text"><?= wp_kses_post($tresc_1) ?></p>
        <?php endif; ?>
        <?php if ( $stats_1 ) : ?>
            <p class="shanties-story__stats"><?= wp_kses_post($stats_1) ?></p>
        <?php endif; ?>
    </div> -->
    <div class="shanties-story__content">
        <?php if ( $tytul_2 ) : ?>
            <h2 class="shanties-story__title"><?= esc_html($tytul_2) ?></h2>
        <?php endif; ?>
        <?php if ( $subtext ) : ?>
            <span class="shanties-story__subtext"><?= esc_html($subtext) ?></span>
        <?php endif; ?>
        <?php if ( $tresc_2 ) : ?>
            <p class="shanties-story__text"><?= wp_kses_post($tresc_2) ?></p>
        <?php endif; ?>
        <?php if ( $stats_2 ) : ?>
            <div class="shanties-story__box">
                <p class="shanties-story__stats"><?= wp_kses_post($stats_2) ?></p> 
            </div>
        <?php endif; ?>
    </div>
</section>