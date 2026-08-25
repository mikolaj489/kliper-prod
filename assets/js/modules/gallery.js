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
        yearBtns: wrapper.querySelectorAll('.cfg__year-btn'),
        prevBtn: wrapper.querySelector('.cfg__scroll-btn--prev'),
        nextBtn: wrapper.querySelector('.cfg__scroll-btn--next'),
    });

    const initialGallery = wrapper.dataset.initialGallery;
    if (initialGallery) {
        const button = wrapper.querySelector(`[data-gallery-id="${CSS.escape(initialGallery)}"]`);
        button?.classList.add('cfg__gallery-btn--active');
        loader.load(initialGallery, false);
    }
}

document.addEventListener('DOMContentLoaded', initGallery);
