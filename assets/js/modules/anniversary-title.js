function resizeTitle() {
  const wrapper = document.querySelector('.anniversary__wrapper');
  const title = document.querySelector('.anniversary__title');
  if (!wrapper || !title) return;

  let fontSize = 60; 
  title.style.fontSize = fontSize + 'px';
  title.style.whiteSpace = 'nowrap'; 
  
  while (title.scrollWidth > wrapper.clientWidth && fontSize > 12) {
    fontSize -= 1;
    title.style.fontSize = fontSize + 'px';
  }
}

window.addEventListener('load', resizeTitle);
window.addEventListener('resize', resizeTitle);