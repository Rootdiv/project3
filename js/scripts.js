'use strict';

//Плавная прокрутка страницы вверх
window.addEventListener('scroll', () => {
  const scrollHeight = Math.round(window.scrollY);
  if (scrollHeight < 300) document.querySelector('.go-top').style.opacity = '0';
  else document.getElementsByClassName('go-top')[0].style.opacity = '1';
});

function backToTop() {
  if (window.pageYOffset > 0) {
    window.scrollBy(0, -10);
    setTimeout(backToTop, 0);
  }
}
document.querySelector('.go-top').addEventListener('click', function() {
  backToTop();
});

document.querySelector('.logo-mobile').addEventListener('click', () => {
  document.querySelector('.menu-mobile').classList.toggle('menu-mobile-hidden');
});

//Проверка ввода e-mail и вывод сообщения при ошибке, и при успешном отправлении.
function testMail(email) {
  const mailValid = /^[a-zA-Z0-9_.\-]+@([a-z0-9\-]+\.)+[a-z]{2,6}$/i;
  return mailValid.test(email);
}

function error() {
  const errorMessages = document.querySelectorAll('.msg-error');
  for (let i = 0; i < errorMessages.length; i++) {
    errorMessages[i].parentNode.removeChild(errorMessages[i]);
  }
}

function fatalError() {
  const errorMessage = document.querySelector('button');
  errorMessage.insertAdjacentHTML('afterend', "<div class='msg-error size-font box'>Ой, что-то пошло не так.</div>");
}

function validate() {
  const formCheck = document.scribe.email.value;
  if (formCheck === '' || !testMail(formCheck)) {
    error();
    const invalidFields = document.querySelector('button');
    invalidFields.insertAdjacentHTML('afterend', '<div class="msg-error size-font box">Некорректный e-mail. Попробуйте ещё раз</div>');
    return false;
  } else {
    error();
    event.preventDefault();
    const form = document.querySelector('form');
    const data = new FormData(form);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', form.action);
    xhr.addEventListener('readystatechange', () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const str = xhr.responseText;
        if (str.indexOf('not found') !== -1 || str.indexOf('Ошибка') !== -1) fatalError();
        else {
          document.forms.scribe.email.value = '';
          const message = document.querySelector('button');
          message.insertAdjacentHTML('afterend', "<div class='msg size-font box-small'>Вы подписаны</div>");
        }
      }
    });
    xhr.send(data);
    return true;
  }
}

//Валидация форм
const form = document.querySelector('form');
const notStr = 'содержит недопустимые символы';

function errUnset() {
  for (let item of Array.from(document.querySelectorAll('input'))) {
    item.removeAttribute('style');
  }
  if (document.querySelector('textarea') !== null) {
    document.querySelector('textarea').removeAttribute('style');
  }
  document.querySelector('button').removeAttribute('style');
}

function testLogin(login) {
  const strReg = /^[a-z0-9]{4,15}$/i;
  return strReg.test(login);
}

