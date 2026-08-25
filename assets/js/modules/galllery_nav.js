export function initGalleryYears({ yearsWrapper, yearsContainer, yearBtns, prevBtn, nextBtn }) {
    if (!yearsContainer || !yearsWrapper || !prevBtn || !nextBtn) return;

    const checkOverflow = () => {
        const hasOverflow = yearsContainer.scrollWidth > yearsContainer.clientWidth;
        const atStart = yearsContainer.scrollLeft <= 5;
        const atEnd = yearsContainer.scrollLeft + yearsContainer.clientWidth >= yearsContainer.scrollWidth - 5;
        yearsWrapper.classList.toggle('cfg__years-wrapper--has-overflow', hasOverflow);
        yearsWrapper.classList.toggle('cfg__years-wrapper--can-scroll-left', hasOverflow && !atStart);
        yearsWrapper.classList.toggle('cfg__years-wrapper--can-scroll-right', hasOverflow && !atEnd);
    };

    const getScrollStep = () => {
        const styles = window.getComputedStyle(yearsContainer);
        const gap = parseFloat(styles.columnGap) || 0;
        const firstWidth = yearBtns[0]?.offsetWidth || 0;
        const secondWidth = yearBtns[1]?.offsetWidth || firstWidth;
        return firstWidth + secondWidth + gap * 2;
    };

    prevBtn.addEventListener('click', () => yearsContainer.scrollBy({ left: -getScrollStep(), behavior: 'smooth' }));
    nextBtn.addEventListener('click', () => yearsContainer.scrollBy({ left: getScrollStep(), behavior: 'smooth' }));
    yearsContainer.addEventListener('scroll', checkOverflow);
    window.addEventListener('resize', checkOverflow);
    checkOverflow();
}
