export function initNavHideOnScroll() {
    const nav = document.querySelector('.main-nav'); // podmień na swój selektor navbara
    let lastScrollY = window.scrollY;
    let ticking = false;
    
    function onScroll() {
      const currentScrollY = window.scrollY;
    
      if (currentScrollY > lastScrollY && currentScrollY > 200) {
        // scroll w dół -> chowamy
        nav.classList.add('nav--hidden');
      } else {
        // scroll w górę -> pokazujemy
        nav.classList.remove('nav--hidden');
      }
    
      lastScrollY = currentScrollY;
      ticking = false;
    }
  
    window.addEventListener('scroll', () => {
      if (!ticking) {
        requestAnimationFrame(onScroll);
        ticking = true;
      }
    }, { passive: true });
}