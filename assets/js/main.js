// Stan karuzeli
let allCards = [];
let currentIndex = 0;
let cachedHTML = {}; // Cache dla załadowanych HTML-i

async function fetchCardHTML(albumId) {
    if (cachedHTML[albumId]) return cachedHTML[albumId]; // Zwróć z cache jeśli już załadowany

    const fd = new FormData();
    fd.append('action',   'get_album_detail');
    fd.append('nonce',    AlbumAjax.nonce);
    fd.append('album_id', albumId);
    const res  = await fetch(AlbumAjax.url, { method: 'POST', body: fd });
    const data = await res.json();
    const html = data.success ? data.data.html : null;
    if (html) cachedHTML[albumId] = html; // Zapisz do cache
    return html;
}

async function prefetchAllCards() {
    // Ładuj wszystkie albumy równolegle
    await Promise.all(
        allCards.map(({ albumId }) => fetchCardHTML(albumId))
    );
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

function renderCarousel(container) {
    const cards = allCards.map((card, i) => {
        const offset = i - currentIndex;
        if (Math.abs(offset) > 1) return ''; // Pokaż tylko ±1 sąsiada

        const html = cachedHTML[card.albumId] ?? '<div class="carousel__card-placeholder"></div>';
        let className = 'carousel__card';
        if (offset === -1) className += ' carousel__card--prev';
        if (offset === 1)  className += ' carousel__card--next';

        return `<div class="${className}" data-index="${i}">${html}</div>`;
    }).join('');

    container.innerHTML = `
        <div class="carousel">
            <button class="carousel__btn carousel__btn--prev" ${currentIndex === 0 ? 'disabled' : ''}>
                ${iconPrev}
            </button>
            <div class="carousel__track">
                ${cards}
            </div>
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
    renderCarousel(container);
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

    // Pobierz klikniętą kartę + prefetch wszystkich pozostałych równolegle
    const [html] = await Promise.all([
        fetchCardHTML(albumId),
        prefetchAllCards() // Wszystkie inne ładują się w tle
    ]);

    card.classList.remove('album-card--loading');

    if (!html) return;

    const container = card.closest('.releases__content');
    renderCarousel(container, html);
});