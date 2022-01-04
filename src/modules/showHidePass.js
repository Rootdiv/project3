const showHidePass = () => {
  'use strict';
  //Просмотр пароля на формах с паролем
  const password = document.querySelector('.pass');
  if (password) {
    password.addEventListener('click', event => {
      const target = event.target;
      if (target.matches('.pass-control')) {
        const input = target.previousElementSibling;
        if (input.getAttribute('type') === 'password') {
          target.classList.add('view');
          input.setAttribute('type', 'text');
        } else {
          target.classList.remove('view');
          input.setAttribute('type', 'password');
        }
      }
    });
  }
};

export default showHidePass;
