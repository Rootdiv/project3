import modalShow from './modalShow.js'
//Вызов модального окна для редактировании товара или пользователей

const editProductOrUser = () => {
  'use strict';
  const profile = document.querySelector('.profile');
  const modalKit = document.getElementById('modal-kit');
  if (profile) {
    const url = location.href.substring(0, location.href.lastIndexOf('/admin/'));
    profile.addEventListener('click', (event) => {
      const target = event.target;
      if (target.matches('.products-edit')) {
        modalShow(target, url, '&product=edit&user=false');
      } else if (target.matches('.products-new')) {
        modalShow(target, url, '&product=new&user=false');
      } else if (target.matches('.users-edit')) {
        modalShow(target, url, '&user=edit&product=false');
      } else if (target.matches('.modal-close')) {
        modalKit.style.display = 'none';
      } else if (target.matches('.overlay')) {
        modalKit.style.display = 'none';
      }
    });
  }
};

export default editProductOrUser;
