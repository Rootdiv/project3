<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc.php';
?>
        <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=<?=API_KEY?>" type="text/javascript"></script>
        <main class="box-small">
          <div class="line"></div>
          <div class="box-small"></div>
          <div class="menu">
            <a href="<?=PROJECT_URL?>/main.php">Главная</a> / Контакты
          </div>
          <div class="box-small"></div>
          <div>
            <div>
              <h3>Контакты</h3>
            </div>
            <div class="contacts flex-box box-small">
              <?php $global_info = new Global_info(1);
              ?><div class="contacts-info">
                <div class="contacts-address">
                  <div>
                    <img src="<?=PROJECT_URL?>/img/icons/placeholder.png" alt="Адрес" />
                  </div>
                  <address class="contacts-text"><b>Адрес:</b><br><?=$global_info->getField('address')?></address>
                </div>
                <div class="contacts-email">
                  <div>
                    <img src="<?=PROJECT_URL?>/img/icons/mail.png" alt="Email" />
                  </div>
                  <div class="contacts-text"><b>Телефон:</b><br><?=$global_info->getField('phone')?></div>
                </div>
                <div class="contacts-phone">
                  <div>
                    <img src="<?=PROJECT_URL?>/img/icons/telephone.png" alt="Телефон" />
                  </div>
                  <div class="contacts-text"><b>E-mail:</b><br><?=$global_info->getField('email')?></div>
                </div>
              </div>
              <div class="contacts-form">
                <div>
                  <b>Обратная связь</b>
                </div>
                <form name="contacts" method="POST" action="<?=PROJECT_URL?>/system/controllers/feedback/create.php">
                  <select name="adm_msg">
                    <option value="1">Администрация</option>
                    <option value="2">Менеджеры</option>
                  </select>
                  <input class="input-text" type="text" name="fio" required placeholder="ФИО">
                  <input class="input-text" type="email" name="email" required placeholder="E-mail">
                  <input class="input-text" type="tel" name="phone" required placeholder="Телефон">
                  <textarea name="text" required placeholder="Ваше сообщение"></textarea>
                  <button class="size-font">Отправить</button>
                </form>
              </div>
            </div>
            <div id="map">

            </div>
          </div>
          <div class="box-small"></div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc.php';
?>
