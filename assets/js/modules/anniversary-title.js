  const wrapper = document.querySelector('.anniversary__wrapper');
  const titleWrapper = document.querySelector('.anniversary__title-wrapper');
  const title = document.querySelector('.anniversary__title');
  function resizeTitle() {
    if (!wrapper || !title) return;

    let fontSize = 80; 
    title.style.fontSize = fontSize + 'px';
    title.style.whiteSpace = 'nowrap'; 

    while (title.scrollWidth > wrapper.clientWidth && fontSize > 12) {
      fontSize -= 1;
      title.style.fontSize = fontSize + 'px';
    }

    titleWrapper.style.height = title.offsetHeight + 'px';
}

window.addEventListener('load', resizeTitle);
window.addEventListener('resize', resizeTitle);

if (wrapper && title) {
  const observer = new IntersectionObserver((entries, observerInstance) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
          title.style.visibility = 'visible';
          title.style.animation = 'slideUpTitle 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards';
          observerInstance.unobserve(entry.target);
      }
        resizeTitle() 
    });
  }, {
    threshold: .2
  });

  observer.observe(wrapper);
}