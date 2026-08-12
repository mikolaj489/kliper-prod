document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.shanties-about');
    const line = container?.querySelector('.shanties-about__line');
    const story = document.querySelector('.shanties-story');
    const icons = [...document.querySelectorAll('.shanties-about__icon')];

    if (!line || !container) return;

    const BASE_WIDTH = 1920;
    const MIN_MULT = 3;
    const MAX_MULT = 3.5;

    let maxScroll = 0;
    let multiplier = 1;
    let ticking = false;
    let lineTop = 0;
    let lineHeight = 0;
    let iconPositions = [];

    const getLineSpacing = () => {
        const raw = parseFloat(
            getComputedStyle(line).getPropertyValue('--line-spacing')
        );

        return Number.isNaN(raw) ? 44 : raw;
    };

    const recalcAll = () => {
        maxScroll = document.documentElement.scrollHeight - window.innerHeight;

        const w = window.innerWidth;
        const ratio = w >= BASE_WIDTH ? 0 : 1 - (w / BASE_WIDTH);

        multiplier = Math.min(
            MIN_MULT + ratio * (MAX_MULT - MIN_MULT),
            MAX_MULT
        );

        const containerTop =
            container.getBoundingClientRect().top + window.scrollY;

        const spacing = getLineSpacing();

        lineTop = containerTop + spacing;
        lineHeight = container.getBoundingClientRect().height - spacing;

        iconPositions = icons.map(el => ({
            el,
            top: el.getBoundingClientRect().top + window.scrollY
        }));

        updateLineHeight();
    };

    const updateLineHeight = () => {
        if (maxScroll <= 0) {
            line.style.setProperty('--scroll-progress', '0');

            ticking = false;
            return;
        }

        const progress = Math.min(
            1,
            Math.max(0, window.scrollY / maxScroll) * multiplier
        );

        line.style.setProperty('--scroll-progress', progress);

        const lineEnd = lineTop + progress * lineHeight;

        if (story) {
            const isComplete = lineEnd >= lineTop + lineHeight;
        
            if (isComplete) {
                story.classList.add('is-complete');
            } else {
                story.classList.remove('is-complete');
            }
        }

        iconPositions.forEach(({ el, top }) => {
            el.classList.toggle('is-visible', lineEnd >= top);
        });

        ticking = false;
    };

    const onScroll = () => {
        if (ticking) return;

        ticking = true;

        requestAnimationFrame(updateLineHeight);
    };

    recalcAll();

    window.addEventListener('scroll', onScroll, {
        passive: true
    });

    window.addEventListener('resize', recalcAll);
    window.addEventListener('load', recalcAll);

    new ResizeObserver(recalcAll).observe(document.body);
});