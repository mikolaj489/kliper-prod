export function initGallery() {
    const wrapper = document.querySelector('.cfg');
    if (!wrapper) return;

    const yearBtns = wrapper.querySelectorAll('.cfg__year-btn');
    const albumContents = wrapper.querySelectorAll('.cfg__album-content');
    const galleryBtns = wrapper.querySelectorAll('.cfg__gallery-btn');
    const galleryItems = wrapper.querySelectorAll('.cfg__gallery-item');

    // 1. Kliknięcie w ROK
    yearBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const isAlreadyActive = this.classList.contains('cfg__year-btn--active');
            const targetId = this.getAttribute('data-target');

            // Reset stanu
            yearBtns.forEach(b => b.classList.remove('cfg__year-btn--active'));
            albumContents.forEach(c => c.classList.remove('cfg__album-content--active'));
            galleryItems.forEach(item => item.classList.remove('cfg__gallery-item--active'));
            galleryBtns.forEach(b => b.classList.remove('cfg__gallery-btn--active'));

            if (!isAlreadyActive) {
                this.classList.add('cfg__year-btn--active');
                const targetAlbum = wrapper.querySelector('#' + targetId);
                if (targetAlbum) {
                    targetAlbum.classList.add('cfg__album-content--active');
                }
            }
        });
    });

    // 2. Kliknięcie w ALBUM
    galleryBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const galleryId = this.getAttribute('data-gallery-id');

            const parentAlbum = this.closest('.cfg__album-content');
            if (parentAlbum) {
                parentAlbum.querySelectorAll('.cfg__gallery-btn').forEach(b => b.classList.remove('cfg__gallery-btn--active'));
            }
            this.classList.add('cfg__gallery-btn--active');

            galleryItems.forEach(item => {
                if (item.id === 'cfg-gallery-item-' + galleryId) {
                    item.classList.add('cfg__gallery-item--active');
                } else {
                    item.classList.remove('cfg__gallery-item--active');
                }
            });

            if (history.pushState) {
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?g_id=' + galleryId;
                window.history.pushState({ path: newUrl }, '', newUrl);
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initGallery();
});