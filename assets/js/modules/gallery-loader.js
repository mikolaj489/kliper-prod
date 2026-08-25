export function createGalleryLoader({ display, loadingElement, errorElement, ajaxUrl, nonce, galleryBtns }) {
    const loadedGalleries = new Map();
    let loadingGalleryId = null;

    function hideAll() {
        display.querySelectorAll('.cfg__gallery-item').forEach(item => item.classList.remove('cfg__gallery-item--active'));
    }

    function show(galleryId) {
        hideAll();
        const item = loadedGalleries.get(String(galleryId));
        if (item) item.classList.add('cfg__gallery-item--active');
    }

    function updateUrl(galleryId) {
        if (!window.history?.pushState) return;
        const url = `${window.location.pathname}?g_id=${encodeURIComponent(galleryId)}`;
        window.history.pushState({ path: url, galleryId }, '', url);
    }

    function initializeFooGallery(item) {
        if (!window.jQuery?.fn?.foogallery) throw new Error('FooGallery JavaScript nie jest dostępny.');
        const gallery = window.jQuery(item).find('[id^="foogallery-gallery-"]');
        if (!gallery.length) throw new Error('Odpowiedź FooGallery nie zawiera galerii.');
        gallery.foogallery();
    }

    async function load(galleryId, galleryTitle = '', updateBrowserUrl = true) {
        galleryId = String(galleryId);
        if (loadedGalleries.has(galleryId)) {
            show(galleryId);
            if (updateBrowserUrl) updateUrl(galleryId);
            return;
        }
        if (loadingGalleryId === galleryId) return;
        hideAll();
        loadingGalleryId = galleryId;
        loadingElement.hidden = false;
        errorElement.hidden = true;
        galleryBtns.forEach(button => { button.disabled = true; });

        try {
            const data = new FormData();
            data.append('action', 'cfg_load_gallery');
            data.append('nonce', nonce);
            data.append('gallery_id', galleryId);
            const response = await fetch(ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' });
            if (!response.ok) throw new Error(`Błąd HTTP: ${response.status}`);
            const result = await response.json();
            if (!result.success || !result.data?.html) throw new Error(result.data?.message || 'Nie udało się załadować galerii.');

            const item = document.createElement('div');
            item.className = 'cfg__gallery-item cfg__gallery-item--active';
            item.id = `cfg-gallery-item-${galleryId}`;
            const title = document.createElement('h2');
            title.className = 'cfg__gallery-title';
            title.textContent = galleryTitle;
            item.append(title);
            const content = document.createElement('div');
            content.innerHTML = result.data.html;
            item.append(content);
            display.appendChild(item);
            loadedGalleries.set(galleryId, item);
            item.classList.add('cfg__gallery-item--active');
            initializeFooGallery(item);
            if (updateBrowserUrl) updateUrl(galleryId);
        } catch (error) {
            errorElement.textContent = error.message || 'Nie udało się załadować galerii.';
            errorElement.hidden = false;
        } finally {
            loadingGalleryId = null;
            loadingElement.hidden = true;
            galleryBtns.forEach(button => { button.disabled = false; });
        }
    }

    return { hideAll, load };
}
