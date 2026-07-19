document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.news__card[data-post-id]');

    const setContentHeight = (card) => {
        const content = card.querySelector('.news__card-content');

        if (!content) return;

        const contentHeight = content.scrollHeight;
        content.style.setProperty('--content-height', `${contentHeight}px`);
    };

    cards.forEach((card) => {
        const button = card.querySelector('.news__card-toggle');

        if (!button) return;

        setContentHeight(card);
        window.addEventListener('resize', () => setContentHeight(card));

        button.addEventListener('click', (event) => {
            event.stopPropagation();

            // Close other expanded cards
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

            const isExpanded = card.classList.toggle('news__card--expanded');
            card.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            button.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            button.textContent = isExpanded ? 'Zwiń' : 'Czytaj więcej';
        });
    });
});
