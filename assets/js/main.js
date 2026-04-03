// Stan karuzeli
let allCards = [];
let currentIndex = 0;
let cachedHTML = {};

function getDominantColor(imgElement) {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = 80; canvas.height = 80;
    ctx.drawImage(imgElement, 0, 0, 80, 80);
    const data = ctx.getImageData(0, 0, 80, 80).data;
    const buckets = {};
    for (let i = 0; i < data.length; i += 4) {
        if (data[i + 3] < 128) continue;
        const r = Math.round(data[i] / 32) * 32;
        const g = Math.round(data[i + 1] / 32) * 32;
        const b = Math.round(data[i + 2] / 32) * 32;
        const key = `${r},${g},${b}`;
        buckets[key] = (buckets[key] || 0) + 1;
    }

    const sorted = Object.entries(buckets).sort((a, b) => b[1] - a[1]);

    const minBrightness = 80;  // minimalna jasność (0-255), podnieś jeśli za ciemne
    const minSaturation = 40;  // minimalne nasycenie, żeby unikać szarości/brązów

    function getBrightness(r, g, b) {
        return 0.299 * r + 0.587 * g + 0.114 * b;
    }

    function getSaturation(r, g, b) {
        const max = Math.max(r, g, b);
        const min = Math.min(r, g, b);
        if (max === 0) return 0;
        return ((max - min) / max) * 255;
    }

    // Szukaj pierwszego koloru który jest jasny i nasycony
    for (const [key] of sorted) {
        const [r, g, b] = key.split(',').map(Number);
        if (getBrightness(r, g, b) >= minBrightness && getSaturation(r, g, b) >= minSaturation) {
            return { r, g, b };
        }
    }

    // Fallback — jeśli żaden nie spełnia kryteriów, weź najjaśniejszy
    const fallback = sorted.sort((a, b) => {
        const [ar, ag, ab] = a[0].split(',').map(Number);
        const [br, bg, bb] = b[0].split(',').map(Number);
        return getBrightness(br, bg, bb) - getBrightness(ar, ag, ab);
    })[0][0].split(',').map(Number);

    return { r: fallback[0], g: fallback[1], b: fallback[2] };
}
function applyDescriptionToggle(container) {
    const descriptions = container.querySelectorAll('.album-card__description--expanded');
    descriptions.forEach(desc => {
        const p = desc.querySelector('.album-card__description-text');
        const toggle = desc.querySelector('.album-card__description-toggle');
        if (!p || !toggle) return;

        // Poczekaj na następną klatkę żeby DOM był wyrenderowany
        requestAnimationFrame(() => {
            if (p.scrollHeight > p.clientHeight + 2) {
                toggle.classList.add('album-card__description-toggle--visible');
            }
        });

        toggle.onclick = () => {
            const expanded = toggle.dataset.expanded === 'true';
            if (!expanded) {
                p.style.webkitLineClamp = 'unset';
                toggle.textContent = 'Zwiń';
                toggle.dataset.expanded = 'true';
            } else {
                p.style.webkitLineClamp = '';
                toggle.textContent = 'Czytaj więcej';
                toggle.dataset.expanded = 'false';
            }
        };
    });
}
function applyAlbumShadow(container) {
    const imgs = container.querySelectorAll('.album-card__cover--expanded');
    imgs.forEach(img => {
        const apply = () => {
            const { r, g, b } = getDominantColor(img);
            img.style.boxShadow = `
                4px 4px 12px rgba(0,0,0,0.3),
                16px 30px 40px rgba(${r}, ${g}, ${b}, .6),
                -16px -30px 40px rgba(${r}, ${g}, ${b}, .6)
            `;
        };
        if (img.complete) apply();
        else img.addEventListener('load', apply);
    });
    applyDescriptionToggle(container);
}

async function fetchCardHTML(albumId) {
    if (cachedHTML[albumId]) return cachedHTML[albumId];
    const fd = new FormData();
    fd.append('action',   'get_album_detail');
    fd.append('nonce',    AlbumAjax.nonce);
    fd.append('album_id', albumId);
    const res  = await fetch(AlbumAjax.url, { method: 'POST', body: fd });
    const data = await res.json();
    const html = data.success ? data.data.html : null;
    if (html) cachedHTML[albumId] = html;
    return html;
}

async function prefetchAllCards() {
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
        if (Math.abs(offset) > 1) return '';
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

    applyAlbumShadow(container);
}

async function goTo(index, container) {
    currentIndex = index;
    updateDots();
    updateButtons();
    const track = container.querySelector('.carousel__track');
    track.innerHTML = allCards.map((card, i) => {
        const offset = i - currentIndex;
        if (Math.abs(offset) > 1) return '';
        const html = cachedHTML[card.albumId] ?? '<div class="carousel__card-placeholder"></div>';
        let className = 'carousel__card';
        if (offset === -1) className += ' carousel__card--prev';
        if (offset === 1)  className += ' carousel__card--next';
        return `<div class="${className}" data-index="${i}">${html}</div>`;
    }).join('');

    applyAlbumShadow(container);
}

document.addEventListener('click', async (e) => {
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
    const [html] = await Promise.all([
        fetchCardHTML(albumId),
        prefetchAllCards()
    ]);
    card.classList.remove('album-card--loading');
    if (!html) return;

    const container = card.closest('.releases__content');
    renderCarousel(container);
});

document.addEventListener('click', function(e) {
    const toggle = e.target.closest('.album-card__tracks-toggle');
    if (toggle) {
        const expanded = toggle.dataset.expanded === 'true';
        const list = toggle.closest('.album-card__tracks--expanded').querySelector('.album-card__tracks-list');
        const allTracks = list.querySelectorAll('li');
        const limit = 18;
        if (!expanded) {
            allTracks.forEach(li => {
                li.style.display = '';
                li.classList.remove('album-card__track--hidden');
            });
            const rows = Math.ceil(allTracks.length / 2);
            list.style.gridTemplateRows = `repeat(${rows}, auto)`;
            toggle.textContent = 'Zwiń';
            toggle.dataset.expanded = 'true';
        } else {
            allTracks.forEach((li, i) => {
                if (i >= limit) {
                    li.style.display = 'none';
                    li.classList.add('album-card__track--hidden');
                } else {
                    li.style.display = '';
                    li.classList.remove('album-card__track--hidden');
                }
            });
            const rows = Math.ceil(limit / 2);
            list.style.gridTemplateRows = `repeat(${rows}, auto)`;
            toggle.textContent = `+ ${allTracks.length - limit - 1} więcej`;
            toggle.dataset.expanded = 'false';
        }
    }
});