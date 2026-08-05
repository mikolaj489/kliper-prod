document.addEventListener('DOMContentLoaded', () => {
    const cards = Array.from(document.querySelectorAll('.news__card'));

    // ZABEZPIECZENIE: Jeśli na stronie nie ma żadnych kart, przerywamy
    if (!cards.length) return;

    // Oblicza i ustawia wysokość ukrytej treści (dla płynnej animacji CSS)
    const setContentHeight = (card) => {
        const content = card.querySelector('.news__card-content');
        if (!content) return;
        
        const contentHeight = content.scrollHeight;
        content.style.setProperty('--content-height', `${contentHeight}px`);
    };

    cards.forEach((card) => {
        const button = card.querySelector('.news__card-toggle');
        
        // Ustawienie początkowej wysokości kontentu
        setContentHeight(card);

        // Jeśli karta nie ma przycisku rozwijania (np. Archiwum), pomijamy listener
        if (!button) return;

        button.addEventListener('click', (event) => {
            event.stopPropagation();

            // Zamknięcie pozostałych otwartych kart
            cards.forEach((otherCard) => {
                if (otherCard !== card && otherCard.classList.contains('news__card--expanded')) {
                    otherCard.classList.remove('news__card--expanded');
                    otherCard.setAttribute('aria-expanded', 'false');
                    
                    const otherButton = otherCard.querySelector('.news__card-toggle');
                    if (otherButton) {
                        otherButton.setAttribute('aria-expanded', 'false');
                        otherButton.textContent = 'Czytaj więcej';
                    }
                }
            });

            // Przełączenie stanu obecnej karty
            const isExpanded = card.classList.toggle('news__card--expanded');
            card.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            button.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            button.textContent = isExpanded ? 'Zwiń' : 'Czytaj więcej';

            // Wygłoszenie zdarzenia dla suwaka (aby przeliczył pozycję po rozwinięciu)
            window.dispatchEvent(new CustomEvent('newsCardToggled'));
        });
    });

    // Aktualizacja wysokości przy zmianie rozmiaru okna
    window.addEventListener('resize', () => {
        cards.forEach(setContentHeight);
    });
});