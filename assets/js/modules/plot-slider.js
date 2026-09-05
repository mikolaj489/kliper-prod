document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.querySelector('.plot__wrapper');
    const trigger = wrapper?.querySelector('.plot__trigger');
    const boxes = Array.from(document.querySelectorAll('.plot__box'));

    if (!wrapper || !boxes.length) {
        return;
    }

    const updateTriggerAndBorders = () => {
        const wrapperRect = wrapper.getBoundingClientRect();
        const viewportOffset = window.innerHeight * 0.45;

        let activeBox = null;
        let closestDistance = Infinity;

        // Szukamy najbliższego .plot__box względem środka ekranu
        boxes.forEach((box) => {
            const boxRect = box.getBoundingClientRect();
            const distance = Math.abs(boxRect.top + (boxRect.height / 2) - viewportOffset);

            if (distance < closestDistance) {
                closestDistance = distance;
                activeBox = box;
            }
        });

        // Resetujemy klasę dla wszystkich kart
        boxes.forEach((box) => box.classList.remove('is-active'));

        if (!activeBox) return;

        // Dodajemy klasę is-active do wybranej karty
        activeBox.classList.add('is-active');

        // Przesuwamy .plot__trigger do środka aktywnej karty
        if (trigger) {
            const activeRect = activeBox.getBoundingClientRect();
            const topOffset = (activeRect.top - wrapperRect.top) + (activeRect.height / 2) - (trigger.offsetHeight / 2);
            const maxTop = Math.max(0, wrapperRect.height - trigger.offsetHeight);
            const nextTop = Math.max(0, Math.min(maxTop, topOffset));

            trigger.style.transform = `translate(-50%, ${nextTop}px)`;
        }
    };

    updateTriggerAndBorders();

    window.addEventListener('scroll', updateTriggerAndBorders, { passive: true });
    window.addEventListener('resize', updateTriggerAndBorders);
});