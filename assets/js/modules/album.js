let allCards = [];
let currentIndex = 0;
let cachedHTML = {};
let originalHTML = null; // zapisujemy oryginalny HTML kontenera

// ─── Kolor dominujący ───────────────────────────────────────────────────────

// function getDominantColor(imgElement) {
//     try {
//         const canvas = document.createElement('canvas');
//         const ctx = canvas.getContext('2d');
//         canvas.width = 80;
//         canvas.height = 80;
//         ctx.drawImage(imgElement, 0, 0, 80, 80);
//         const data = ctx.getImageData(0, 0, 80, 80).data;
//         const buckets = {};

//         for (let i = 0; i < data.length; i += 4) {
//             if (data[i + 3] < 128) continue;
//             const r = Math.round(data[i] / 32) * 32;
//             const g = Math.round(data[i + 1] / 32) * 32;
//             const b = Math.round(data[i + 2] / 32) * 32;
//             const key = `${r},${g},${b}`;
//             buckets[key] = (buckets[key] || 0) + 1;
//         }

//         const sorted = Object.entries(buckets).sort((a, b) => b[1] - a[1]);
        
//         if (sorted.length === 0) {
//             console.warn('getDominantColor: no opaque pixels found');
//             return { r: 180, g: 180, b: 200 };
//         }

//         const minBrightness = 80;
//         const minSaturation = 40;

//         function getBrightness(r, g, b) {
//             return 0.299 * r + 0.587 * g + 0.114 * b;
//         }

//         function getSaturation(r, g, b) {
//             const max = Math.max(r, g, b);
//             const min = Math.min(r, g, b);
//             if (max === 0) return 0;
//             return ((max - min) / max) * 255;
//         }

//         // Szukaj koloru spełniającego kryteria
//         for (const [key] of sorted) {
//             const [r, g, b] = key.split(',').map(Number);
//             if (getBrightness(r, g, b) >= minBrightness && getSaturation(r, g, b) >= minSaturation) {
//                 console.log('getDominantColor: found color', { r, g, b });
//                 return { r, g, b };
//             }
//         }

//         // Jeśli żaden kolor nie spełnia, zwróć najjaśniejszy
//         const [r, g, b] = sorted[0][0].split(',').map(Number);
//         console.log('getDominantColor: using brightest fallback', { r, g, b });
//         return { r, g, b };
//     } catch (error) {
//         console.error('getDominantColor error:', error);
//         // Fallback na błąd CORS lub insecure canvas (kolor srebrny)
//         return { r: 180, g: 180, b: 200 };
//     }
// }

// ─── Opis "Czytaj więcej" ───────────────────────────────────────────────────