function testPassw(passw) {
  const strReg = /^[a-zZ0-9+\-#%]{5,15}$/i;
  return strReg.test(passw);
}

function testUsername(username) {
  const strReg = /^[a-zёа-я\-\s]{2,20}$/i;
  return strReg.test(username);
}

function testNum(num) {
  const strReg = /^[0-9]+$/i;
  return strReg.test(num);
}

function errValid(msg) {
  form.insertAdjacentHTML('afterend', "<div class='msg-error size-font box'>" + msg + "</div>");
}

function errorValid(frm, msg) {
  frm.insertAdjacentHTML('beforebegin', "<div class='msg-error size-font box'>" + msg + "</div>");
}

//Валидация формы корзины
function basketError(elem, text) {
  let error = document.createElement('div');
  error.className = 'msg-error';
  error.style.textTransform = 'none';
  error.style.fontSize = '16px';
  error.innerHTML = text;
  elem.parentElement.style.paddingTop = '20px';
  document.querySelector('button').style.border = '5px solid red';
  return error;
}

//Фильтры каталога
if (document.querySelector('.catalog-sort')) {
  document.querySelector('.categories').addEventListener('click', () => {
    document.querySelector('.categories-items').classList.toggle('hidden');
    document.querySelector('.categories-img').classList.toggle('categories-img-inv');
  });

  document.querySelector('.size').addEventListener('click', () => {
    document.querySelector('.size-items').classList.toggle('hidden');
    document.querySelector('.size-img').classList.toggle('size-img-inv');
  });

  document.querySelector('.prices').addEventListener('click', () => {
    document.querySelector('.prices-items').classList.toggle('hidden');
    document.querySelector('.prices-img').classList.toggle('size-img-inv');
  });
}

//Авторизация / Регистрация
function auth(frm) {
  error();
  event.preventDefault();
  //let form = document.querySelector('form');
  const data = new FormData(frm);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', frm.action);
  xhr.addEventListener('readystatechange', () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const str = xhr.responseText;
      if (str.indexOf('not found') !== -1 || str.indexOf('Письма нет') !== -1) fatalError();
      else if (str.indexOf('Зарегистрирован') !== -1 || str.indexOf('создан') !== -1) {
        const urlReg = location.href.substring(0, location.href.lastIndexOf('/') + 1);
        location.replace(urlReg + 'login.php');
      } else if (str.indexOf('Авторизован') !== -1 || str.indexOf('отправлен') !== -1) {
        const url = location.href.substring(0, location.href.lastIndexOf('/auth/') + 1);
        location.replace(url + 'main.php');
      } else {
        const message = document.querySelector('.login');
        message.insertAdjacentHTML('afterend', "<div class='msg-error size-font box'>" + xhr.responseText + "</div>");
      }
    }
  });
  xhr.send(data);
  return true;
}

//Валидация формы Регистрации
function validReg() {
  error();
  event.preventDefault();
  const login = form.login.value;
  const name = form.username.value;
  const email = form.email.value;
  const passw = form.password;
  passw.setAttribute('type', 'password');
  document.getElementsByClassName('pass-control')[0].classList.remove('view');
  if (!testLogin(login)) {
    errValid('Логин ' + notStr);
    form.login.style.border = '3px solid red';
    return false;
  }
  if (!testUsername(name)) {
    errValid('Имя ' + notStr);
    form.username.style.border = '3px solid red';
    return false;
  }
  if (!testMail(email)) {
    errValid('E-mail ' + notStr);
    form.email.style.border = '3px solid red';
    return false;
  }
  if (!testPassw(passw.value)) {
    errValid('Пароль ' + notStr);
    form.password.style.border = '3px solid red';
    return false;
  }
  auth(form);
}

//Валидация формы Авторизации
function validAuth() {
  error();
  event.preventDefault();
  const login = form.login.value;
  const passw = form.password;
  passw.setAttribute('type', 'password');
  document.getElementsByClassName('pass-control')[0].classList.remove('view');
  if (!testMail(login)) {
    if (!testLogin(login)) {
      errValid('Поле Логин или E-mail ' + notStr);
      form.login.style.border = '3px solid red';
      return false;
    }
  }
  if (!testPassw(passw.value)) {
    errValid('Пароль ' + notStr);
    form.password.style.border = '3px solid red';
    return false;
  }
  auth(form);
}

//Валидация формы Сброса пароля
function validRestore() {
  error();
  event.preventDefault();
  const login = form.login.value;
  const email = form.email.value;
  if (!testLogin(login)) {
    errValid('Логин ' + notStr);
    form.login.style.border = '3px solid red';
    return false;
  }
  if (!testMail(email)) {
    errValid('E-mail ' + notStr);
    form.email.style.border = '3px solid red';
    return false;
  }
  auth(form);
}

function showHidePass(target) {
  const input = document.getElementById('pass-input');
  if (input.getAttribute('type') === 'password') {
    target.classList.add('view');
    input.setAttribute('type', 'text');
  } else {
    target.classList.remove('view');
    input.setAttribute('type', 'password');
  }
  return false;
}

//Функция модального окна
function modalOpen(html) {
  document.getElementById('modal-kit').style.display = 'block';
  document.getElementById('modal').innerHTML = html;
}

