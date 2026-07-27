console.log('NEWS_SLIDER');

document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.news__slider');
    const anchor = slider?.querySelector('.news__slider-anchor');
    const cards = Array.from(document.querySelectorAll('.news__card'));

    // ZABEZPIECZENIE: Jeśli brak suwaka, anchora lub kart na stronie – przerywamy
    if (!slider || !anchor || !cards.length) {
        return;
    }

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

        // Podświetlenie najbliższej karty
        activeCard.classList.add('news__card--inview');

        // Kalkulacja pozycji translateY dla anchora
        const activeRect = activeCard.getBoundingClientRect();
        const topOffset = (activeRect.top - sliderRect.top) + (activeRect.height / 2) - (anchor.offsetHeight / 2);
        const maxTop = Math.max(0, sliderRect.height - anchor.offsetHeight);
        const nextTop = Math.max(0, Math.min(maxTop, topOffset));

        anchor.style.transform = `translateY(${nextTop}px)`;
    };

    // Listenery globalne
    updateAnchor();

    window.addEventListener('scroll', updateAnchor, { passive: true });
    window.addEventListener('resize', updateAnchor);

    // Reakcja na kliknięcie rozwijania karty z drugiego skryptu
    window.addEventListener('newsCardToggled', () => {
        setTimeout(updateAnchor, 300); // Czas dopasowany do transition w CSS
    });
});