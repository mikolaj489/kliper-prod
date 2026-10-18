document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', (e) => {
        const link = e.target.closest('.event-link');
        if (link) {
            e.preventDefault();
            const modalId = link.getAttribute('data-modal-id');
            const targetModal = document.getElementById(modalId);
            
            if (targetModal) {
                targetModal.style.display = 'flex';
                document.body.style.overflow = 'hidden'; 
            }
        }
    });

    document.addEventListener('click', (e) => {
        const closeBtn = e.target.closest('.modal-box__close');
        if (closeBtn) {
            const modal = closeBtn.closest('.modal-box');
            if (modal) {
                closeModal(modal);
            }
        }
    });

    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-box')) {
            closeModal(e.target);
        }
    });
    function closeModal(modalElement) {
        modalElement.style.display = 'none';
        document.body.style.overflow = '';
    }
});