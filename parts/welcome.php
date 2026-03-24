<style>
    .hero__content {
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: auto auto auto;
        width: fit-content;
        flex: 0 1000px;
        max-width: 800px;
        align-self: center;
        gap: clamp(0.5rem, 2vw, 1.5rem);
    }
    .hero__logo {
        min-width: 100%;
        height: auto;
    }
    .hero__subtext {
        font-family: var(--font-secondary);
        font-style: italic;
        letter-spacing: 0.1em;
        font-size: 2rem;
        text-align: center;
        display: flex;
        align-items: center;
        gap: 1rem;
        &::before,
        &::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: var(--c-text-primary);
        }
        &::before { margin-inline-start: 4rem; }
        &::after  { margin-inline-end: 4rem; }
    }
    .hero__text {
        text-align: center;
        letter-spacing: 0.05em;
        line-height: 1.25;
        color: var(--c-text-muted);
        max-width: 715px;
        font-size: 1.25rem;
        margin: 0 auto;
    }
</style>

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