import modalShow from './modalShow.js';
//Корзина

const basket = () => {
  'use strict';
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
    const deleteProduct = target => {
      const deleteUrl = target.getAttribute('href');
      const id = deleteUrl.split('=').pop();
      const basStr = basketSet.innerHTML.split('(');
      fetch(deleteUrl).then(response => {
        if (response.status !== 200) {
          throw new Error('Status network not 200');
        }
        document.getElementById(id).remove();
        const num = parseInt(basStr[1]) - 1;
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

    basketBlock.addEventListener('click', event => {
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
    basketElem.addEventListener('mouseover', event => {
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

export default basket;
