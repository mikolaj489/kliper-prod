document.addEventListener('DOMContentLoaded', () => {
    const eventLinks = document.querySelectorAll('.event-link');
    const closeBtns = document.querySelectorAll('.modal-box__close');
    const modals = document.querySelectorAll('.archive__modal-box');

    // Otwieranie odpowiedniego modalu po kliknięciu w wydarzenie
    eventLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const modalId = link.getAttribute('data-modal-id');
            const targetModal = document.getElementById(modalId);
            
            if (targetModal) {
                targetModal.style.display = 'flex';
            }
        });
    });

    // Zamykanie przyciskiem "X"
    closeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = btn.closest('.archive__modal-box');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });

    // Zamykanie po kliknięciu w szare tło wokół modalu
    window.addEventListener('click', (e) => {
        modals.forEach(modal => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
}); 