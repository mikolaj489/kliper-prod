document.addEventListener('DOMContentLoaded', function () {
    const goTop = document.querySelector('.go-top');
    const footer = document.querySelector('.global-footer'); // dostosuj selektor
    const titleTrigger = document.querySelector('.section__title--first') 
        || document.querySelector('.section__title');

    if (!goTop || !footer || !titleTrigger) return;

    const titleObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    goTop.classList.remove('is-visible');
                } else {
                    goTop.classList.add('is-visible');
                }
            });
        },
        { threshold: 0 }
    );
    titleObserver.observe(titleTrigger);

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


    goTop.addEventListener('click', function () {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });
});