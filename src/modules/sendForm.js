const sendForm = () => {
  'use strict';
  //Отправка форм
  const url = location.href.substring(0, location.href.lastIndexOf('/project3/'));
  const loader = `<img src="${url}/project3/img/loader.svg" alt="Загрузка..."/>`;
  const errorMessage = 'Что-то пошло не так...';
  const statusMessage = document.createElement('div');
  statusMessage.classList.add('msg', 'size-font', 'box');
  //Функция отправки данных на сервер и обработки ответа
  const postData = (formData, target) => fetch(target.action, {
    method: 'POST',
    body: formData,
  });
  const formSubmit = target => {
    const formButton = target.querySelector('button');
    formButton.insertAdjacentElement('afterend', statusMessage);
    statusMessage.innerHTML = loader;
    const formData = new FormData(target);
    const removeMessage = () => {
      setTimeout(() => statusMessage.remove(), 5000);
    };
    const setErrorClass = () => {
      statusMessage.classList.remove('msg');
      statusMessage.classList.add('msg-error');
    };
    postData(formData, target)
      .then(response => {
        if (response.status !== 200) {
          throw new Error('Status network not 200');
        }
        return response.text();
      })
      .then(result => {
        if (result.includes('успешно')) {
          if (target.matches('[name="scribe"]')) {
            target.reset();
            statusMessage.textContent = 'Вы подписаны';
          } else if (target.matches('[name="profile"]')) {
            statusMessage.textContent = result;
            setTimeout(() => location.reload(), 2000);
          } else {
            statusMessage.classList.remove('msg-error');
            statusMessage.classList.add('msg');
            statusMessage.textContent = result;
            setTimeout(() => location.reload(), 4000);
          }
          removeMessage();
        } else if (result.includes('Новый')) {
          statusMessage.textContent = result + ' успешно';
          setTimeout(() => location.reload(), 5500);
          removeMessage();
        } else if (result.includes('Сообщение')) {
          target.reset();
          statusMessage.textContent = result;
          removeMessage();
        } else if (result.includes('Авторизован')) {
          const url = location.href.substring(0, location.href.lastIndexOf('/auth/') + 1);
          location.replace(url + 'main.php');
        } else if (result.includes('Зарегистрирован') || result.includes('сгенерирован')) {
          target.reset();
          statusMessage.textContent = result;
          setTimeout(() => {
            const urlReg = location.href.substring(0, location.href.lastIndexOf('/') + 1);
            location.replace(urlReg + 'login.php');
          }, 2500);
        } else if (result.includes('Заказ')) {
          statusMessage.textContent = result;
          setTimeout(() => location.reload(), 2500);
        } else if (result.includes('Удалено')) {
          setTimeout(() => location.reload(), 500);
        } else if (result.includes('not found') || result.includes('Подключение')) {
          setErrorClass();
          statusMessage.textContent = 'Ой, что-то пошло не так.';
          removeMessage();
        } else if (result.includes('Ошибка')) {
          setErrorClass();
          statusMessage.textContent = result;
          removeMessage();
        }
      }).catch(error => {
        setErrorClass();
        statusMessage.textContent = errorMessage;
        console.error(error);
        removeMessage();
      });
  };
  const validSend = elem => {
    const num = /^[0-9]+$/g;
    const value = elem.value;
    if (!num.test(value) || value === '0') {
      alert('Ошибка');
      location.reload();
      return false;
    }
    return true;
  };
  const validBasket = target => {
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
    const paymentValid = /^[a-zа-я.\s]{4,20}$/i;
    if (!paymentValid.test(payment.value) || payment.value === '') {
      alert('Ошибка! Значение изменено вручную!');
      location.reload();
      return false;
    }
    return true;
  };
  document.body.addEventListener('submit', event => {
    event.preventDefault();
    const target = event.target;
    if (!target.querySelector('.msg-error')) {
      //Если нет сообщения об ошибке выполняем действия соответствующие форме
      if (target.closest('[name="scribe"]')) {
        if (validSend(target.querySelector('input[hidden]')) &&
          target.querySelector('[type="email"]').value.trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('[name="basket"]')) {
        validBasket(target);
        if (target.querySelector('[type="email"]').value.trim() !== '' &&
          target.querySelector('[type="tel"]').value.trim() !== '') {
          formSubmit(target);
        }
      } else if (target.closest('[name="contacts"]')) {
        if (validSend(target.querySelector('[name="adm_msg"]')) &&
          target.querySelector('[type="email"]').value.trim() !== '' &&
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
          validSend(target.querySelector('[name="category"]')) &&
          validSend(target.querySelector('[name="categories"]'))) {
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
