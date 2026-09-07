document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.plot__wrapper');
    const path = wrapper?.querySelector('.plot__line-path');
    const iconPaths = Array.from(document.querySelectorAll('.plot__icon path'));

iconPaths.forEach((iconPath) => {
    const pathLength = iconPath.getTotalLength();
    const drawSpeed = 1500; 

    const duration = pathLength / drawSpeed;

    iconPath.style.setProperty('--plot-icon-length', `${pathLength}`);
    iconPath.style.setProperty('--plot-icon-duration', `${duration}s`);
});

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

        const startDrawingPoint = windowHeight * 0.8; 
        const endDrawingPoint = windowHeight * 0.2;  

        const totalDrawZone = startDrawingPoint - endDrawingPoint;
        const currentRelativePosition = wrapperRect.top - endDrawingPoint;

        let progress = 1 - (currentRelativePosition / totalDrawZone);
        
        progress = Math.max(0, Math.min(1, progress));
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