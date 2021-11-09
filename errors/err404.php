<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  $error = true;
  require_once PROJECT_ROOT.'/components/header.inc.php';
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="box-small"></div>
          <div class="menu">
            <a href="<?=PROJECT_URL?>/main.php">Главная</a> / Ошибка 404
          </div>
          <div class="box-small"></div>
          <div>
            <div>
              <h2>Ошибка 404</h2>
            </div>
            <div class="error">
              <p>Вы попали сюда т.к. страница не существует или была удалена. Вернутся на <a href="<?=PROJECT_URL?>/main.php">главную страницу</a>.</p>
            </div>
          </div>
          <div class="box-small"></div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc.php';
?>
