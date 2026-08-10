    <section class="shanties-about container">
        <div class="shanties-about__content">
            <img class="shanties-about__icon" src="<?= esc_url(get_template_directory_uri() . '/assets/images/icons/conno-icon1.svg') ?>">
            <?php if ( $tytul_1 = get_field('shanty_title-1') ) : ?>
                <h2 class="shanties-about__title"><?php echo esc_html($tytul_1); ?></h2>
            <?php endif; ?>
            <?php if ( $tresc_1 = get_field('shanty_content-1') ) : ?>
                <p class="shanties-about__text"><?php echo wp_kses_post($tresc_1); ?></p>
            <?php endif; ?>
        </div>
        <div class="shanties-about__content">
            <img class="shanties-about__icon" src="<?= esc_url(get_template_directory_uri() . '/assets/images/icons/conno-icon2.svg') ?>">
            <?php if ( $tytul_2 = get_field('shanty_title-2') ) : ?>
                <h2 class="shanties-about__title"><?php echo esc_html($tytul_2); ?></h2>
            <?php endif; ?>
            <?php if ( $tresc_2 = get_field('shanty_content-2') ) : ?>
                <p class="shanties-about__text"><?php echo wp_kses_post($tresc_2); ?></p>
            <?php endif; ?>
        </div>
        <span class="shanties-about__line"></span>
    </section>