function applyDescriptionToggle(container) {
    const descriptions = container.querySelectorAll('.album-card__description--expanded');
    descriptions.forEach(desc => {
        const p = desc.querySelector('.album-card__description-text');
        const toggle = desc.querySelector('.album-card__description-toggle');
        if (!p || !toggle) return;

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

// ─── Cień z koloru okładki ──────────────────────────────────────────────────

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

// ─── AJAX ───────────────────────────────────────────────────────────────────

async function fetchCardHTML(albumId) {
    if (cachedHTML[albumId]) return cachedHTML[albumId];
    const fd = new FormData();
    fd.append('action', 'get_album_detail');
    fd.append('nonce', AlbumAjax.nonce);
    fd.append('album_id', albumId);
    const res = await fetch(AlbumAjax.url, { method: 'POST', body: fd });
    const data = await res.json();
    const html = data.success ? data.data.html : null;
    if (html) cachedHTML[albumId] = html;
    return html;
}

async function prefetchAllCards() {
    await Promise.all(allCards.map(({ albumId }) => fetchCardHTML(albumId)));
}

// ─── Karuzela ───────────────────────────────────────────────────────────────

const iconNext = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>`;
const iconPrev = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>`;

function buildTrackHTML() {
    return allCards.map((card, i) => {
        const offset = i - currentIndex;
        if (Math.abs(offset) > 1) return '';
        const html = cachedHTML[card.albumId] ?? '<div class="carousel__card-placeholder"></div>';
        let className = 'carousel__card';
        if (offset === -1) className += ' carousel__card--prev';
        if (offset === 1) className += ' carousel__card--next';
        return `<div class="${className}" data-index="${i}">${html}</div>`;
    }).join('');
}

function buildDotsHTML() {
    return allCards.map((_, i) => `
        <button class="carousel__dot ${i === currentIndex ? 'carousel__dot--active' : ''}" data-index="${i}"></button>
    `).join('');
}

function updateDots(container) {
    container.querySelectorAll('.carousel__dot').forEach((dot, i) => {
        dot.classList.toggle('carousel__dot--active', i === currentIndex);
    });
}

function updateButtons(container) {
    container.querySelector('.carousel__btn--prev').disabled = currentIndex === 0;
    container.querySelector('.carousel__btn--next').disabled = currentIndex === allCards.length - 1;
}

function renderCarousel(container) {
    container.innerHTML = `
        <div class="carousel">
            <div class="carousel__track">
                ${buildTrackHTML()}
            </div>
            <div class="carousel__status">
                <button class="carousel__btn carousel__btn--prev" ${currentIndex === 0 ? 'disabled' : ''}>
                    ${iconPrev}
                </button>
                <div class="carousel__dots">
                    ${buildDotsHTML()}
                </div>
                <button class="carousel__btn carousel__btn--next" ${currentIndex === allCards.length - 1 ? 'disabled' : ''}>
                    ${iconNext}
                </button>
                <button class="carousel__close">Wróć</button>
            </div>
        </div>
    `;

    applyAlbumShadow(container);
}

async function goTo(index, container) {
    currentIndex = index;
    updateDots(container);
    updateButtons(container);
    const track = container.querySelector('.carousel__track');
    track.innerHTML = buildTrackHTML();
    applyAlbumShadow(container);
}

// ─── Tracki "pokaż więcej" ──────────────────────────────────────────────────

function handleTracksToggle(toggle) {
    const expanded = toggle.dataset.expanded === 'true';
    const list = toggle.closest('.album-card__tracks--expanded').querySelector('.album-card__tracks-list');
    const allTracks = list.querySelectorAll('li');
    const limit = 18;

    if (!expanded) {
        allTracks.forEach(li => {
            li.style.display = '';
            li.classList.remove('album-card__track--hidden');
        });
        list.style.gridTemplateRows = `repeat(${Math.ceil(allTracks.length / 2)}, auto)`;
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
        list.style.gridTemplateRows = `repeat(${Math.ceil(limit / 2)}, auto)`;
        toggle.textContent = `+ ${allTracks.length - limit - 1} więcej`;
        toggle.dataset.expanded = 'false';
    }
}

// ─── Główny listener (jeden zamiast dwóch) ──────────────────────────────────

document.addEventListener('click', async (e) => {

    // Zamknięcie karuzeli — przywróć oryginalny HTML zamiast reload()
    if (e.target.closest('.carousel__close')) {
        const container = e.target.closest('.releases__content');
        if (originalHTML !== null) {
            container.innerHTML = originalHTML;
            originalHTML = null;
        }
        return;
    }

    // Poprzedni
    if (e.target.closest('.carousel__btn--prev')) {
        const container = e.target.closest('.releases__content');
        if (currentIndex > 0) await goTo(currentIndex - 1, container);
        return;
    }

    // Następny
    if (e.target.closest('.carousel__btn--next')) {
        const container = e.target.closest('.releases__content');
        if (currentIndex < allCards.length - 1) await goTo(currentIndex + 1, container);
        return;
    }

    // Dot
    const dot = e.target.closest('.carousel__dot');
    if (dot) {
        const container = dot.closest('.releases__content');
        const index = parseInt(dot.dataset.index);
        if (index !== currentIndex) await goTo(index, container);
        return;
    }

    // Toggle tracków
    const tracksToggle = e.target.closest('.album-card__tracks-toggle');
    if (tracksToggle) {
        handleTracksToggle(tracksToggle);
        return;
    }

    // Otwarcie karty albumu
    const card = e.target.closest('.album-card:not(.album-card--expanded)');
    if (!card) return;
    const albumId = card.dataset.albumId;
    if (!albumId) return;

    const container = card.closest('.releases__content');
    originalHTML = container.innerHTML; // zapisz przed nadpisaniem

    allCards = [...document.querySelectorAll('.album-card')].map(c => ({
        albumId: c.dataset.albumId,
    }));
    currentIndex = allCards.findIndex(c => c.albumId === albumId);

    card.classList.add('album-card--loading');
    const [html] = await Promise.all([
        fetchCardHTML(albumId),
        prefetchAllCards(),
    ]);
    card.classList.remove('album-card--loading');
    if (!html) return;

    renderCarousel(container);
});