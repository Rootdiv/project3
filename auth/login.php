<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc';
  if(isset($_COOKIE['member_id'])) header('Location: '.PROJECT_URL.'/main.php');
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="box-small"></div>
          <?php if(isset($_GET['reg']) == false){ echo PHP_EOL ?>
            <div class="menu">
              <a href="<?=PROJECT_URL?>/main.php">Главная</a> / Авторизация
            </div>
            <div class="box-small"></div>
            <form class="login" method="POST" action="<?=PROJECT_URL?>/system/controllers/users/auth.php">
              <div class="flex-box center size-font">
                <label>Логин или E-mail<input type="text" name="login" required></label>
                <div class="box-small"></div>
                <label class="pass">Пароль
                  <input id="pass-input" type="password" name="password" required>
                  <span class="pass-control"></span>
                </label>
                <div class="box"></div>
                <label>
                  <button class="size-font">Авторизация</button>
                </label>
              </div>
            </form>
            <div class="box-small flex-box" style="justify-content: space-between">
              <a href="<?=PROJECT_URL?>/auth/login.php?reg=1">Зарегистрироваться</a>
              <div class="box-small"></div>
              <a href="<?=PROJECT_URL?>/auth/login.php?reg=reset">Забыл пароль</a>
            </div>
          <?php }
          elseif($_GET['reg'] == '1'){ echo PHP_EOL ?>
            <div class="menu">
              <a href="<?=PROJECT_URL?>/main.php">Главная</a> / Регистрация
            </div>
            <div class="box-small"></div>
            <form class="login" method="POST" action="<?=PROJECT_URL?>/system/controllers/users/create.php">
              <div class="flex-box center size-font">
                <label>Логин<input type="text" name="login" autocomplete="off" required></label>
                <div class="box-small"></div>
                <label>Имя<input type="text" name="username" autocomplete="off" required></label>
                <div class="box-small"></div>
                <label>E-mail<input type="email" name="email" autocomplete="off" required></label>
                <div class="box-small"></div>
                <label class="pass">Пароль
                  <input id="pass-input" type="password" name="password" autocomplete="off" required>
                  <span class="pass-control"></span>
                </label>
                <div class="box"></div>
                <label>
                  <button class="size-font">Регистрация</button>
                </label>
              </div>
            </form>
            <div class="box-small flex-box" style="justify-content: space-between">
              <a href="<?=PROJECT_URL?>/auth/login.php">Войти</a>
              <div class="box-small"></div>
              <a href="<?=PROJECT_URL?>/auth/login.php?reg=reset">Забыл пароль</a>
            </div>
          <?php }
          else{ echo PHP_EOL ?>
            <div class="menu">
              <a href="<?=PROJECT_URL?>/main.php">Главная</a> / Сброс пароля
            </div>
            <div class="box-small"></div>
            <div class="box-small">
              Для сброса пароля необходимо ввести логин и e-mail указанный при регистрации. Новый пароль будет выслан на
              почту.
            </div>
            <div class="box-small"></div>
            <form class="login" method="POST" action="<?=PROJECT_URL?>/system/controllers/users/restore.php">
              <div class="flex-box center size-font">
                <label>Логин<input type="text" name="login" autocomplete="off" required></label>
                <div class="box-small"></div>
                <label>E-mail<input type="email" name="email" autocomplete="off" required></label>
                <div class="box"></div>
                <label>
                  <button class="size-font">Сбросить пароль</button>
                </label>
              </div>
            </form>
            <div class="box-small flex-box" style="justify-content: space-between">
              <a href="<?=PROJECT_URL?>/auth/login.php">Войти</a>
              <div class="box-small"></div>
              <a href="<?=PROJECT_URL?>/auth/login.php?reg=1">Зарегистрироваться</a>
            </div>
          <?php } echo PHP_EOL ?>
          <div class="box-small"></div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
