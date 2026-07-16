document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.news__card[data-post-id]');

    cards.forEach((card) => {
        const button = card.querySelector('.news__card-toggle');

        if (!button) return;

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
