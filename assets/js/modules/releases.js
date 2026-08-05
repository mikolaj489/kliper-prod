document.addEventListener('DOMContentLoaded', function () {
    if (typeof AlbumAjax === 'undefined') return;
    const wrapper = document.querySelector('.releases__scroll-wrapper');
    const nav = document.querySelector('.releases__nav');
    const content = document.querySelector('.releases__content');

    // WARUNEK BEZPIECZEŃSTWA: Jeśli brak głównego kontenera na stronie, przerwij wykonywanie
    if (!wrapper || !content) return;

    // --- OBSŁUGA PRZYCISKÓW KARUZELI ---
    (function () {
        const btnNext = document.querySelector('.carousel__btn--next');
        const btnPrev = document.querySelector('.carousel__btn--prev');

        function getCardWidth() {
            const card = document.querySelector('.album-card');
            if (!card) return 300;
            const gap = 48;
            return card.offsetWidth + gap;
        }

        // Dodajemy eventy tylko wtedy, gdy przyciski naprawdę istnieją na stronie
        if (btnNext) {
            btnNext.addEventListener('click', () => {
                wrapper.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
            });
        }

        if (btnPrev) {
            btnPrev.addEventListener('click', () => {
                wrapper.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
            });
        }
    })();

    // --- OBSŁUGA NAWIGACJI I OVERFLOW ---
    function checkNav() {
        const hasCards = !!content.querySelector('.album-card');
        const hasOverflow = wrapper.scrollWidth > wrapper.clientWidth;

        if (!hasCards || !hasOverflow) {
            if (nav) nav.classList.add('releases__nav--hidden');
            wrapper.style.justifyContent = 'center';
            wrapper.style.overflowX = 'visible';
            content.style.marginInlineStart = '0';
            content.classList.add('releases__after--hidden');
        } else {
            if (nav) nav.classList.remove('releases__nav--hidden');
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
