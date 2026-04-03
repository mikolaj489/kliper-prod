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
        display: flex;
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
        &::after {
            content: '';
            min-width: 1px;
            display: block;
            height: 100px
        }
         &.releases__after--hidden::after {
            content: none; 
        }
        &:not(:has(.album-card)) {
             gap: 0;
        }
    }
    .releases__nav {
        display: flex;
        justify-content: center;
        gap: .7rem;
        margin-block-start: 2rem;
    }
    .releases__nav--hidden {
        display: none;
    }
    .carousel__btn {
        width: 55px; height: 55px;
        font-size: 24px;
        cursor: pointer;
        background-color: #414750;
        color: #919191;
        border: 2px solid transparent;
        border-radius: 50%;
        align-self: center;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: border, stroke-width  .3s;
        stroke-width: 2;
        z-index: 2;
        margin-inline: calc(var(--sides) / 2 );
        &:hover {
            stroke-width: 2.5;
            border: 2px solid #919191;
        }
       &:active {
            transform: scale(.97);
        }
        &:disabled {
            opacity: 0.3;
            pointer-events: none;
        }
    }
    .carousel__btn--next {
        justify-self: end;
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
        <button class="carousel__btn carousel__btn--prev" aria-label="Poprzednie wydanie">
             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <button class="carousel__btn carousel__btn--next" aria-label="Następne wydanie">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
</section>

<script>
    const wrapper = document.querySelector('.releases__scroll-wrapper');

    (function () {
        const btnNext = document.querySelector('.carousel__btn--next');
        const btnPrev = document.querySelector('.carousel__btn--prev');

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

    document.addEventListener('DOMContentLoaded', function () {
        const nav = document.querySelector('.releases__nav');
        const content = document.querySelector('.releases__content');

        function checkNav() {
            const hasCards = !!content.querySelector('.album-card');
            const hasOverflow = wrapper.scrollWidth > wrapper.clientWidth;

            if (!hasCards || !hasOverflow) {
                nav.classList.add('releases__nav--hidden');
                wrapper.style.justifyContent = 'center';
                wrapper.style.overflowX = 'visible';
                content.style.marginInlineStart = '0';
                content.classList.add('releases__after--hidden');
            } else {
                nav.classList.remove('releases__nav--hidden');
                wrapper.style.justifyContent = 'left';
                wrapper.style.overflowX = 'auto';
                content.style.marginInlineStart = '3rem';
                content.classList.remove('releases__after--hidden');
            }
        }
        // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ zamist tego
        // const noScroll = !hasCards || !hasOverflow;
        // nav.classList.toggle('releases__nav--hidden', noScroll);
        // content.classList.toggle('releases__after--hidden', noScroll);
        // Object.assign(wrapper.style, {
        //     justifyContent: noScroll ? 'center' : 'left',
        //     overflowX:      noScroll ? 'visible' : 'auto',
        // });
        // content.style.marginInlineStart = noScroll ? '0' : '3rem';


        checkNav();
        window.addEventListener('resize', checkNav);

        const observer = new MutationObserver(checkNav);
        observer.observe(content, { childList: true, subtree: true });
    });
</script>