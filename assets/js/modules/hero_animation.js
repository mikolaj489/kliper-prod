document.addEventListener('DOMContentLoaded', () => {
    const { slogans = [], icons = [] } = window.HeroAnimationData || {};

    const blobMain = document.querySelector('.blob--main');
    const slogan = document.querySelector('.blob__slogan');
    const blobImgs = document.querySelectorAll('.blob--1 img, .blob--2 img, .blob--3 img, .blob--4 img, .blob--5 img, .blob--6 img, .blob--7 img');

    if (!blobMain || !slogan || blobImgs.length === 0 || slogans.length === 0) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const SWAP_FADE_MS = 180;

    let currentSlogan = 0;
    let swapTimer = null;
    let isSwapping = false;

    function shuffleArray(arr) {
        const a = [...arr];

        for (let i = a.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [a[i], a[j]] = [a[j], a[i]];
        }

        return a;
    }

    function swapContent() {
        currentSlogan = (currentSlogan + 1) % slogans.length;
        slogan.textContent = slogans[currentSlogan];

        const newIcons = shuffleArray(icons);

        blobImgs.forEach((img, i) => {
            if (newIcons[i]) {
                img.src = newIcons[i];
            }
        });
    }

    function startSwap() {
        if (isSwapping) {
            return;
        }

        isSwapping = true;
        blobMain.classList.add('is-swapping');

        clearTimeout(swapTimer);

        swapTimer = setTimeout(() => {
            swapContent();
            blobMain.classList.remove('is-swapping');
            isSwapping = false;
        }, SWAP_FADE_MS);
    }

    function getCycleDurationMs() {
        const duration = getComputedStyle(blobMain).animationDuration;

        if (duration.endsWith('s')) {
            return parseFloat(duration) * 1000;
        }

        return parseFloat(duration) || 5000;
    }

    function getSwapWindowFractions() {
        const cs = getComputedStyle(blobMain);

        const start = parseFloat(cs.getPropertyValue('--blob-upward-start'));
        const end = parseFloat(cs.getPropertyValue('--blob-upward-end'));

        return {
            start: Number.isFinite(start) ? start : 0.75,
            end: Number.isFinite(end) ? end : 0.85
        };
    }

    function scheduleSwap() {
        clearTimeout(swapTimer);

        const cycleDurationMs = getCycleDurationMs();
        const { start, end } = getSwapWindowFractions();

        const windowStartMs = cycleDurationMs * start - SWAP_FADE_MS;
        const windowEndMs = cycleDurationMs * end - SWAP_FADE_MS;

        const delay = Math.max(
            0,
            windowStartMs + Math.random() * (windowEndMs - windowStartMs)
        );

        swapTimer = setTimeout(() => {
            startSwap();
        }, delay);
    }

    if (prefersReducedMotion) {
        swapContent();
        return;
    }

    blobMain.classList.add('is-ready');

    blobMain.addEventListener('animationstart', (e) => {
        if (e.animationName !== 'blob-shake') {
            return;
        }

        scheduleSwap();
    });

    blobMain.addEventListener('animationiteration', (e) => {
        if (e.animationName !== 'blob-shake') {
            return;
        }

        scheduleSwap();
    });

    scheduleSwap();

    document.addEventListener('visibilitychange', () => {
        clearTimeout(swapTimer);

        if (document.hidden) {
            return;
        }

        if (isSwapping) {
            swapContent();
            blobMain.classList.remove('is-swapping');
            isSwapping = false;
        }

        swapTimer = setTimeout(() => {
            startSwap();
        }, getCycleDurationMs() * 0.75);
    });
});