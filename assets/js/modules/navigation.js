document.addEventListener('DOMContentLoaded', () => {
    const menu = document.querySelector('.menu');
    const menuButton = document.querySelector('.hamburger-toggle');
    const menuButtonImg = document.querySelector('.hamburger-toggle-img');

    const hamburgerSrc = menuButtonImg.src; 
    const closeSrc = hamburgerSrc.replace('hamburger.svg', 'x.svg');

    function updateNavHeight() {
        const height = menu.offsetHeight;
        document.documentElement.style.setProperty('--dynamic-nav-height', `${height}px`);
    }

    updateNavHeight(); // tylko przy załadowaniu strony

    if (menuButton && menu) {
        menuButton.addEventListener('click', function () {
            const isOpen = menu.classList.toggle('is-open');
            menuButtonImg.src = isOpen ? closeSrc : hamburgerSrc;
        });
    }
});