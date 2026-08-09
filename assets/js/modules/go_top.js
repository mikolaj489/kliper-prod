document.addEventListener('DOMContentLoaded', function () {
    const goTop = document.querySelector('.go-top');
    const footer = document.querySelector('.global-footer');
    
    // ZMIANA: Zamiast logo, obserwujemy cały kontener hero na stronie
    const heroSection = document.querySelector('.hero') 
        || document.querySelector('.hero-animation__container')
        || document.querySelector('.hero__content');

    if (!goTop) return;

    // --- OBSERWATOR HERO (Pokazywanie przycisku dopiero po zjechaniu niżej) ---
    if (heroSection) {
        const heroObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    // entry.isIntersecting oznacza, że hero JEST widoczne na ekranie
                    if (entry.isIntersecting) {
                        goTop.classList.remove('is-visible');
                    } else {
                        // Dopiero gdy hero CAŁKOWICIE zniknie z widoku, dodaj przycisk
                        goTop.classList.add('is-visible');
                    }
                });
            },
            { 
                threshold: 0, // Wyzwalaj na samej krawędzi elementu
                rootMargin: "-100px 0px 0px 0px" // Opcjonalnie: opóźnia pokazanie o 100px po przewinięciu
            }
        );
        heroObserver.observe(heroSection);
    } else {
        // Zwiększony fallback dla stron bez sekcji hero (np. czysty scroll)
        window.addEventListener('scroll', () => {
            if (window.scrollY > 600) { // Zwiększone z 300 na 600
                goTop.classList.add('is-visible');
            } else {
                goTop.classList.remove('is-visible');
            }
        });
    }

    // --- OBSERWATOR STOPKI ---
    if (footer) {
        const footerObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        goTop.classList.add('is-above-footer');
                    } else {
                        goTop.classList.remove('is-above-footer');
                    }
                });
            },
            { threshold: 0 }
        );
        footerObserver.observe(footer);
    }

    goTop.addEventListener('click', function () {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
});