<?php
  $url_parts = parse_url($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  $parts = explode('/', $url_parts['path']);
  $filename = $parts[count($parts) - 1];
  $filename = array_pop($parts);
  if($filename == null) $title = 'Админ панель';
  else{
    $page = new Page();
    $page->getIdByName($filename);
    $title = $page->getField('title');
  }

  $per_page = 4; //Данные для пагинации
  if(isset($_GET['page_num'])) $page_num = $_GET['page_num'];
  if(!isset($page_num) || $page_num < 1) $page_num = 1;
  if(!preg_match('/^[0-9]+$/s', $page_num)) $page_num = 1;

  if(isset($_COOKIE['member_id']) === false){
    $login_set = '<a href="'.PROJECT_URL.'/auth/login.php"><img src="'.PROJECT_URL.'/img/icons/account.png" alt="Аккаунт"/>Войти</a>';
  }else{
    $auth_user = new Member($_COOKIE["member_id"]);
    $name = $auth_user->getField('username');
    $login_set = '<img src="'.PROJECT_URL.'/img/icons/account.png" alt=""/>Привет, <a href="'.PROJECT_URL.'/profile.php">'.$name.'</a>';
    $login_set .= ' (<a href="'.PROJECT_URL.'/system/controllers/users/logout.php" style="color: orange">выйти</a>)';
    $auth_user->is_valid();
  }
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="shortcut icon" href="<?=PROJECT_URL?>/img/icons/favicon.ico" type="image/x-icon">
    <title>Проект 3. <?=$title?></title>
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL?>/css/styles.css">
  </head>
  <body>
    <div class="go-top">
      <b>&uarr;</b>
    </div>
    <div class="global-container">
      <div class="container box">
        <header class="header">
          <div class="logo box-small">
            <a href="<?=PROJECT_URL?>/main.php">
              <img src="<?=PROJECT_URL?>/img/icons/logo.jpg" alt="" />
            </a>
          </div>
          <div class="top-nav box-small menu-mobile menu-mobile-hidden">
            <div>
              <nav>
                <ul>
                  <li>
                    <a href="<?=PROJECT_URL?>/catalog.php?category=1&page_num=1">Женщинам</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL?>/catalog.php?category=2&page_num=1">Мужчинам</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL?>/catalog.php?category=3&page_num=1">Детям</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL?>/catalog.php?page_num=1">Новинки</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL?>/about.php">О нас</a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="to-end">
              <nav>
                <ul>
                  <li><?=$login_set?></li>
                  <li>
                    <a id="basket_set" href="<?=PROJECT_URL?>/basket.php">
                      <img src="<?=PROJECT_URL?>/img/icons/basket.png" alt="Корзина" />Корзина (<?php session_start();
                      echo (isset($_SESSION['basket'])) ? count($_SESSION['basket']) : 0; ?>)
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="logo-mobile box-small">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </header>
