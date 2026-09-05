document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.plot__wrapper');
    const path = wrapper?.querySelector('.plot__line-path');

    if (!wrapper || !path) {
        return;
    }

    // 1. Pobieramy całkowitą długość ścieżki SVG
    const pathLength = path.getTotalLength();

    // 2. Przygotowujemy ścieżkę do ukrycia
    path.style.strokeDasharray = `${pathLength} ${pathLength}`;
    path.style.strokeDashoffset = pathLength; // Pełne przesunięcie = ścieżka ukryta

    const drawLineOnScroll = () => {
        const wrapperRect = wrapper.getBoundingClientRect();
        const windowHeight = window.innerHeight;

        // 3. Obliczamy punkt startu i końca rysowania
        const startDrawingPoint = windowHeight * 0.8; // Zaczyna rysować, gdy góra wrappera jest 80% od góry okna
        const endDrawingPoint = windowHeight * 0.2;   // Kończy, gdy dół jest 20% od góry

        const totalDrawZone = startDrawingPoint - endDrawingPoint;
        const currentRelativePosition = wrapperRect.top - endDrawingPoint;

        // 4. Kalkulacja postępu (wartość od 0 do 1)
        let progress = 1 - (currentRelativePosition / totalDrawZone);
        
        // Ograniczamy do przedziału 0-1
        progress = Math.max(0, Math.min(1, progress));

        // 5. Obliczamy nowe przesunięcie. 
        // Ponieważ path w SVG rysowana jest "M5 1000 L5 0" (z dołu do góry), 
        // odejmowanie postępu od pełnej długości da efekt rysowania od dołu.
        const drawOffset = pathLength - (progress * pathLength);

        path.style.strokeDashoffset = drawOffset;
    };

    // Listenery
    window.addEventListener('scroll', drawLineOnScroll, { passive: true });
    window.addEventListener('resize', () => {
        // Przy zmianie rozmiaru okna musimy przeliczyć długość ścieżki
        const newLength = path.getTotalLength();
        path.style.strokeDasharray = `${newLength} ${newLength}`;
        drawLineOnScroll();
    });

    // Inicjalizacja na starcie
    drawLineOnScroll();
});