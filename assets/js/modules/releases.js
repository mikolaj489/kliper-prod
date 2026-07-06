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
            content.classList.remove('releases__after--hidden');
        }
    }
    checkNav();
    window.addEventListener('resize', checkNav);
    const observer = new MutationObserver(checkNav);
    observer.observe(content, { childList: true, subtree: true });
});