<?php
    $slogans = [];
    for ($i = 1; $i <= 7; $i++) {
        $slogans[] = get_field('slogan_' . $i);
    }

    $icons = [
        get_template_directory_uri() . '/assets/images/icons/helm.png',
        get_template_directory_uri() . '/assets/images/icons/microphone.png',
        get_template_directory_uri() . '/assets/images/icons/note.png',
        get_template_directory_uri() . '/assets/images/icons/pirate.png',
        get_template_directory_uri() . '/assets/images/icons/gituar.png',
        get_template_directory_uri() . '/assets/images/icons/ship.png',
        get_template_directory_uri() . '/assets/images/icons/wave.png',
    ];

    $shuffled_icons = $icons;
    shuffle($shuffled_icons);
?>

<div class="hero__animation-container">
    <div class="hero__animation-content">
        <div class="blob blob--main">
            <p class="blob__slogan"><?= esc_html($slogans[0]) ?></p>
            <?php for ($i = 1; $i <= 7; $i++): ?>
            <div class="blob blob--<?= $i ?>">
                <img src="<?= esc_url($shuffled_icons[$i - 1]) ?>" alt="">
            </div>
            <?php endfor; ?>
        </div>
    </div>
</div>

