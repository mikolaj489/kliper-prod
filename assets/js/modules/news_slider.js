function initNewsSlider() {
    const slider = document.querySelector('.news__slider');
    const anchor = slider?.querySelector('.news__slider-anchor');
    const cards = Array.from(document.querySelectorAll('.news__card[data-post-id]'));

    if (!slider || !anchor || !cards.length) return;

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

        cards.forEach((card) => card.classList.remove('news__card--inview'));

        if (!activeCard) return;

        activeCard.classList.add('news__card--inview');

        const activeRect = activeCard.getBoundingClientRect();
        const topOffset = (activeRect.top - sliderRect.top) + (activeRect.height / 2) - (anchor.offsetHeight / 2);
        const maxTop = Math.max(0, sliderRect.height - anchor.offsetHeight);
        const nextTop = Math.max(0, Math.min(maxTop, topOffset));

        anchor.style.transform = `translateY(${nextTop}px)`;
    };

    const setAllContentHeights = () => {
        cards.forEach((card) => {
            const content = card.querySelector('.news__card-content');
            if (content) {
                content.style.setProperty('--content-height', `${content.scrollHeight}px`);
            }
        });

        updateAnchor();
    };
    cards.forEach((card) => {
        const button = card.querySelector('.news__card-toggle');
        if (!button) return;

        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const isExpanding = !card.classList.contains('news__card--expanded');

            cards.forEach((otherCard) => {
                if (otherCard !== card) {
                    otherCard.classList.remove('news__card--expanded');
                    otherCard.setAttribute('aria-expanded', 'false');
                    const otherButton = otherCard.querySelector('.news__card-toggle');
                    if (otherButton) {
                        otherButton.setAttribute('aria-expanded', 'false');
                        otherButton.textContent = 'Czytaj więcej';
                    }
                }
            });

            card.classList.toggle('news__card--expanded', isExpanding);
            card.setAttribute('aria-expanded', isExpanding ? 'true' : 'false');
            button.setAttribute('aria-expanded', isExpanding ? 'true' : 'false');
            button.textContent = isExpanding ? 'Zwiń' : 'Czytaj więcej';

            updateAnchor();
            setTimeout(updateAnchor, 300); 
        });
    });
    setAllContentHeights();

    window.addEventListener('scroll', updateAnchor, { passive: true });
    window.addEventListener('resize', () => {
        setAllContentHeights();
    });
}
document.addEventListener('DOMContentLoaded', initNewsSlider);