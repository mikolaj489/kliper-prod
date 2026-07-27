console.log('HERO_ANIMATION');

document.addEventListener('DOMContentLoaded', () => {
    // 1. ZABEZPIECZENIE: Pobierz dane oraz elementy, sprawdź czy istnieją na tej podstronie
    const { slogans = [], icons = [] } = window.HeroAnimationData || {};
    
    const blobMain = document.querySelector('.blob--main');
    const slogan = document.querySelector('.blob__slogan');
    const blobImgs = document.querySelectorAll('.blob--1 img, .blob--2 img, .blob--3 img, .blob--4 img, .blob--5 img, .blob--6 img, .blob--7 img');

    // Jeśli brak danych lub elementów Hero – bezpiecznie wyjdź z funkcji
    if (!blobMain || !slogan || blobImgs.length === 0 || slogans.length === 0) {
        return;
    }

    let currentSlogan = 0;

    function shuffleArray(arr) {
        const a = [...arr];
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    }

    const ANIM_DURATION = 8000;
    const CHANGE_AT = ANIM_DURATION * 0.90;
    const FADE_DURATION = 150;

    let changeTimer = null;

    function scheduleChange() {
        clearTimeout(changeTimer);

        changeTimer = setTimeout(() => {
            slogan.style.opacity = '0';
            blobImgs.forEach(img => img.style.opacity = '0');

            setTimeout(() => {
                currentSlogan = (currentSlogan + 1) % slogans.length;
                slogan.textContent = slogans[currentSlogan];

                const newIcons = shuffleArray(icons);
                blobImgs.forEach((img, i) => {
                    if (newIcons[i]) img.src = newIcons[i];
                });

                slogan.style.opacity = '1';
                blobImgs.forEach(img => img.style.opacity = '1');
            }, FADE_DURATION);
        }, CHANGE_AT);
    }

    blobMain.addEventListener('animationiteration', scheduleChange);
    scheduleChange();
});