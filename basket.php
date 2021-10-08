<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc';
?>
        <main class="box-small" onclick="modalClose()">
          <div class="line"></div>
          <div class="basket-block">
            <div class="space-min"></div>
            <div class="big-font title-font title-pad">
              Ваша корзина
            </div>
            <div class="new-font size-font title-pad title-mess">
              Товары резервируются на ограниченное время
            </div>
          </div>
          <div class="flex-box flex-wrap">
            <div class="tovar flex-box box-small">
              <div>Фото</div>
              <div>Наименование</div>
            </div>
            <div class="basket-line flex-box box-small to-end">
              <div>Размер</div>
              <div>Количество</div>
              <div>Стоимость</div>
              <div>Удалить</div>
            </div>
          </div>
          <div class="line"></div>
          <form method="POST" onsubmit="return validBasket()" action="<?=PROJECT_URL?>/system/controllers/orders/create.php">
            <div id="basket-set">
              <?php if(isset($_SESSION['basket']) === false || $_SESSION['basket'] == null){
                $price_sum = 0;
                ?><div class="box">
                  Ваша корзина пуста
                </div>
              <?php }else{
                $sum = [];
                $all_goods = $_SESSION['basket'];
                foreach($all_goods as $elem){
                  $item = new Goods($elem);
                  $id = $item->getField('id');
                  $price = $item->getField('price');
                  ?><div id="<?=$id?>" class="basket flex-box flex-wrap box-small center">
                  <div class="flex-box center">
                    <div class="tovar-photo" data-id="<?=$id?>" onmouseenter="modalShow()">
                      <a class="show" href="<?=PROJECT_URL?>/card.php?id=<?=$id?>" target="_blank" onclick="modalClose()">
                        <img src="<?=PROJECT_URL.$item->getField('photo')?>" alt="Фото" />
                      </a>
                    </div>
                    <div class="box-small"></div>
                    <div>
                      <div class="big-font"><b><?=$item->getField('title')?></b></div>
                      <div>арт. <?=$item->getField('art')?></div>
                    </div>
                  </div>
                  <div class="basket-line flex-box to-end">
                    <div>
                      <?=$item->getField('razmer');
                      echo PHP_EOL?>
                    </div>
                    <label class="number">
                      <span class="number-plus" onclick="this.nextElementSibling.stepUp(); priceSum()">+</span>
                      <input type="number" name="kolichestvo[]" min="1" max="50" value="1" data-price="<?=$price?>" onchange="priceSum()" class="kol">
                      <span class="number-minus" onclick="this.previousElementSibling.stepDown(); priceSum()">-</span>
                    </label>
                    <div class="price">
                      <?php echo $price.' руб.';
                      $sum[] = $price;
                      echo PHP_EOL ?>
                    </div>
                    <div>
                      <a href="<?=PROJECT_URL?>/system/controllers/basket/delete.php?id=<?=$id?>" onclick="del(this)">
                        x
                      </a>
                    </div>
                  </div>
                </div>
                <?php }
                $price_sum = array_sum($sum);
              } echo PHP_EOL ?>
            </div>
            <div class="line"></div>
            <div class="itogo flex-box">
              <div class="basket-line flex-box to-end">
                <div>Итого:</div>
                <div class="basket-price">
                  <label for="basket" id="div-summa" style="visibility: hidden"><?=$price_sum?> руб.</label>
                  <input hidden id="basket" name="summa" value="<?=$price_sum?>">
                </div>
                <div></div>
              </div>
            </div>
            <div class="basket-img flex-box">
              <img alt="Линия" src="<?=PROJECT_URL?>/img/basket-line.png" />
            </div>
            <div class="ap-block" onclick="errUnset()">
              <div class="big-font title-font title-pad">
                Адрес доставки
              </div>
              <div class="new-font size-font title-pad title-mess">
                Все поля обязательны для заполнения
              </div>
              <div class="label">
                <label>Выберете вариант доставки
                  <select id="dostavka_set" name="dostavka">
                    <option value="500">Курьерская служба - 500 руб.</option>
                    <option value="250">Пункт самовывоза - 250 руб.</option>
                    <option value="1000">Почта России - 1000 руб.</option>
                  </select>
                </label>
              </div>
              <div class="flex-box">
                <label>Имя<input type="text" name="first_name" required></label>
                <div class="box-small"></div>
                <label>Фамилия<input type="text" name="last_name" required></label>
              </div>
              <div class="flex-box">
                <label class="label">Адрес<input type="text" name="address" required></label>
              </div>
              <div class="flex-box">
                <label>Город<input type="text" name="gorod" required></label>
                <div class="box-small"></div>
                <label>Индекс<input type="text" name="indeks" pattern="[0-9]{6}" required></label>
              </div>
              <div class="flex-box">
                <label>Телефон<input type="tel" name="tel" pattern="[+]{0,1}[0-9]{11}" required></label>
                <div class="box-small"></div>
                <label>E-Mail<input type="email" name="email" required></label>
              </div>
              <div class="space-min"></div>
            </div>
            <div class="basket-img flex-box">
              <img alt="Линия" src="<?=PROJECT_URL?>/img/basket-line.png" />
            </div>
            <div class="ap-block">
              <div class="big-font title-font title-pad">
                Варианты оплаты
              </div>
              <div class="new-font size-font title-pad title-mess">
                Все поля обязательны для заполнения
              </div>
              <div class="flex-box order box-small">
                <div>
                  Стоимость:
                </div>
                <div id="summa" class="new-font">

                </div>
              </div>
              <div class="flex-box order">
                <div>
                  Доставка:
                </div>
                <div id="dostavka_sum" class="new-font">

                </div>
              </div>
              <div class="flex-box order box-small basket-price">
                <div>
                  Итого:
                </div>
                <input hidden id="itog" name="itog" value="0">
                <div id="div-itog" class="new-font" style="visibility: hidden">

                </div>
              </div>
              <div class="space-min"></div>
              <div class="flex-box big-font oplata">
                <label>Выберете способ оплаты
                  <select name="oplata">
                    <option>Банковская карта</option>
                    <option>Яндекс.Деньги</option>
                    <option>QIWI</option>
                    <option>PayPal</option>
                    <option>WebMoney</option>
                  </select>
                </label>
              </div>
              <?php if(isset($_COOKIE['member_id']) === false) $user = 0;
              else $user = $_COOKIE['member_id'];
              ?><input hidden name="member_id" value="<?=$user?>">
              <div class="box"></div>
              <button disabled class="big-font">Заказать</button>
            </div>
          </form>
          <div id="modal-kit" class="modal-kit" onclick="modalClose()">
            <?php if(isset($_SESSION['basket']) !== false){ //Проверяем есть ли сессия с именем basket
              if(!$_SESSION['basket'] == null){ /*Если в корзине что-то есть, то включаем код для модального окна*/
                echo PHP_EOL ?>
            <div id="modal" class="modal box">

            </div>
              <?php }
            } echo PHP_EOL ?>
          </div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
