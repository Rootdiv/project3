'use strict';
//Функция модального окна
const modalShow = (target, url, set = '') => {
  const modalKit = document.getElementById('modal-kit');
  const modal = document.getElementById('modal');
  const top = window.pageYOffset;
  if (top === 0) {
    const elem = document.getElementById('modal');
    elem.style.top = '20%';
  } else {
    const elem = document.getElementById('modal');
    elem.style.top = top + 40 + 'px';
  }
  const id = target.getAttribute('data-id');
  const urlStr = url + '/components/modal.php?id=' + id + set;
  fetch(urlStr).then(response => {
    if (response.status !== 200) {
      throw new Error('Status network not 200');
    }
    return response.text();
  }).then(response => {
    modalKit.style.display = 'block';
    modal.innerHTML = response;
  }).catch(error => console.error(error));

  if (modalKit) {
    document.addEventListener('keydown', event => {
      if (event.code === 'Escape') {
        modalKit.style.display = 'none';
      }
    });
  }
};

export default modalShow;
