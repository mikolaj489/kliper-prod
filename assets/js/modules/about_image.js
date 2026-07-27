console.log('ALBUM_IMG');

document.addEventListener('DOMContentLoaded', () => {
    const aboutImage = document.querySelector('.about__image');
    const aboutImageContainer = document.querySelector('.about__image-container');
    
    if (!aboutImage) return;

    const observerOptions = {
        root: null, 
        rootMargin: '0px 0px -40% 0px', 
        threshold: 0 
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                aboutImage.classList.add('is-rotated');
                aboutImageContainer?.classList.add('is-rotated');
            } else {
                aboutImage.classList.remove('is-rotated'); 
                aboutImageContainer?.classList.remove('is-rotated'); 
            }
        });
    }, observerOptions);

    observer.observe(aboutImage);
});