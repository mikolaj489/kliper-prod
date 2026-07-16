function initNewsSlider() {
    const slider = document.querySelector('.news__slider');
    const anchor = slider?.querySelector('.news__slider-anchor');
    const cards = Array.from(document.querySelectorAll('.news__card'));

    if (!slider || !anchor || !cards.length) {
        return;
    }

    const updateAnchor = () => {
        const sliderRect = slider.getBoundingClientRect();
        const viewportOffset = window.innerHeight * 0.45;

        let activeCard = null;
        let closestDistance = Infinity;

        cards.forEach((card) => {
            const cardRect = card.getBoundingClientRect();
            const distance = Math.abs(cardRect.top - viewportOffset);

            if (distance < closestDistance) {
                closestDistance = distance;
                activeCard = card;
            }
        });

        // Remove in-view marker from all cards (do not affect expansion)
        cards.forEach((card) => card.classList.remove('news__card--inview'));

        if (!activeCard) {
            return;
        }

        // Mark closest card as in-view for slider UI only
        activeCard.classList.add('news__card--inview');

        const activeRect = activeCard.getBoundingClientRect();
        const topOffset = (activeRect.top - sliderRect.top) + (activeRect.height / 2) - (anchor.offsetHeight / 2);
        const maxTop = Math.max(0, sliderRect.height - anchor.offsetHeight);
        const nextTop = Math.max(0, Math.min(maxTop, topOffset));

        anchor.style.transform = `translateY(${nextTop}px)`;
    };

    updateAnchor();

    window.addEventListener('scroll', updateAnchor, { passive: true });
    window.addEventListener('resize', updateAnchor);
}

document.addEventListener('DOMContentLoaded', initNewsSlider);