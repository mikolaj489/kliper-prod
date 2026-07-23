document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.news__slider');
    const anchor = slider?.querySelector('.news__slider-anchor');
    // Wybieramy wszystkie karty (również Archiwum), aby suwak poprawnie reagował na scroll
    const cards = Array.from(document.querySelectorAll('.news__card'));

    if (!slider || !anchor || !cards.length) {
        return;
    }

    // --- Funkcje pomocnicze ---

    // Oblicza i ustawia wysokość ukrytej treści (dla płynnej animacji CSS)
    const setContentHeight = (card) => {
        const content = card.querySelector('.news__card-content');
        if (!content) return;
        
        const contentHeight = content.scrollHeight;
        content.style.setProperty('--content-height', `${contentHeight}px`);
    };

    // Aktualizuje pozycję wskaźnika (anchor) na osi czasu/suwaka
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

        // Resetowanie klasy podświetlenia slidera
        cards.forEach((card) => card.classList.remove('news__card--inview'));

        if (!activeCard) return;

        // Podświetlenie najbliższej karty (w tym Archiwum)
        activeCard.classList.add('news__card--inview');

        // Kalkulacja pozycji translateY dla anchora
        const activeRect = activeCard.getBoundingClientRect();
        const topOffset = (activeRect.top - sliderRect.top) + (activeRect.height / 2) - (anchor.offsetHeight / 2);
        const maxTop = Math.max(0, sliderRect.height - anchor.offsetHeight);
        const nextTop = Math.max(0, Math.min(maxTop, topOffset));

        anchor.style.transform = `translateY(${nextTop}px)`;
    };

    // --- Inicjalizacja kart i eventów ---

    cards.forEach((card) => {
        const button = card.querySelector('.news__card-toggle');
        
        // Ustawienie początkowej wysokości kontentu (jeśli istnieje)
        setContentHeight(card);

        // Jeśli karta nie ma przycisku rozwijania (np. Archiwum), pomijamy przypisywanie click eventu
        if (!button) return;

        // Obsługa kliknięcia "Czytaj więcej" / "Zwiń"
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

            // Po zmianie wysokości karty aktualizujemy pozycję anchora
            setTimeout(updateAnchor, 300); // Czas dopasowany do transition w CSS (np. 0.3s)
        });
    });

    // --- Listenery globalne ---

    // Pierwsze uruchomienie po załadowaniu
    updateAnchor();

    // Scroll obsługuje pozycjonowanie anchora
    window.addEventListener('scroll', updateAnchor, { passive: true });

    // Zmiana rozmiaru okna aktualizuje wysokości rozwijanych kart oraz pozycję anchora
    window.addEventListener('resize', () => {
        cards.forEach(setContentHeight);
        updateAnchor();
    });
});