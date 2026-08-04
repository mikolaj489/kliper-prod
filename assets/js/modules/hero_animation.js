console.log('HERO_ANIMATION');

document.addEventListener('DOMContentLoaded', () => {
    const { slogans = [], icons = [] } = window.HeroAnimationData || {};

    const blobMain = document.querySelector('.blob--main');
    const slogan = document.querySelector('.blob__slogan');
    const blobImgs = document.querySelectorAll('.blob--1 img, .blob--2 img, .blob--3 img, .blob--4 img, .blob--5 img, .blob--6 img, .blob--7 img');

    if (!blobMain || !slogan || blobImgs.length === 0 || slogans.length === 0) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let currentSlogan = 0;
    let changeTimer = null;

    function shuffleArray(arr) {
        const a = [...arr];
        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }
        return a;
    }

    function readTimingFromCSS() {
        const cs = getComputedStyle(blobMain);
        const cycleSeconds = parseFloat(cs.getPropertyValue('--blob-cycle-seconds')) || 8;
        const swapPoint = parseFloat(cs.getPropertyValue('--blob-swap-point')) || 0.9;
        return cycleSeconds * 1000 * swapPoint;
    }

    function swapContent() {
        currentSlogan = (currentSlogan + 1) % slogans.length;
        slogan.textContent = slogans[currentSlogan];

        const newIcons = shuffleArray(icons);
        blobImgs.forEach((img, i) => {
            if (newIcons[i]) img.src = newIcons[i];
        });
    }

    function scheduleChange() {
        clearTimeout(changeTimer);
        const changeAt = readTimingFromCSS();

        changeTimer = setTimeout(() => {
            blobMain.classList.add('is-swapping');

            const onFadeOut = (e) => {
                if (e.target !== slogan) return;
                slogan.removeEventListener('transitionend', onFadeOut);
                swapContent();
                blobMain.classList.remove('is-swapping');
            };
            slogan.addEventListener('transitionend', onFadeOut);
        }, changeAt);
    }

    if (prefersReducedMotion) {
        setInterval(swapContent, 6000);
        return;
    }

    // KLUCZOWA POPRAWKA:
    // Nie odpalamy scheduleChange() od razu na DOMContentLoaded, bo w tym momencie
    // animacja CSS jeszcze realnie nie wystartowała (przeglądarka czeka na paint/layout).
    // Synchronizujemy się do faktycznego startu animacji przez event 'animationstart',
    // dzięki czemu pierwszy cykl liczy się od tego samego punktu w czasie co CSS.
    blobMain.addEventListener('animationstart', function onFirstStart() {
        blobMain.removeEventListener('animationstart', onFirstStart);
        scheduleChange();
    });

    blobMain.addEventListener('animationiteration', scheduleChange);
});