<style>
    .releases {
        padding-inline: 0;
        background-color: var(--c-primary);
        margin-block-start: calc(var(--sand-effect-height) * -1);
        padding-block-start: var(--sand-effect-height);
        position: relative;
        &::after {
            content: '';
            position: absolute;
            top: 0%;
            left: 0;
            width: 100%;
            height: 50px;
            background-color: var(--c-bg);
            box-shadow: 0 0 120px 155px #F0EBD8;
        }
    }
    .releases__scroll-wrapper {
        overflow-x: auto;
        padding-block: 20px; 
        margin-block: -20px; 
    }
    .releases__content {
        display: flex;
        align-items: center;
        gap: 3rem;
        margin-inline-start: 3rem;
        &::after {
            content: '';
            min-width: 1px;
            display: block;
            height: 100px
        }
    }
</style>

<section class="releases container">
    <h1 class="section-title">Wydania</h1>
    <div class="releases__scroll-wrapper">
        <div class="releases__content">
            <?php get_template_part('parts/album_card'); ?>
        </div>
    </div>
</section>