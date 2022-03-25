import modalShow from './modalShow.js';
import showHidePass from './showHidePass.js';

//Вызов модального окна для редактировании товара или пользователей
const editProductOrUser = () => {
  'use strict';
  const profile = document.querySelector('.profile');
  const modalKit = document.getElementById('modal-kit');
  if (profile) {
    const url = location.href.substring(0, location.href.lastIndexOf('/admin/'));
    profile.addEventListener('click', event => {
      const target = event.target;
      if (target.matches('.products-edit')) {
        modalShow(target, url, '&product=edit');
      } else if (target.matches('.products-new')) {
        modalShow(target, url, '&product=new');
      } else if (target.matches('.users-edit')) {
        modalShow(target, url, '&user=edit');
        setTimeout(showHidePass, 1000);
      } else if (target.matches('.modal-close')) {
        modalKit.style.display = 'none';
      } else if (target.matches('.overlay')) {
        modalKit.style.display = 'none';
      }
    });
  }
};

export default editProductOrUser;
