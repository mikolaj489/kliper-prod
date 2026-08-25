import { initAlbumControls } from './gallery-albums.js';
import { createGalleryLoader } from './gallery-loader.js';
import { initGalleryYears } from './galllery_nav.js';

export function initGallery() {
    const wrapper = document.querySelector('.cfg');
    if (!wrapper) return;

    const display = wrapper.querySelector('.cfg__display');
    const loadingElement = wrapper.querySelector('.cfg__gallery-loading');
    const errorElement = wrapper.querySelector('.cfg__gallery-error');
    const galleryBtns = wrapper.querySelectorAll('.cfg__gallery-btn');
    const albumContents = wrapper.querySelectorAll('.cfg__album-content');
    const yearBtns = wrapper.querySelectorAll('.cfg__year-btn');
    const albumDescriptions = wrapper.querySelectorAll('.cfg__album-description');

    const loader = createGalleryLoader({
        display,
        loadingElement,
        errorElement,
        galleryBtns,
        ajaxUrl: wrapper.dataset.ajaxUrl,
        nonce: wrapper.dataset.nonce,
    });

    initAlbumControls({
        wrapper,
        albumContents,
        galleryBtns,
        loadGallery: loader.load,
        hideGalleries: loader.hideAll,
    });

    initGalleryYears({
        yearsWrapper: wrapper.querySelector('.cfg__years-wrapper'),
        yearsContainer: wrapper.querySelector('.cfg__years'),
        yearBtns,
        prevBtn: wrapper.querySelector('.cfg__scroll-btn--prev'),
        nextBtn: wrapper.querySelector('.cfg__scroll-btn--next'),
    });

    // Obsługa przełączania roczników (przycisków lat) wraz z opisami
    yearBtns.forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target'); // np. "cfg-album-123"
            if (!targetId) return;

            const albumId = targetId.replace('cfg-album-', ''); // samo ID "123"

            // 1. Przełączanie aktywnego przycisku roku
            yearBtns.forEach(btn => btn.classList.remove('cfg__year-btn--active'));
            button.classList.add('cfg__year-btn--active');

            // 2. Ukrycie wszystkich zestawów przycisków wydarzeń
            albumContents.forEach(content => content.classList.remove('cfg__album-content--active'));

            // 3. Ukrycie wszystkich opisów
            albumDescriptions.forEach(desc => desc.classList.remove('cfg__album-description--active'));

            // 4. Pokazanie właściwego zestawu przycisków
            const activeContent = document.getElementById(targetId);
            if (activeContent) {
                activeContent.classList.add('cfg__album-content--active');
            }

            // 5. Pokazanie opisu przypisanego do wybranego roku
            const activeDesc = wrapper.querySelector(`.cfg__album-description[data-album-id="${albumId}"]`);
            if (activeDesc) {
                activeDesc.classList.add('cfg__album-description--active');
            }
        });
    });

    // Inicjalizacja pierwszej galerii (jeśli podana w dataset)
    const initialGallery = wrapper.dataset.initialGallery;
    if (initialGallery) {
        wrapper.classList.add('cfg--year-selected');
        const button = wrapper.querySelector(`[data-gallery-id="${CSS.escape(initialGallery)}"]`);
        button?.classList.add('cfg__gallery-btn--active');
        loader.load(initialGallery, button?.textContent.trim() || '', false);
    }
}

document.addEventListener('DOMContentLoaded', initGallery);