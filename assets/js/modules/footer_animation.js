document.addEventListener('DOMContentLoaded', () => {
    const wheel = document.querySelector('.footer__wheel');
    if (!wheel) return;
    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;
        const rotationAngle = scrollPosition / 10; 
        wheel.style.transform = `rotate(${rotationAngle}deg)`;
    }, { passive: true });
});