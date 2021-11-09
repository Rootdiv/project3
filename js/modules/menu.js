const menu = () => {
  'use strict';
  //Бургер-меню
  document.querySelector('.logo-mobile').addEventListener('click', () => {
    document.querySelector('.menu-mobile').classList.toggle('menu-mobile-hidden');
  });
}

export default menu;
