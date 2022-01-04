const catalog = () => {
  'use strict';
  //Фильтры каталога
  const catalogFilter = document.querySelector('.catalog-sort');
  if (catalogFilter) {
    catalogFilter.addEventListener('click', event => {
      const target = event.target;
      if (target.closest('.categories')) {
        const elem = target.closest('.categories');
        elem.querySelector('.categories-items').classList.toggle('hidden');
        elem.querySelector('.categories-img').classList.toggle('categories-img-inv');
      } else if (target.closest('.size')) {
        const elem = target.closest('.size');
        elem.querySelector('.size-items').classList.toggle('hidden');
        elem.querySelector('.size-img').classList.toggle('size-img-inv');
      } else if (target.closest('.prices')) {
        const elem = target.closest('.prices');
        elem.querySelector('.prices-items').classList.toggle('hidden');
        elem.querySelector('.prices-img').classList.toggle('size-img-inv');
      }
    });
  }
};

export default catalog;
