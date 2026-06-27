<?php
    $img = get_field('hero_logo');
?>

<div class="hero__content container">
    <?php if($img): ?>
        <img class="hero__logo" src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" width="350" height="auto">
    <?php endif; ?>
    <span class="hero__subtext"><?php the_field('hero_greeting'); ?></span>
    <p class="hero__text"><?php the_field('hero_description'); ?></p>
</div>