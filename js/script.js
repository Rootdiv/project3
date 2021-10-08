'use strict';
document.addEventListener('DOMContentLoaded', () => {
  //Плавная прокрутка страницы вверх
  const arrowTop = () => {
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
  arrowTop();
  //Бургер-меню
  document.querySelector('.logo-mobile').addEventListener('click', () => {
    document.querySelector('.menu-mobile').classList.toggle('menu-mobile-hidden');
  });
  //Валидация всех форм
  const validForm = () => {
    const errorDiv = document.createElement('div');
    errorDiv.textContent = 'Ошибка в этом поле';
    errorDiv.classList.add('msg-error', 'size-font');
    errorDiv.style.textTransform = 'none';
    const errorValid = (elem) => {
      if (elem.previousElementSibling && elem.previousElementSibling.classList.contains('error')) {
        elem.previousElementSibling.remove();
      }
      elem.insertAdjacentElement('beforebegin', errorDiv);
    };
    //Функции обработки инпутов
    const formNamedInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^а-яё\s-]/gi, '');
      if (target.value.length > 50) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    };
    const formNamedBlur = (event) => {
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
    const formAddressInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^а-яё\d\s\-\.]/gi, '');
      if (target.value.length > 100) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    };
    const formAddressBlur = (event) => {
      const target = event.target;
      if (target.value.length < 2 || target.value.length > 100) {
        target.value = '';
      }
    };
    const formEmailInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^\w\d\_\.\-\@]/gi, '');
      errorDiv.remove();
    };
    const formEmailBlur = (event) => {
      const target = event.target;
      target.value = target.value.replace(/^[\s-]+|[\s-]+$/gi, '').replace(/-+/g, '-');
      const mailValid = /^[a-z0-9\_\.\-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
      if (!mailValid.test(target.value) || target.value.trim() === '') {
        if (target.closest('[name="scribe"]')) {
          //Параметры уведомления об ошибке на главной странице
          target.closest('[name="scribe"]').insertAdjacentElement('beforeend', errorDiv);
          errorDiv.classList.add('msg-error', 'size-font', 'box');
          errorDiv.textContent = 'Некорректный e-mail. Попробуйте ещё раз';
        } else {
          errorValid(target);
        }
      } else {
        errorDiv.remove();
      }
    };
    const formTextInput = (event) => {
      const target = event.target;
      if (target.matches('[name="description"]')) {
        target.value = target.value.replace(/[^а-яё\-\.\,\s\!]/gi, '');
      } else {
        target.value = target.value.replace(/[a-z\$\[\]*{}]/gi, '');
      }
      if (target.value.length > 2000) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    };
    const formTextBlur = (event) => {
      const target = event.target;
      target.value = target.value.trim().replace(/\s+/g, ' ').replace(/-+/g, '-');
      if (target.value.length < 15 || target.value.length > 2000) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    };
    const formPostCodeInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^\d]/gi, '');
      if (target.value.length > 6) {
        target.value = target.value.substring(0, 6);
      }
    };
    const formPostCodeBlur = (event) => {
      const target = event.target;
      if (target.value.length !== 6) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    };
    const formPriceCodeInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^\d]/gi, '');
      if (target.value.length > 20) {
        target.value = target.value.substring(0, 20);
      }
    };
    const formPriceCodeBlur = (event) => {
      const target = event.target;
      if (target.value.length < 2 || target.value.length > 20) {
        target.value = '';
      }
    };
    const formPhoneInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^\+\d]/g, '');
      if (target.value.length > 12) {
        target.value = target.value.substring(0, 12);
      } else if (target.value.charAt(0) !== '+' || target.value.charAt(1) !== '7') {
        target.value = '+7';
      }
      errorDiv.remove();
    };
    const formPhoneBlur = (event) => {
      const target = event.target;
      const phoneValid = /[+]{1}[0-9]{12}/g;
      target.value = target.value.replace(/^[\+]{1,}/g, '+').replace(/[\+]{1,}$/g, '');
      if (phoneValid.test(target.value)) {
        errorValid(target);
      } else {
        errorDiv.remove();
      }
    };
    const formLoginInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^\w\d\_\.\-\@]/gi, '');
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
    const formLoginBlur = (event) => {
      const target = event.target;
      target.value = target.value.replace(/^[\s-]+|[\s-]+$/gi, '').replace(/-+/g, '-');
      if (target.value.indexOf('@') !== -1) {
        const mailValid = /^[a-z0-9\_\.\-]+@[a-z0-9-]+\.[a-z]{2,6}$/i;
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
    const formPasswordInput = (event) => {
      const target = event.target;
      target.value = target.value.replace(/[^\w\+\-\#\%\!]$/gi, '');
      if (target.value.length > 17) {
        target.value = target.value.substring(0, 17);
      }
    };
    const formPasswordBlur = (event) => {
      const target = event.target;
      if (target.value.length < 5 || target.value.length > 17) {
        target.value = '';
      }
    };
    const formFile = (event) => {
      const target = event.target;
      if (target.value !== '') {
        const photo = target.value.split('\\');
        const photoName = photo[photo.length - 1];
        const photoInfo = target.value.split('.').pop();
        const photoNameValid = /^[a-z0-9\.\_\-]+$/i;
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
    document.body.addEventListener('click', (event) => {
      const target = event.target;
      if (target.matches('[name*="name"]') || target.matches('[name="city"]') || target.matches('[name="fio"]') ||
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
      } else if (target.matches('[name="article"]') || target.matches('[name="price"]') || target.matches('[name="sized"]')) {
        target.addEventListener('input', formPriceCodeInput);
        target.addEventListener('blur', formPriceCodeBlur);
      } else if (target.matches('[type="file"]')) {
        target.addEventListener('input', formFile);
      }
      //Удалять слушатели не нужно, повторного навешивания нет.
    });
  };
  validForm();
  //Отправка форм
  const sendForm = () => {
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
          if (validSend(target.querySelector('input[hidden]')) && target.querySelector('[type="email"]').value.trim() !== '') {
            formSubmit(target);
          }
        } else if (target.closest('[name="basket"]')) {
          validBasket(target);
          if (target.querySelector('[type="email"]').value.trim() !== '' &&
            target.querySelector('[type="tel"]').value.trim() !== '') {
            formSubmit(target);
          }
        } else if (target.closest('[name="contacts"]')) {
          if (validSend(target.querySelector('[name="adm_msg"]')) && target.querySelector('[type="email"]').value.trim() !== '' &&
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
            validSend(target.querySelector('[name="category"]')) && validSend(target.querySelector('[name="categories"]'))) {
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
  sendForm();
  //Фильтры каталога
  const catalog = () => {
    const catalogFilter = document.querySelector('.catalog-sort');
    if (catalogFilter) {
      catalogFilter.addEventListener('click', (event) => {
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
  catalog();
  //Функция модального окна
  const modalShow = (target, url, set = '') => {
    const modalKit = document.getElementById('modal-kit');
    const modal = document.getElementById('modal');
    const top = window.pageYOffset;
    if (top === 0) {
      let elem = document.getElementById('modal');
      elem.style.top = '20%';
    } else {
      let elem = document.getElementById('modal');
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
  };
  if (document.getElementById('modal-kit')) {
    document.addEventListener('keydown', (event) => {
      if (event.code === 'Escape') {
        document.getElementById('modal-kit').style.display = 'none';
      }
    });
  }
  //Корзина
  const basket = () => {
    const basketBlock = document.querySelector('.basket-block');
    const basketElem = document.getElementById('basket');
    const basketAmount = document.getElementById('basket-amount');
    const deliverySet = document.getElementById('delivery-set');
    const divTotal = document.getElementById('div-total');
    const total = document.getElementById('total');
    const cost = document.getElementById('cost');
    const divAmount = document.getElementById('div-amount');
    const deliverySum = document.getElementById('delivery_sum');
    const basketSet = document.getElementById('basket-set');
    const modalKit = document.getElementById('modal-kit');
    if (basketBlock) {
      //Сумма с доставкой
      const delivery = () => {
        divAmount.textContent = basketAmount.value + ' руб.';
        cost.textContent = divAmount.textContent;
        const totalSum = parseInt(basketAmount.value) + parseInt(deliverySet.value);
        divTotal.textContent = totalSum + ' руб.';
        total.setAttribute('value', totalSum);
        deliverySum.textContent = deliverySet.value + ' руб.';

      };
      //Присвоение ID элементам корзины для расчёта количества
      const setID = () => {
        let idQuantity = 0;
        const quantityAll = basketElem.querySelectorAll('.quantity');
        quantityAll.forEach(elem => {
          idQuantity++;
          elem.setAttribute('id', 'quantity' + idQuantity);
        });
        let idPrice = 0;
        const priceAll = basketElem.querySelectorAll('.price');
        priceAll.forEach(elem => {
          idPrice++;
          elem.setAttribute('id', 'price' + idPrice);
        });
      };
      //Считаем сумму с доставкой если количество товара больше 1
      const priceSum = () => {
        const quantityAll = basketElem.getElementsByClassName('quantity');
        let sum = 0;
        for (let i = 1; i <= quantityAll.length; i++) {
          const elem = 'quantity' + i;
          const value = document.getElementById(elem).value;
          if (value === '' || value < 1 || value > 50) {
            alert('Количество не может быть меньше 1 или быть больше 50');
            location.reload();
          } else {
            const price = document.getElementById(elem).getAttribute('data-price');
            const priceSum = parseInt(value) * parseInt(price);
            const priceId = 'price' + i;
            document.getElementById(priceId).textContent = priceSum + ' руб.';
            sum += parseInt(priceSum);
          }
        }
        basketAmount.setAttribute('value', sum);
        delivery();
      };
      //Функция удаления товара из корзины
      const deleteProduct = (target) => {
        const deleteUrl = target.getAttribute('href');
        const id = deleteUrl.split('=').pop();
        const basStr = basketSet.innerHTML.split('(');
        fetch(deleteUrl).then(response => {
          if (response.status !== 200) {
            throw new Error('Status network not 200');
          }
          document.getElementById(id).remove();
          let num = parseInt(basStr[1]) - 1;
          if (num !== 0) {
            basketSet.innerHTML = basStr[0] + '(' + num + ')';
            setID();
            priceSum();
          } else {
            basketSet.innerHTML = basStr[0] + '(0)';
            basketElem.innerHTML = '<div class="box">Ваша корзина пуста</div>';
            divAmount.style.visibility = 'hidden';
            location.reload(); //Перезагружаем страницу если корзина пуста
          }
        }).catch(error => console.error(error));
      };

      deliverySum.textContent = deliverySet.value + ' руб.';
      //При изменении стоимости доставки считаем сумму только если есть товар(ы) в корзине
      deliverySet.addEventListener('change', () => {
        deliverySum.textContent = deliverySet.value + ' руб.';
        if (basketAmount.value !== '0') delivery();
      });
      //Если в корзине есть хотя бы один товар показываем скрытые элементы
      if (basketAmount.value !== '0') {
        divAmount.removeAttribute('style');
        divTotal.removeAttribute('style');
        //Разрешаем отправку формы и присваиваем id нужным пунктам в списке товаров
        document.querySelector('button').removeAttribute('disabled');
        setID();
        delivery(); //Считаем сумму с доставкой
      }

      basketBlock.addEventListener('click', (event) => {
        const target = event.target;
        if (target.matches('.number-plus')) {
          target.nextElementSibling.value++;
        } else if (target.matches('.number-minus')) {
          target.previousElementSibling.value--;
        } else if (target.closest('#remove')) {
          event.preventDefault();
          deleteProduct(target);
        } else if (target.matches('.modal-close')) {
          modalKit.style.display = 'none';
        } else if (target.closest('#modal')) {
          modalKit.style.display = 'none';
        } else {
          if (basketAmount.value !== '0') {
            modalKit.style.display = 'none';
            priceSum();
          }
        }
      });
      //Модальное окно на странице корзины, если устройство без тач-скрина
      basketElem.addEventListener('mouseover', (event) => {
        const target = event.target;
        if (target.closest('.product-photo')) {
          const isTouchDevice = () => ('ontouchstart' in window) || ('onmsgesturechange' in window);
          if (isTouchDevice() !== true) {
            const url = location.href.substring(0, location.href.lastIndexOf('/'));
            modalShow(target.closest('.product-photo'), url);
          }
        }
      });
    }
  };
  basket();
  //Просмотр пароля на формах с паролем
  const showHidePass = () => {
    const password = document.querySelector('.pass');
    if (password) {
      password.addEventListener('click', (event) => {
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
  showHidePass();
  //Вызов модального окна для редактировании товара или пользователей
  const editProductOrUser = () => {
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
  editProductOrUser();
});
//Карта
if (document.getElementById('map')) {
  var ymaps;
  ymaps.ready(function() {
    var myMap = new ymaps.Map("map", {
        center: [55.776142, 37.648167],
        zoom: 17
      }, {
        searchControlProvider: 'yandex#search'
      }),
      // Создаем геообъект с типом геометрии "Точка".
      myGeoObject = new ymaps.GeoObject({
        // Описание геометрии.
        geometry: {
          type: "Point",
          coordinates: [55.776142, 37.648167]
        }
      });
    myMap.geoObjects.add(myGeoObject);
  });
}