function modal(url, set) {
  const top = window.pageYOffset;
  if (top === 0) {
    let elem = document.getElementById('modal');
    elem.style.top = '20%';
  } else {
    let elem = document.getElementById('modal');
    elem.style.top = top + 40 + 'px';
  }
  let mod = event.target.getElementsByClassName('show');
  for (let m = 1; m <= mod.length; m++) {
    const id = event.target.getAttribute('data-id');
    const urlStr = url + '/components/modal.php?id=' + id + set;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', urlStr);
    xhr.addEventListener('readystatechange', () => { //jshint ignore:line
      if (xhr.readyState === 4 && xhr.status === 200) modalOpen(xhr.responseText);
      else modalOpen(xhr.responseText);
    });
    xhr.send();
  }
}

//Определяем переменную url для модального окна в админке
let url = location.href.substring(0, location.href.lastIndexOf('/admin/'));
//Вызов модального окна для редактирования товара
function tovarModalShow(tid) {
  modal(url, '&tovar=' + tid + '&user=false');
}

//Вызов модального окна для редактирования пользователя
function userModalShow() {
  modal(url, '&user=edit&tovar=false');
}

//Редактирования пользователя или товара и вывод сообщения при ошибке.
function edit(frm) {
  error();
  event.preventDefault();
  //let form = document.querySelector('#edit');
  const data = new FormData(frm);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', frm.action);
  xhr.addEventListener('readystatechange', () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const str = xhr.responseText;
      if (str.indexOf('Обновлено') !== -1 || str.indexOf('успешно') !== -1) location.reload();
      else if (document.getElementById('modal-kit') !== null)
        modalOpen('<div class="modal-close" onclick="modalClose()">+</div>' + xhr.responseText);
      else if (str.indexOf('not found') !== -1) fatalError();
      else frm.insertAdjacentHTML('afterend', "<div class='msg-error size-font box'>" + xhr.responseText + "</div>");
    }
  });
  xhr.send(data);
  return true;
}

//Валидация формы редактирования в профиле пользователя
function validEdit() {
  error();
  event.preventDefault();
  const userID = form.querySelector('input[name=id]').value;
  const username = form.username.value;
  const email = form.email.value;
  const passw = form.password.value;
  if (!testNum(userID) || userID === '0') {
    alert('Ошибка');
    location.reload();
    return false;
  }
  if (username === '' || !testUsername(username)) {
    errValid('Имя ' + notStr);
    form.username.style.border = '2px solid red';
    return false;
  }
  if (email === '' || !testMail(email)) {
    errValid('E-mail ' + notStr);
    form.email.style.border = '2px solid red';
    return false;
  }
  if (passw !== '') {
    if (!testPassw(passw)) {
      errValid('Пароль ' + notStr);
      form.password.style.border = '2px solid red';
      return false;
    }
  }
  edit(form);
}

//Валидация форм в админке
function validID(id) {
  if (!testNum(id) || id === '0') {
    alert('Ошибка');
    location.reload();
    return false;
  }
  return true;
}

