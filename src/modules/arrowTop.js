const arrowTop = () => {
  'use strict';
  //Плавная прокрутка страницы вверх
  const arrow = document.querySelector('.go-top');
  window.addEventListener('scroll', () => {
    const scrollHeight = Math.round(window.scrollY);
    if (scrollHeight > 300) {
      arrow.style.opacity = 1;
    } else {
      arrow.style.opacity = 0;
    }
  });
  const backToTop = () => {
    if (window.pageYOffset > 0) {
      window.scrollBy(0, -10);
      setTimeout(backToTop, 1);
    }
  };
  arrow.addEventListener('click', () => {
    backToTop();
  });
};

export default arrowTop;
