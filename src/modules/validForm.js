const validForm = () => {
  'use strict';
  //Валидация всех форм
  const errorDiv = document.createElement('div');
  errorDiv.textContent = 'Ошибка в этом поле';
  errorDiv.classList.add('msg-error', 'size-font');
  errorDiv.style.textTransform = 'none';
  const errorValid = elem => {
    if (elem.previousElementSibling && elem.previousElementSibling.classList.contains('error')) {
      elem.previousElementSibling.remove();
    }
    elem.insertAdjacentElement('beforebegin', errorDiv);
  };
  //Функции обработки инпутов
  const formNamedInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^а-яё\s-]/gi, '');
    if (target.value.length > 50) {
      errorValid(target);
    } else {
      errorDiv.remove();
    }
  };
  const formNamedBlur = event => {
    const target = event.target;
    if (target.matches('[name="title"]')) {
      target.value = target.value.charAt(0).toUpperCase() + target.value.slice(1).toLowerCase();
    } else {
      target.value = target.value.split(/\s+/)
        .map(str => str.charAt(0).toUpperCase() + str.slice(1).toLowerCase()).join(' ')
        .trim();
    }
    if (target.value.length < 2 || target.value.length > 50) {
      target.value = '';
    }
  };
  const formAddressInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^а-яё\d\s\-.]/gi, '');
    if (target.value.length > 100) {
      errorValid(target);
    } else {
      errorDiv.remove();
    }
  };
  const formAddressBlur = event => {
    const target = event.target;
    if (target.value.length < 2 || target.value.length > 100) {
      target.value = '';
    }
  };
  const formEmailInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^\w\d\-._@]/gi, '');
    errorDiv.remove();
  };
  const formEmailBlur = event => {
    const target = event.target;
    target.value = target.value.replace(/^[\s-]+|[\s-]+$/gi, '').replace(/-+/g, '-');
    const mailValid = /^[a-z0-9_.-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
    if (!mailValid.test(target.value) || target.value.trim() === '') {
      if (target.closest('[name="scribe"]')) {
        //Параметры уведомления об ошибке на главной странице
        errorDiv.className = 'msg-error box';
        errorDiv.textContent = 'Некорректный e-mail. Попробуйте ещё раз';
        target.closest('[name="scribe"]').insertAdjacentElement('beforeend', errorDiv);
      } else {
        errorValid(target);
      }
    } else {
      errorDiv.remove();
    }
  };
  const formTextInput = event => {
    const target = event.target;
    if (target.matches('[name="description"]')) {
      target.value = target.value.replace(/[^а-яё\-.,!\s]/gi, '');
    } else {
      target.value = target.value.replace(/[a-z$[\]*{}]/gi, '');
    }
    if (target.value.length > 2000) {
      errorValid(target);
    } else {
      errorDiv.remove();
    }
  };
  const formTextBlur = event => {
    const target = event.target;
    target.value = target.value.trim().replace(/\s+/g, ' ').replace(/-+/g, '-');
    if (target.value.length < 15 || target.value.length > 2000) {
      errorValid(target);
    } else {
      errorDiv.remove();
    }
  };
  const formPostCodeInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^\d]/gi, '');
    if (target.value.length > 6) {
      target.value = target.value.substring(0, 6);
    }
  };
  const formPostCodeBlur = event => {
    const target = event.target;
    if (target.value.length !== 6) {
      errorValid(target);
    } else {
      errorDiv.remove();
    }
  };
  const formPriceCodeInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^\d]/gi, '');
    if (target.value.length > 20) {
      target.value = target.value.substring(0, 20);
    }
  };
  const formPriceCodeBlur = event => {
    const target = event.target;
    if (target.value.length < 2 || target.value.length > 20) {
      target.value = '';
    }
  };
  const formPhoneInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^+\d]/g, '');
    if (target.value.length > 12) {
      target.value = target.value.substring(0, 12);
    } else if (target.value.charAt(0) !== '+' || target.value.charAt(1) !== '7') {
      target.value = '+7';
    }
    errorDiv.remove();
  };
  const formPhoneBlur = event => {
    const target = event.target;
    const phoneValid = /[+]{1}[0-9]{12}/g;
    target.value = target.value.replace(/^[+]{1,}/g, '+').replace(/[+]{1,}$/g, '');
    if (phoneValid.test(target.value)) {
      errorValid(target);
    } else {
      errorDiv.remove();
    }
  };
  const formLoginInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^\w\d\-._@]/gi, '');
    if (target.value.indexOf('@') !== -1) {
      if (target.value.length > 50) {
        target.value = target.value.substring(0, 50);
      }
    } else {
      if (target.value.length > 15) {
        target.value = target.value.substring(0, 15);
      }
    }
    errorDiv.remove();
  };
  const formLoginBlur = event => {
    const target = event.target;
    target.value = target.value.replace(/^[\s-]+|[\s-]+$/gi, '').replace(/-+/g, '-');
    if (target.value.indexOf('@') !== -1) {
      const mailValid = /^[a-z0-9_.-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
      if (!mailValid.test(target.value) || target.value.trim() === '') {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    } else {
      if (target.value.length < 4 || target.value.length > 15) {
        target.value = '';
      }
    }
  };
  const formPasswordInput = event => {
    const target = event.target;
    target.value = target.value.replace(/[^\w\-+#%!]$/gi, '');
    if (target.value.length > 17) {
      target.value = target.value.substring(0, 17);
    }
  };
  const formPasswordBlur = event => {
    const target = event.target;
    if (target.value.length < 5 || target.value.length > 17) {
      target.value = '';
    }
  };
  const formFile = event => {
    const target = event.target;
    if (target.value !== '') {
      const photo = target.value.split('\\');
      const photoName = photo[photo.length - 1];
      const photoInfo = target.value.split('.').pop();
      const photoNameValid = /^[a-z0-9_.-]+$/i;
      const extValid = ['jpg', 'png', 'jpeg', ];
      const photoSize = target.files[0].size;
      if (!photoNameValid.test(photoName)) {
        errorValid(target);
      } else if (!extValid.includes(photoInfo)) {
        errorValid(target);
      } else if (photoSize < 22600 || photoSize > 5242880) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    }
  };
  //Вешаем слушатель по клику на form и внутри вешаем слушатель на нужный input с вызовом соответствущей функции
  document.body.addEventListener('click', event => {
    const target = event.target;
    if (target.matches('[name*="name"]') || target.matches('[name="city"]') || target.matches('[name="full_name"]') ||
      target.matches('[name="title"]')) {
      target.addEventListener('input', formNamedInput);
      target.addEventListener('blur', formNamedBlur);
    } else if (target.matches('[name="address"]')) {
      target.addEventListener('input', formAddressInput);
      target.addEventListener('blur', formAddressBlur);
    } else if (target.matches('[type="email"]')) {
      target.addEventListener('input', formEmailInput);
      target.addEventListener('blur', formEmailBlur);
    } else if (target.matches('[placeholder*="сообщение"]') || target.matches('[name="description"]')) {
      //Вешаем слушатель на поле плейсхолдер которого содержит подстроку "сообщение" или
      //совпадает атрибут поля name совпадает с description
      target.addEventListener('input', formTextInput);
      target.addEventListener('blur', formTextBlur);
    } else if (target.matches('[name="postcode"]')) {
      target.addEventListener('input', formPostCodeInput);
      target.addEventListener('blur', formPostCodeBlur);
    } else if (target.matches('[type="tel"]')) {
      target.addEventListener('input', formPhoneInput);
      target.addEventListener('blur', formPhoneBlur);
    } else if (target.matches('[name="login"]')) {
      target.addEventListener('input', formLoginInput);
      target.addEventListener('blur', formLoginBlur);
    } else if (target.matches('[name="password"]')) {
      target.addEventListener('input', formPasswordInput);
      target.addEventListener('blur', formPasswordBlur);
    } else if (target.matches('[name="article"]') || target.matches('[name="price"]') ||
      target.matches('[name="sized"]')) {
      target.addEventListener('input', formPriceCodeInput);
      target.addEventListener('blur', formPriceCodeBlur);
    } else if (target.matches('[type="file"]')) {
      target.addEventListener('input', formFile);
    }
    //Удалять слушатели не нужно, повторного навешивания нет.
  });
};

export default validForm;
