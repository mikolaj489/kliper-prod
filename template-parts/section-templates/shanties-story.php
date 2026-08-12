<?php
$tytul_1 = get_field('story_title_1');
$subtext_1 = get_field('story_subtext_1');
$tresc_1 = get_field('story_content_1');
$stats_1 = get_field('story_stats_1');
$image_1 = get_field('story_background_1');

$tytul_2 = get_field('story_title_2');
$subtext_2 = get_field('story_subtext_2');
$tresc_2 = get_field('story_content_2');
$stats_2 = get_field('story_stats_2');
$image_2 = get_field('story_background_2');
?>

<section class="shanties-story">
    <div class="shanties-story__container">
        <div class="shanties-story__content container">
            <?php if ( $tytul_1 ) : ?>
                <h2 class="shanties-story__title"><?= esc_html($tytul_1) ?></h2>
            <?php endif; ?>
            <?php if ( $subtext_1 ) : ?>
                <span class="shanties-story__subtext"><?= esc_html($subtext_1) ?></span>
            <?php endif; ?>
            <?php if ( $tresc_1 ) : ?>
                <p class="shanties-story__text"><?= wp_kses_post($tresc_1) ?></p>
            <?php endif; ?>
            <?php if ( $stats_1 ) : ?>
                <div class="shanties-story__box">
                   <p class="shanties-story__stats">
                        <?= wp_kses_post(preg_replace('/\s*\R\s*/', ' | ', trim($stats_1))) ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
        <div class="shanties-story__background">
            <?php if ( $image_1 ) : ?>
                <img class="shanties-story__img" src="<?php echo esc_url( $image_1['url'] ); ?>" alt="<?php echo esc_attr( $image_1 ['alt'] ); ?>">
            <?php endif; ?>
        </div>
    </div>
    <div class="shanties-story__container">
        <div class="shanties-story__content container">
            <?php if ( $tytul_2 ) : ?>
                <h2 class="shanties-story__title"><?= esc_html($tytul_2) ?></h2>
            <?php endif; ?>
            <?php if ( $subtext_2 ) : ?>
                <span class="shanties-story__subtext"><?= esc_html($subtext_2) ?></span>
            <?php endif; ?>
            <?php if ( $tresc_2 ) : ?>
                <p class="shanties-story__text"><?= wp_kses_post($tresc_2) ?></p>
            <?php endif; ?>
            <?php if ( $stats_2 ) : ?>
                <div class="shanties-story__box">
                   <p class="shanties-story__stats">
                        <?= wp_kses_post(preg_replace('/\s*\R\s*/', ' | ', trim($stats_2))) ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
        <div class="shanties-story__background">
            <?php if ( $image_2 ) : ?>
                <img class="shanties-story__img" src="<?php echo esc_url( $image_2['url'] ); ?>" alt="<?php echo esc_attr( $image_2 ['alt'] ); ?>">
            <?php endif; ?>
        </div>
    </div>
</section>