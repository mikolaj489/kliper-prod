<style>
    .releases {
        padding-inline: 0;
        background-color: var(--c-primary);
        margin-block-start: calc(var(--sand-effect-height) * -1);
        padding-block-start: var(--sand-effect-height);
        position: relative;
        &::before {
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
        scrollbar-width: none; 
        &::-webkit-scrollbar {
            display: none;
        }
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
    .releases__nav {
        display: none;
        justify-content: center;
        gap: .7rem;
        margin-block-start: 2rem;
    }
    .releases__nav {
        display: none;
    }
    .releases__scroll-wrapper:has(.album-card) ~ .releases__nav {
        display: flex;
    }
    .releases__btn {
        background: transparent;
        border: 2px solid var(--c-secondary);
        color: var(--c-secondary);
        border-radius: 50%;
        width: 42px;
        height: 42px;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.25s ease, color 0.25s ease, transform 0.2s ease;
        &:hover {
            background: var(--c-secondary);
            color: var(--c-primary);
        }
        &:active {
            transform: scale(0.92);
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
    <div class="releases__nav">
        <button class="releases__btn releases__btn--prev" aria-label="Poprzednie wydanie">&#8592;</button>
        <button class="releases__btn releases__btn--next" aria-label="Następne wydanie">&#8594;</button>
    </div>
</section>

<script>
    (function () {
        const wrapper = document.querySelector('.releases__scroll-wrapper');
        const btnNext = document.querySelector('.releases__btn--next');
        const btnPrev = document.querySelector('.releases__btn--prev');

        function getCardWidth() {
            const card = document.querySelector('.album-card');
            if (!card) return 300;
            const gap = 48;
            return card.offsetWidth + gap;
        }

        btnNext.addEventListener('click', () => {
            wrapper.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
        });

        btnPrev.addEventListener('click', () => {
            wrapper.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
        });
    })();
</script>