const sendForm = () => {
  'use strict';
  //Отправка форм
  const url = location.href.substring(0, location.href.lastIndexOf('/project3/'));
  const loader = `<img src="${url}/project3/img/loader.svg" alt="Загрузка..."/>`;
  const errorMessage = 'Что-то пошло не так...';
  const statusMessage = document.createElement('div');
  statusMessage.classList.add('msg', 'size-font', 'box');
  //Функция отправки данных на сервер и обработки ответа
  const postData = (formData, target) => {
    return fetch(target.action, {
      method: 'POST',
      body: formData,
    });
  };
  const formSubmit = (target) => {
    const formButton = target.querySelector('button');
    formButton.insertAdjacentElement('afterend', statusMessage);
    statusMessage.innerHTML = loader;
    const formData = new FormData(target);
    const removeMessage = () => {
      setTimeout(() => statusMessage.remove(), 5000);
    };
    const authForm = () => {
      setTimeout(() => {
        const urlReg = location.href.substring(0, location.href.lastIndexOf('/') + 1);
        location.replace(urlReg + 'login.php');
      }, 2500);
    };
    postData(formData, target)
      .then(response => {
        if (response.status !== 200) {
          throw new Error('Status network not 200');
        }
        return response.text();
      })
      .then(result => {
        if (result.indexOf('успешно') !== -1) {
          if (target.matches('[name="scribe"]')) {
            statusMessage.textContent = 'Вы подписаны';
          } else if (target.matches('[name="profile"]')) {
            statusMessage.textContent = result;
            authForm();
          } else {
            statusMessage.textContent = result;
            setTimeout(() => location.replace(location.href), 5500);
          }
          target.reset();
          removeMessage();
        } else if (result.indexOf('Новый') !== -1) {
          statusMessage.textContent = result + ' успешно';
          target.reset();
          removeMessage();
          setTimeout(() => location.replace(location.href), 5500);
        } else if (result.indexOf('Сообщение') !== -1) {
          statusMessage.textContent = result;
          target.reset();
          removeMessage();
        } else if (result.indexOf('Авторизован') !== -1) {
          const url = location.href.substring(0, location.href.lastIndexOf('/auth/') + 1);
          location.replace(url + 'main.php');
        } else if (result.indexOf('Зарегистрирован') !== -1 || result.indexOf('сгенерирован') !== -1) {
          statusMessage.textContent = result;
          authForm();
        } else if (result.indexOf('Заказ') !== -1) {
          statusMessage.textContent = result;
          setTimeout(() => location.replace(location.href), 2500);
        } else if (result.indexOf('Удалено') !== -1) {
          setTimeout(() => location.replace(location.href), 500);
        } else {
          statusMessage.classList.remove('msg');
          statusMessage.classList.add('msg-error');
          if (result.indexOf('not found') !== -1 || result.indexOf('Подключение') !== -1) {
            statusMessage.textContent = 'Ой, что-то пошло не так.';
          } else {
            statusMessage.innerHTML = result;
          }
          removeMessage();
        }
      }).catch(error => {
        statusMessage.textContent = errorMessage;
        console.error(error);
        removeMessage();
      });
  };
  const validSend = (elem) => {
    const num = /^[0-9]+$/g;
    const value = elem.value;
    if (!num.test(value) || value === '0') {
      alert('Ошибка');
      location.reload();
      return false;
    }
    return true;
  };
  const validBasket = (target) => {
    const num = /^[0-9]+$/g;
    const delivery = target.querySelector('[name="delivery"]');
    if (!num.test(delivery.value) || delivery.value === '0') {
      alert('Ошибка! Значение изменено вручную!');
      location.reload();
      return false;
    }
    if (delivery.value !== '500' && delivery.value !== '250' && delivery.value !== '1000') {
      alert('Ошибка! Значение изменено вручную!');
      location.reload();
      return false;
    }
    const payment = target.querySelector('[name="payment"]');
    const paymentValid = /^[a-zёа-я\.\s]{4,20}$/i;
    if (!paymentValid.test(payment.value) || payment.value === '') {
      alert('Ошибка! Значение изменено вручную!');
      location.reload();
      return false;
    }
    return true;
  };
  document.body.addEventListener('submit', (event) => {
    event.preventDefault();
    const target = event.target;
    if (!target.querySelector('.msg-error')) {
      //Если нет сообщения об ошибке выполняем действия соответствующие форме
      if (target.closest('[name="scribe"]')) {
        if (validSend(target.querySelector('input[hidden]')) && target.querySelector('[type="email"]').value
          .trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('[name="basket"]')) {
        validBasket(target);
        if (target.querySelector('[type="email"]').value.trim() !== '' &&
          target.querySelector('[type="tel"]').value.trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('[name="contacts"]')) {
        if (validSend(target.querySelector('[name="adm_msg"]')) && target.querySelector('[type="email"]').value
          .trim() !== '' &&
          target.querySelector('[type="tel"]').value.trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('.login')) {
        if (target.querySelector('[name="login"]').value.trim() !== '' ||
          target.querySelector('[type="password"]').value.trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('[name="profile"]')) {
        if (target.querySelector('[name="username"]').value.trim() !== '' ||
          target.querySelector('[type="email"]').value.trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('[name="order"]')) {
        if (validSend(target.querySelector('input[hidden]'))) {
          formSubmit(target);
        }
      } else if (target.closest('[id="edit"]')) {
        if (validSend(target.querySelector('[name*="id"]')) &&
          validSend(target.querySelector('[name="category"]')) && validSend(target.querySelector(
            '[name="categories"]'))) {
          formSubmit(target);
        }
      } else if (target.closest('[name="users"]')) {
        if (validSend(target.querySelector('[name*="id"]')) && validSend(target.querySelector('[name="id"]')) &&
          validSend(target.querySelector('[name="adm"]'))) {
          formSubmit(target);
        }
      } else {
        formSubmit(target);
      }
    }
  });
};

export default sendForm;