function tovarEdit() {
  error();
  event.preventDefault();
  const formEdit = document.querySelector('#edit');
  const photo = formEdit.photo.value;
  const title = formEdit.title.value;
  const art = formEdit.art.value;
  const description = formEdit.description.value;
  const price = formEdit.price.value;
  const category = formEdit.category.value;
  const categories = formEdit.categories.value;
  const razmer = formEdit.razmer.value;
  if (photo !== '') {
    const photoName = formEdit.photo.files[0].name.split('\\');
    const photoNameValid = /^[a-z0-9._-]+$/i;
    if (!photoNameValid.test(photoName)) {
      errorValid(formEdit, 'Имя файла ' + notStr);
      formEdit.photo.style.border = '2px solid red';
      return false;
    }
    const photoInfo = formEdit.photo.files[0].name.split('.').pop();
    const extVlaid = ['jpg', 'png', ];
    if (!extVlaid.includes(photoInfo)) {
      errorValid(formEdit, 'Неправильный файл');
      formEdit.photo.style.border = '2px solid red';
      return false;
    }
    const photoSize = formEdit.photo.files[0].size;
    if (photoSize < 25600) {
      errorValid(formEdit, 'Картинка слишком маленькая');
      formEdit.photo.style.border = '2px solid red';
      return false;
    } else if (photoSize > 5242880) {
      errorValid(formEdit, 'Картинка слишком большая');
      formEdit.photo.style.border = '2px solid red';
      return false;
    }
  }
  const titleValid = /^[a-zёа-я\s]{2,50}$/i;
  if (!titleValid.test(title) || title === '') {
    errorValid(formEdit, 'Наименование ' + notStr + ' или не указано');
    formEdit.title.style.border = '2px solid red';
    return false;
  }
  if (!testNum(art) || art === '0') {
    errorValid(formEdit, 'Артикул не может содержать буквы');
    formEdit.art.style.border = '2px solid red';
    return false;
  }
  if (!testNum(price) || price === '0') {
    errorValid(formEdit, 'Цена не может содержать буквы');
    formEdit.price.style.border = '2px solid red';
    return false;
  }
  const descriptionValid = /^[a-zёа-я\s.!]{2,150}$/i;
  if (!descriptionValid.test(description) || description === '') {
    errorValid(formEdit, 'Описание ' + notStr + ' или не указано');
    formEdit.description.style.border = '2px solid red';
    return false;
  }
  if (!testNum(category) || category === '0') {
    alert('Неправильная категория или подкатегория');
    location.reload();
    return false;
  }
  if (!testNum(categories) || categories === '0') {
    alert('Неправильная категория или подкатегория');
    location.reload();
    return false;
  }
  if (!testNum(razmer) || razmer === '0') {
    errorValid(formEdit, 'Размер не должен содержать буквы');
    formEdit.razmer.style.border = '2px solid red';
    return false;
  }
  edit(formEdit);
}

function validTovarAdd() {
  error();
  event.preventDefault();
  const formAdd = document.querySelector('#edit');
  const tableID = formAdd.tableID.value;
  const photo = formAdd.photo.value;
  if (validID(tableID)) //Если значение tableID неправильное функция прерывается и сообщает об ошибке
    if (photo === '') {
      errorValid(formAdd, 'Файл не выбран');
      formAdd.photo.style.border = '2px solid red';
      return false;
    }
  tovarEdit();
}

function validTovarEdit() {
  error();
  event.preventDefault();
  const formEdit = document.querySelector('#edit');
  const tableID = formEdit.tableID.value;
  const tovarID = formEdit.querySelector('input[name=id]').value;
  if (validID(tableID)); //Если значение tableID неправильное функция прерывается и сообщает об ошибке
  if (validID(tovarID)); //Если значение tovarID неправильное функция прерывается и сообщает об ошибке
  tovarEdit();
}

//Валидация формы редактирования пользователя в админке
function validUserEdit() {
  error();
  event.preventDefault();
  const formUserEdit = document.querySelector('#edit');
  const userID = formUserEdit.querySelector('input[name=id]').value;
  const username = formUserEdit.username.value;
  const adm = formUserEdit.adm.value;
  const email = formUserEdit.email.value;
  const passw = formUserEdit.password.value;
  if (!testNum(userID) || userID === '0') {
    alert('Ошибка');
    location.reload();
    return false;
  }
  if (!testUsername(username) || username === '') {
    errorValid(formUserEdit, 'Имя ' + notStr);
    formUserEdit.username.style.border = '2px solid red';
    return false;
  }
  if (!testNum(adm)) {
    alert('Неправильное назначение');
    location.reload();
    return false;
  }
  if (!testMail(email) || email === '') {
    errorValid(formUserEdit, 'E-mail ' + notStr);
    formUserEdit.email.style.border = '2px solid red';
    return false;
  }
  if (passw !== '') {
    if (!testPassw(passw)) {
      errorValid(formUserEdit, 'Пароль ' + notStr);
      formUserEdit.password.style.border = '2px solid red';
      return false;
    }
  }
  edit(formUserEdit);
}

