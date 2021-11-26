<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  require_once PROJECT_ROOT . '/components/header.inc.php';
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="menu">
            <a href="<?=PROJECT_URL;?>/main.php">Главная</a> / О нас
          </div>
          <h3>Учебный Проект 3</h3>
          <div class="box-small">
            <p class="about">
              Интернет-магазин с применением объектно-ориентированного программирования для ввода в базу данных и вывода
              из базы данных, ajax-запросами, интеграцией с Telegram-ботом, уведомления о заказах приходят на почту в
              Telegram-бота. Сделана регистрации с возможностью восстановить пароль через почту, профиль пользователя и
              админ панель.
            </p>
            <p class="about">
              Профиль пользователя объединён с админ панелью, при этом обычный пользователь не видит то, что видит
              менеджер и менеджер не видит то, что видит администратор.
            </p>
          </div>
          <div class="box-small"></div>
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
