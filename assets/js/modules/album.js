// document.addEventListener('click', async (e) => {
//     // --- ZAMKNIĘCIE ---
//     if (e.target.closest('.album-card__close')) {
//         window.location.reload();
//         return;
//     }

//     // --- OTWARCIE ---
//     const card = e.target.closest('.album-card:not(.album-card--expanded)');
//     if (!card) return;
//     const albumId = card.dataset.albumId;
//     if (!albumId) return;

//     card.classList.add('album-card--loading');

//     const formData = new FormData();
//     formData.append('action',   'get_album_detail');
//     formData.append('nonce',    AlbumAjax.nonce);
//     formData.append('album_id', albumId);

//     try {
//         const res  = await fetch(AlbumAjax.url, { method: 'POST', body: formData });
//         const data = await res.json();

//         if (data.success) {
//             // Podmień klikniętą kartę na rozszerzoną
//             card.outerHTML = data.data.html;

//             // Dodaj klasę expanded do wszystkich pozostałych kart
//             document.querySelectorAll('.album-card:not(.album-card--expanded)').forEach(c => {
//                 c.classList.add('album-card--expanded');
//             });
//         }
//     } catch (err) {
//         console.error('Album AJAX error:', err);
//         card.classList.remove('album-card--loading');
//     }
// });