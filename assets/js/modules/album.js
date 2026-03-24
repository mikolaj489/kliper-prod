document.addEventListener('click', async (e) => {

    // --- ZAMKNIĘCIE ---
    if (e.target.closest('.album-card__close')) {
        window.location.reload();
        return;
    }

    // --- OTWARCIE ---
    const card = e.target.closest('.album-card:not(.album-card--expanded)');
    if (!card) return;

    const albumId = card.dataset.albumId;
    if (!albumId) return;

    card.classList.add('album-card--loading');

    const formData = new FormData();
    formData.append('action',   'get_album_detail');
    formData.append('nonce',    AlbumAjax.nonce);
    formData.append('album_id', albumId);

    try {
        const res  = await fetch(AlbumAjax.url, { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            // Usuń wszystkie pozostałe karty
            document.querySelectorAll('.album-card').forEach(c => {
                if (c !== card) c.remove();
            });

            // Podmień klikniętą na rozszerzoną
            card.outerHTML = data.data.html;
        }
    } catch (err) {
        console.error('Album AJAX error:', err);
        card.classList.remove('album-card--loading');
    }
});