function modalClose() {
  document.getElementById('modal-kit').style.display = 'none';
}

if (document.getElementById('modal-kit')) {
  document.addEventListener('keydown', function(event) {
    if (event.code === 'Escape' || event.keyCode === 27) modalClose();
  });
}

//Модальное окно на странице корзины, если устройство без тач-скрина
function modalShow() {
  function isTouchDevice() {
    return ('ontouchstart' in window) || ('onmsgesturechange' in window);
  }

  if (isTouchDevice() !== true) {
    let url = location.href.substring(0, location.href.lastIndexOf('/'));
    modal(url, '');
  }
}

//Считаем сумму с доставкой
function dostavka() {
  document.getElementById('summa').textContent = document.getElementById('div-summa').textContent;
  const summa = document.getElementById('basket').value;
  const ds = document.getElementById('dostavka_set').value;
  const itog = parseInt(summa) + parseInt(ds);
  document.getElementById('div-itog').textContent = itog + ' руб.';
  document.getElementById('itog').setAttribute('value', itog);
}

function setID() {
  let k = 0;
  const idKol = document.querySelectorAll('.kol');
  idKol.forEach(element => {
    k++;
    element.setAttribute('id', 'kol' + k);
  });
  let p = 0;
  const idPrice = document.querySelectorAll('.price');
  idPrice.forEach(element => {
    p++;
    element.setAttribute('id', 'price' + p);
  });
}

//Сумма товара/товаров с доставкой и отправка заказа
if (document.getElementById('dostavka_set')) {
  //Если в корзине есть хотя бы один товар показываем скрытые элементы
  if (document.getElementById('basket').value !== '0') {
    document.getElementById('div-summa').removeAttribute('style');
    document.getElementById('div-itog').removeAttribute('style');
    //Разрешаем отправку формы и присваиваем id нужным пунктам в списке товаров
    document.querySelector('button').removeAttribute('disabled');
    setID();
  }
  //Получаем стоимость доставки и считаем сумму только если есть товар(ы) в корзине
  const dl = document.getElementById('dostavka_set').value;
  document.getElementById('dostavka_sum').textContent = dl + ' руб.';
  if (document.getElementById('basket').value !== '0') dostavka();

  //При изменении стоимости доставки считаем сумму только если есть товар(ы) в корзине
  document.getElementById('dostavka_set').addEventListener('change', function() {
    const d = this.value;
    document.getElementById('dostavka_sum').textContent = d + ' руб.';
    if (document.getElementById('basket').value !== '0') dostavka();
  });
}

//Считаем сумму с доставкой если количество товара больше 1
function priceSum() {
  const inp = document.getElementsByClassName('kol');
  let sum = 0;
  for (let i = 1; i <= inp.length; i++) {
    const val = 'kol' + i;
    const v = document.getElementById(val).value;
    if (v === '' || v < 1 || v > 50) {
      alert('Количество не может быть меньше 1 или быть больше 50');
      location.reload();
    } else {
      const p = document.getElementById(val).getAttribute('data-price');
      const pSum = parseInt(v) * parseInt(p);
      const str = 'price' + i;
      document.getElementById(str).textContent = pSum + ' руб.';
      sum += parseInt(pSum);
    }
  }
  document.getElementById('div-summa').textContent = sum + ' руб.';
  document.getElementById('basket').setAttribute('value', sum);
  dostavka();
}

//Функция удаления товара из корзины
function del(elem) {
  event.preventDefault();
  const del = elem.getAttribute('href');
  const id = del.split('=').pop();
  const basket = document.getElementById('basket_set');
  const basStr = basket.innerHTML.split('(');
  const xhr = new XMLHttpRequest();
  xhr.open('GET', del);
  xhr.addEventListener('readystatechange', () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.getElementById(id).remove();
      let num = parseInt(basStr[1]) - 1;
      if (num !== 0) {
        basket.innerHTML = basStr[0] + '(' + num + ')';
        setID();
        priceSum();
      } else {
        basket.innerHTML = basStr[0] + '(0)';
        document.getElementById('basket-set').innerHTML = '<div class="box">Ваша корзина пуста</div>';
        document.getElementById('div-summa').style.visibility = 'hidden';
        location.reload(); //Перезагружаем страницу если корзина пуста
      }
    }
  });
  xhr.send();
}

