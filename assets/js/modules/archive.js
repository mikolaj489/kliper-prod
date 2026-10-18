document.addEventListener('click', (event) => {
    if (!(event.target instanceof Element)) return;

    const link = event.target.closest('.event-link');
    if (link) {
        event.preventDefault();
        const modalId = link.dataset.modalId;
        const modal = modalId ? document.getElementById(modalId) : null;

        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        return;
    }

    const closeButton = event.target.closest('.modal-box__close');
    if (closeButton) {
        const modal = closeButton.closest('.modal-box');
        if (modal) closeModal(modal);
        return;
    }

    if (event.target.classList.contains('modal-box')) {
        closeModal(event.target);
    }
});

function closeModal(modalElement) {
    modalElement.style.display = 'none';
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
    if (typeof GLightbox === 'undefined') return;
    const lightbox = GLightbox({
        selector: '.glightbox',
        touchNavigation: true,
        loop: true,
        closeOnOutsideClick: false,
        openEffect: 'none',
        closeEffect: 'fade',
        slideEffect: 'slide',
    });

    let thumbnails = null;
    let thumbnailControls = null;

    function updateActiveThumbnail(index) {
        if (!thumbnails) return;

        thumbnails.querySelectorAll('button').forEach((button, buttonIndex) => {
            const isActive = buttonIndex === index;
            button.classList.toggle('is-active', isActive);

            if (isActive) {
                button.setAttribute('aria-current', 'true');
                button.scrollIntoView({ behavior: 'auto', block: 'nearest', inline: 'center' });
            } else {
                button.removeAttribute('aria-current');
            }
        });
    }

    function renderThumbnails() {
        const container = document.querySelector('.glightbox-container');
        const images = Array.from(document.querySelectorAll('.glightbox[data-gallery="archive-gallery"]'));

        if (!container || images.length < 2) return;

        thumbnailControls = document.createElement('div');
        thumbnailControls.className = 'archive-gallery-controls';

        const previousButton = document.createElement('button');
        previousButton.type = 'button';
        previousButton.className = 'archive-gallery-controls__arrow';
        previousButton.dataset.direction = '-1';
        previousButton.setAttribute('aria-label', 'Poprzednie zdjęcie');
        previousButton.innerHTML = '&#8249;';

        const nextButton = document.createElement('button');
        nextButton.type = 'button';
        nextButton.className = 'archive-gallery-controls__arrow';
        nextButton.dataset.direction = '1';
        nextButton.setAttribute('aria-label', 'Następne zdjęcie');
        nextButton.innerHTML= '&#8250;';

        thumbnails = document.createElement('div');
        thumbnails.className = 'archive-gallery-thumbnails';
        thumbnails.setAttribute('aria-label', 'Miniatury zdjęć');

        images.forEach((link, index) => {
            const image = link.querySelector('img');
            const button = document.createElement('button');
            const thumbnail = document.createElement('img');

            button.type = 'button';
            button.setAttribute('aria-label', `Pokaż zdjęcie ${index + 1}`);
            button.dataset.index = index;
            thumbnail.src = image ? (image.currentSrc || image.src) : link.href;
            thumbnail.alt = image ? image.alt : '';
            thumbnail.loading = 'lazy';
            button.appendChild(thumbnail);
            thumbnails.appendChild(button);
        });

        thumbnailControls.append(previousButton, thumbnails, nextButton);
        thumbnailControls.addEventListener('click', (event) => {
            const thumbnail = event.target.closest('button[data-index]');
            const arrow = event.target.closest('button[data-direction]');

            if (thumbnail || arrow) {
                event.preventDefault();
                event.stopPropagation();

                if (thumbnail) {
                    lightbox.goToSlide(Number(thumbnail.dataset.index));
                } else {
                    const direction = Number(arrow.dataset.direction);
                    const currentIndex = lightbox.getActiveSlideIndex();
                    lightbox.goToSlide((currentIndex + direction + images.length) % images.length);
                }
            }
        });

        container.classList.add('has-archive-thumbnails');
        container.appendChild(thumbnailControls);
        updateActiveThumbnail(lightbox.getActiveSlideIndex());
    }

    lightbox.on('open', renderThumbnails);
    lightbox.on('slide_changed', ({ current }) => {
        if (current) updateActiveThumbnail(current.index);
    });
    lightbox.on('close', () => {
        if (thumbnailControls) thumbnailControls.remove();
        thumbnails = null;
        thumbnailControls = null;
        document.querySelector('.glightbox-container')?.classList.remove('has-archive-thumbnails');
    });

});