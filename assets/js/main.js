// Stan karuzeli
let allCards = [];
let currentIndex = 0;

async function fetchCardHTML(albumId) {
    const fd = new FormData();
    fd.append('action',   'get_album_detail');
    fd.append('nonce',    AlbumAjax.nonce);
    fd.append('album_id', albumId);
    const res  = await fetch(AlbumAjax.url, { method: 'POST', body: fd });
    const data = await res.json();
    return data.success ? data.data.html : null;
}

function renderCarousel(container, activeHTML) {
    container.innerHTML = `
        <div class="carousel">
            <button class="carousel__btn carousel__btn--prev" ${currentIndex === 0 ? 'disabled' : ''}>&#8592;</button>
            <div class="carousel__card">${activeHTML}</div>
            <button class="carousel__btn carousel__btn--next" ${currentIndex === allCards.length - 1 ? 'disabled' : ''}>&#8594;</button>
        </div>
        <div class="carousel__status">
            ${allCards.map((_, i) => `
                <button class="carousel__dot ${i === currentIndex ? 'carousel__dot--active' : ''}" data-index="${i}"></button>
            `).join('')}
            <button class="carousel__close">Wróć</button>
        </div>
    `;
}

async function goTo(index, container) {
    currentIndex = index;
    const html = await fetchCardHTML(allCards[currentIndex].albumId);
    if (html) renderCarousel(container, html);
}

document.addEventListener('click', async (e) => {
    // --- ZAMKNIĘCIE ---
    if (e.target.closest('.carousel__close')) {
        window.location.reload();
        return;
    }

    // --- PREV ---
    if (e.target.closest('.carousel__btn--prev')) {
        const container = e.target.closest('.releases__content');
        if (currentIndex > 0) await goTo(currentIndex - 1, container);
        return;
    }

    // --- NEXT ---
    if (e.target.closest('.carousel__btn--next')) {
        const container = e.target.closest('.releases__content');
        if (currentIndex < allCards.length - 1) await goTo(currentIndex + 1, container);
        return;
    }

    // --- DOT ---
    const dot = e.target.closest('.carousel__dot');
    if (dot) {
        const container = dot.closest('.releases__content');
        const index = parseInt(dot.dataset.index);
        if (index !== currentIndex) await goTo(index, container);
        return;
    }

    // --- OTWARCIE ---
    const card = e.target.closest('.album-card:not(.album-card--expanded)');
    if (!card) return;
    const albumId = card.dataset.albumId;
    if (!albumId) return;

    allCards = [...document.querySelectorAll('.album-card')].map(c => ({
        albumId: c.dataset.albumId,
    }));
    currentIndex = allCards.findIndex(c => c.albumId === albumId);

    card.classList.add('album-card--loading');
    const html = await fetchCardHTML(albumId);
    if (!html) {
        card.classList.remove('album-card--loading');
        return;
    }

    const container = card.closest('.releases__content');
    renderCarousel(container, html);
});