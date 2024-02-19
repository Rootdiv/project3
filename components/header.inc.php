<?php
  $url_parts = parse_url($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  $parts = explode('/', $url_parts['path']);
  $filename = $parts[count($parts) - 1];
  $filename = array_pop($parts);
  if (empty($filename) && isset($index)) {
    $title = 'Проверка...';
  } else {
    if (!isset($error)) {
      $page = new Page();
      $page->getIdByName($filename);
      $title = $page->getField('title');
    } else {
      $title = 'Ошибка';
    }
  }

  session_start(); //Старт сессии и создание пустой корзины.
  isset($_SESSION['basket']) ?: $_SESSION['basket'] = [];

  $login_status = '<a href="' . PROJECT_URL . '/auth/login.php"><img src="' . PROJECT_URL . '/img/icons/account.png"
    alt="Аккаунт"/>Войти</a>';
  if (isset($_COOKIE['member_id']) && !empty($_COOKIE['member_id'])) {
    $auth_user = new Member($_COOKIE["member_id"]);
    $name = $auth_user->getField('username');
    $login_status = '<img src="' . PROJECT_URL . '/img/icons/account.png" alt=""/>Привет, <a href="'
      . PROJECT_URL . '/profile.php">' . $name . '</a>';
    $login_status .= ' (<a href="' . PROJECT_URL . '/system/controllers/users/logout.php"
      style="color: #ffa500">выйти</a>)';
    $auth_user->isValid();
  }
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="description" content="Интернет-магазин создан в учебных целях, никакие товары на сайте не продаются" />
    <link rel="shortcut icon" href="<?=PROJECT_URL;?>/img/icons/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?=PROJECT_URL;?>/css/styles.css" />
    <script defer src="<?=PROJECT_URL;?>/js/main.js"></script>
    <title>Проект 3. <?=$title;?></title>
  </head>
  <body>
    <div class="go-top">
      <b>&uarr;</b>
    </div>
    <div class="global-container">
      <div class="container box">
        <header class="header">
          <div class="logo box-small">
            <a href="<?=PROJECT_URL;?>/main.php">
              <img src="<?=PROJECT_URL;?>/img/icons/logo.jpg" alt="Лого" />
            </a>
          </div>
          <div class="top-nav box-small menu-mobile menu-mobile-hidden">
            <div>
              <nav>
                <ul>
                  <li>
                    <a href="<?=PROJECT_URL;?>/catalog.php?category=1&page_num=1">Женщинам</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL;?>/catalog.php?category=2&page_num=1">Мужчинам</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL;?>/catalog.php?category=3&page_num=1">Детям</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL;?>/catalog.php?page_num=1">Новинки</a>
                  </li>
                  <li>
                    <a href="<?=PROJECT_URL;?>/about.php">О нас</a>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="to-end">
              <nav>
                <ul>
                  <li><?=$login_status;?></li>
                  <li>
                    <a id="basket-set" href="<?=PROJECT_URL;?>/basket.php">
                      <img src="<?=PROJECT_URL;?>/img/icons/basket.png" alt="Корзина" />Корзина (<?php
                      echo (empty($_SESSION['basket'])) ? 0 : count($_SESSION['basket']);?>)
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