//Форма корзины
function order(frm) {
  error();
  event.preventDefault();
  //let form = document.querySelector('form');
  const data = new FormData(frm);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', frm.action);
  const load = document.querySelector('button');
  const url = location.href.substring(0, location.href.lastIndexOf('/'));
  load.insertAdjacentHTML('afterend', '<div class="loader box"><img src="' + url + '/img/loader.svg" alt="Обработка..."/></div>');
  xhr.addEventListener('readystatechange', () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const str = xhr.responseText;
      if (str.indexOf('ошибка') !== -1) {
        document.querySelector('.loader').remove();
        fatalError();
      } else if (str.indexOf('Заказ') !== -1) {
        document.getElementById('summa').style.visibility = 'hidden';
        document.getElementById('div-itog').style.visibility = 'hidden';
        document.querySelector('.loader').remove();
        const mess = document.getElementsByTagName('button')[0];
        mess.insertAdjacentHTML('afterend', "<div class='msg size-font box'>" + xhr.responseText + "</div>");
        setTimeout(function() {
          location.replace(location.href);
        }, 2500);
      } else {
        document.querySelector('.loader').remove();
        document.querySelector('button').style.border = '5px solid red';
        const error = document.getElementsByClassName('ap-block')[0];
        error.insertAdjacentHTML('beforebegin', "<div class='msg-error size-font box'>" + xhr.responseText + "</div>");
      }
    }
  });
  xhr.send(data);
}
//Валидация формы корзины
function validBasket() {
  for (const item of Array.from(document.querySelectorAll('label'))) {
    item.removeAttribute('style');
  }
  error();
  const kolichestvo = document.getElementsByClassName('kol');
  const summa = form.summa.value;
  const dostavka = form.dostavka;
  const set = dostavka.options[dostavka.selectedIndex].value;
  const firstName = form.firstName;
  const lastName = form.lastName;
  const address = form.address;
  const gorod = form.gorod;
  const indeks = form.indeks;
  const tel = form.tel;
  const email = form.email;
  const itog = form.itog.value;
  const oplata = form.oplata.value;
  for (let i = 1; i <= kolichestvo.length; i++) {
    const val = 'kol' + i;
    const v = document.getElementById(val).value;
    if (v === '' || v < 1 || v > 50) {
      alert('Количество не может быть меньше 1 или быть больше 50');
      location.reload();
      return false;
    }
  }
  if (!testNum(summa) || summa === '0') {
    alert('Ошибка! Значение изменено вручную!');
    location.reload();
    return false;
  }
  if (!testNum(set) || set === '0') {
    alert('Ошибка! Значение изменено вручную!');
    location.reload();
    return false;
  }
  if (set !== '500' && set !== '250' && set !== '1000') {
    alert('Ошибка! Значение изменено вручную!');
    location.reload();
    return false;
  }
  const firstNameValid = /^[a-zёа-я\-\s]{2,35}$/i;
  if (!firstNameValid.test(firstName.value) || firstName.value === '') {
    let error = basketError(firstName, 'Имя ' + notStr);
    firstName.parentElement.insertBefore(error, firstName);
    firstName.style.border = '2px solid red';
    return false;
  }
  const lastNameValid = /^[a-zёа-я\-\s]{2,20}$/i;
  if (!lastNameValid.test(lastName.value) || lastName.value === '') {
    let error = basketError(lastName, 'Фамилия ' + notStr);
    lastName.parentElement.insertBefore(error, lastName);
    lastName.style.border = '2px solid red';
    return false;
  }
  const addressValid = /^[a-zёа-я\-.,\s0-9]{2,50}$/i;
  if (!addressValid.test(address.value) || address.value === '') {
    let error = basketError(address, 'Адрес ' + notStr);
    address.parentElement.insertBefore(error, address);
    address.style.border = '2px solid red';
    return false;
  }
  const gorodValid = /^[a-zёа-я\-.\s]{2,20}$/i;
  if (!gorodValid.test(gorod.value) || gorod.value === '') {
    let error = basketError(gorod, 'Город ' + notStr);
    gorod.parentElement.insertBefore(error, gorod);
    gorod.style.border = '2px solid red';
    return false;
  }
  const indexValid = /^[0-9]{6}$/i;
  if (!indexValid.test(indeks.value) || indeks.value === '') {
    let error = basketError(indeks, 'Недопустимый формат индекса');
    indeks.parentElement.insertBefore(error, indeks);
    indeks.style.border = '2px solid red';
    return false;
  }
  const telValid = /^[+]?[0-9]{11}$/i;
  if (tel === '' || !telValid.test(tel.value)) {
    let error = basketError(tel, 'Недопустимый формат номера');
    tel.parentElement.insertBefore(error, tel);
    tel.style.border = '2px solid red';
    return false;
  }
  if (!testMail(email.value)) {
    let error = basketError(email, 'E-mail ' + notStr);
    email.parentElement.insertBefore(error, email);
    email.style.border = '2px solid red';
    return false;
  }
  if (!testNum(itog) || itog === '0') {
    alert('Ошибка! Значение изменено вручную!');
    location.reload();
    return false;
  }
  const oplataValid = /^[a-zёа-я.\s]{4,20}$/i;
  if (!oplataValid.test(oplata) || oplata === '') {
    alert('Ошибка! Значение изменено вручную!');
    location.reload();
    return false;
  }
  order(form);
}

