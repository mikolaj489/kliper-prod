export function initNavHideOnScroll() {
    const nav = document.querySelector('.main-nav');
    let lastScrollY = window.scrollY;
    let ticking = false;
    
    function onScroll() {
      const currentScrollY = window.scrollY;
    
      if (currentScrollY > lastScrollY && currentScrollY > 200) {
        let styles = window.getComputedStyle(nav);
        let baseHeight = nav.offsetHeight;
        let marginTop = parseFloat(styles.marginTop) || 0;
        let marginBottom = parseFloat(styles.marginBottom) || 0;
        let totalHeight = baseHeight + marginTop + marginBottom;
        nav.style.transform = `translateY(-${totalHeight + 50}px)`;
      } else {
        nav.style.transform = 'translateY(0)';
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