//Компиляция Sass и подключение JS-модулей через Webpack
'use strict';

import './sass/styles.sass'

import arrowTop from './modules/arrowTop.js'
import menu from './modules/menu.js'
import catalog from './modules/catalog.js'
import basket from './modules/basket.js'
import validForm from './modules/validForm.js'
import sendForm from './modules/sendForm.js'
import showHidePass from './modules/showHidePass.js'
import editProductOrUser from './modules/editProductOrUser.js'
import yaMap from './modules/yaMap.js'

arrowTop();
menu();
catalog();
basket()
validForm();
sendForm();
showHidePass();
editProductOrUser();
yaMap();