//Форма обратной связи
function feedback(frm) {
  error();
  event.preventDefault();
  //let form = document.querySelector('form');
  const data = new FormData(frm);
  const xhr = new XMLHttpRequest();
  xhr.open('POST', frm.action);
  xhr.addEventListener('readystatechange', () => {
    if (xhr.readyState === 4 && xhr.status === 200) {
      const str = xhr.responseText;
      if (str.indexOf('not found') !== -1) {
        frm.insertAdjacentHTML('beforebegin', "<div class='msg-error size-font box'>Ой, что-то пошло не так.</div>");
      } else if (str.indexOf('Успешно') !== -1) {
        document.querySelector('form').reset();
        frm.insertAdjacentHTML('beforebegin', "<div class='msg size-font box-small'>Сообщение успешно отправлено.</div>");
      } else {
        frm.insertAdjacentHTML('beforebegin', "<div class='msg-error size-font box'>" + xhr.responseText + "</div>");
      }
    }
  });
  xhr.send(data);
  return true;
}
//Валидация формы обратной связи
function validFeedback() {
  error();
  event.preventDefault();
  const admMsg = form.admMsg;
  const name = form.fio.value;
  const email = form.email.value;
  const tel = form.tel.value;
  const message = form.text.value;
  if (!testNum(admMsg.value) || admMsg.value === '0') {
    alert('Ошибка');
    location.reload();
    return false;
  }
  const nameValid = /^[a-zёа-я\-\s]{2,50}$/i;
  if (!nameValid.test(name) || name === '') {
    errorValid(form, 'Поле ФИО ' + notStr);
    form.fio.style.border = '2px solid red';
    return false;
  }
  if (!testMail(email) || email === '') {
    errorValid(form, 'E-mail ' + notStr);
    form.email.style.border = '2px solid red';
    return false;
  }
  const telValid = /^[+]?[0-9]{11}$/i;
  if (!telValid.test(tel) || tel === '') {
    errorValid(form, 'Недопустимый формат номера');
    form.tel.style.border = '2px solid red';
    return false;
  }
  const text = /[$\[\]*{}]+/i;
  if (text.test(message) || message === '') {
    form.text.style.border = '2px solid red';
    errorValid(form, 'Сообщение ' + notStr);
    return false;
  }
  if (message.length < 15 || message.length > 2000) {
    form.text.style.border = '2px solid red';
    errorValid(form, 'Сообщение не может превышать 2000 символов или быть менее 20 символов');
    return false;
  }
  feedback(form);
}

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
