export function initAlbumControls({ wrapper, albumContents, galleryBtns, loadGallery, hideGalleries }) {
    wrapper.querySelectorAll('.cfg__album-expand').forEach(button => {
        button.addEventListener('click', () => {
            const album = button.closest('.cfg__album-content');
            const expanded = album.classList.toggle('cfg__album-content--expanded');
            button.setAttribute('aria-expanded', String(expanded));
            button.setAttribute('aria-label', expanded ? 'Zwiń listę albumów' : 'Rozwiń listę albumów');
        });
    });

    wrapper.querySelectorAll('.cfg__year-btn').forEach(button => {
        button.addEventListener('click', () => {
            wrapper.querySelectorAll('.cfg__year-btn').forEach(item => item.classList.remove('cfg__year-btn--active'));
            albumContents.forEach(item => item.classList.remove('cfg__album-content--active'));
            galleryBtns.forEach(item => item.classList.remove('cfg__gallery-btn--active'));
            button.classList.add('cfg__year-btn--active');
            document.getElementById(button.dataset.target)?.classList.add('cfg__album-content--active');
            hideGalleries();
        });
    });

    galleryBtns.forEach(button => {
        button.addEventListener('click', async () => {
            const album = button.closest('.cfg__album-content');
            album?.querySelectorAll('.cfg__gallery-btn').forEach(item => item.classList.remove('cfg__gallery-btn--active'));
            button.classList.add('cfg__gallery-btn--active');
            await loadGallery(button.dataset.galleryId);
        });
    });
}
