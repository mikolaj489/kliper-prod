<?php
$tekst_glowny = get_field('tekst_glowny');
$zacheta      = get_field('zacheta');
$zdjecie      = get_field('zdjecie_zespolu'); 
?>

<section class="about container">
    <h2 class="section__title">O Zespole</h2>
    <div class="about__container">
        <div class="about__wrapper">
            <div class="about__content">

                <?php if ($zacheta) : ?>
                    <p class="about__excerpt"><?php echo esc_html($zacheta); ?></p>
                <?php endif; ?>

                <?php if ($tekst_glowny) : ?>
                    <div class="about__text">
                        <span class="about__arrow">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/icons/read-arrow.svg'); ?>" alt="Strzałka">
                        </span>
                        <?php echo wp_kses_post($tekst_glowny); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="about__image-container">
                <?php if ($zdjecie) : ?>
                    <?php 
                    // Sprawdzamy, w jakim formacie ACF zwraca zdjęcie
                    $src = is_array($zdjecie) ? $zdjecie['url'] : $zdjecie;
                    $alt = is_array($zdjecie) ? $zdjecie['alt'] : 'Zdjęcie zespołu';
                    ?>
                    <img class="about__image" src="<?php echo esc_url($src); ?>" alt="<?php echo esc_attr($alt); ?>"/>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>