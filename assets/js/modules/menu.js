import { initNavHideOnScroll } from './menu-hide-on-scroll.js';
import { initMenuToggle } from './menu-toggle.js';

function initMenu() {
    initNavHideOnScroll();
    initMenuToggle();
}
document.addEventListener('DOMContentLoaded', initMenu);