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

function updateDots() {
    document.querySelectorAll('.carousel__dot').forEach((dot, i) => {
        dot.classList.toggle('carousel__dot--active', i === currentIndex);
    });
}

function updateButtons() {
    document.querySelector('.carousel__btn--prev').disabled = currentIndex === 0;
    document.querySelector('.carousel__btn--next').disabled = currentIndex === allCards.length - 1;
}
const iconNext = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>`;
const iconPrev = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>`;

function renderCarousel(container, activeHTML) {
    container.innerHTML = `
        <div class="carousel">
            <button class="carousel__btn carousel__btn--prev" ${currentIndex === 0 ? 'disabled' : ''}>
                ${iconPrev}
            </button>
            <div class="carousel__card">${activeHTML}</div>
            <button class="carousel__btn carousel__btn--next" ${currentIndex === allCards.length - 1 ? 'disabled' : ''}>
                ${iconNext}
            </button>
            <div class="carousel__status">
                <div class="carousel__dots">
                    ${allCards.map((_, i) => `
                        <button class="carousel__dot ${i === currentIndex ? 'carousel__dot--active' : ''}" data-index="${i}"></button>
                    `).join('')}
                </div>
                <button class="carousel__close">Wróć</button>
            </div>
        </div>
    `;
}

async function goTo(index, container) {
    currentIndex = index;
    updateDots();
    updateButtons();
    const html = await fetchCardHTML(allCards[currentIndex].albumId);
    if (html) {
        document.querySelector('.carousel__card').innerHTML = html;
    }
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