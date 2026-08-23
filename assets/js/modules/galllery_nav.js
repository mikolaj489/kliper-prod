export function initGallery() {
    const wrapper = document.querySelector('.cfg');
    if (!wrapper) return;

    // --- OBSŁUGA OVERFLOW I PRZYCISKU PRZEWIJANIA ---
    const yearsWrapper = wrapper.querySelector('.cfg__years-wrapper');
    const yearsContainer = wrapper.querySelector('.cfg__years');
    const yearButtons = wrapper.querySelectorAll('.cfg__year-btn');
    const prevBtn = wrapper.querySelector('.cfg__scroll-btn--prev');
    const nextBtn = wrapper.querySelector('.cfg__scroll-btn--next');

    if (yearsContainer && yearsWrapper && prevBtn && nextBtn) {
        // Funkcja sprawdzająca czy jest overflow
        const checkOverflow = () => {
            const hasOverflow = yearsContainer.scrollWidth > yearsContainer.clientWidth;
            const isScrolledToStart = yearsContainer.scrollLeft <= 5;
            const isScrolledToEnd = yearsContainer.scrollLeft + yearsContainer.clientWidth >= yearsContainer.scrollWidth - 5;

            yearsWrapper.classList.toggle('cfg__years-wrapper--has-overflow', hasOverflow);
            yearsWrapper.classList.toggle('cfg__years-wrapper--can-scroll-left', hasOverflow && !isScrolledToStart);
            yearsWrapper.classList.toggle('cfg__years-wrapper--can-scroll-right', hasOverflow && !isScrolledToEnd);
        };

        const getScrollStep = () => {
            const styles = window.getComputedStyle(yearsContainer);
            const gap = parseFloat(styles.columnGap) || 0;
            const firstButtonWidth = yearButtons[0]?.offsetWidth || 0;
            const secondButtonWidth = yearButtons[1]?.offsetWidth || firstButtonWidth;

            return firstButtonWidth + secondButtonWidth + (gap * 2);
        };

        prevBtn.addEventListener('click', () => {
            yearsContainer.scrollBy({ left: -getScrollStep(), behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            yearsContainer.scrollBy({ left: getScrollStep(), behavior: 'smooth' });
        });

        // Nasłuchiwanie skrolowania oraz zmiany rozmiaru okna
        yearsContainer.addEventListener('scroll', checkOverflow);
        window.addEventListener('resize', checkOverflow);

        // Sprawdź stan na starcie
        checkOverflow();
    }

    // ... reszta Twojego dotychczasowego kodu (yearBtns, galleryBtns) ...
}

document.addEventListener('DOMContentLoaded', () => {
    initGallery();
});