<?php
if (isset($_GET['routed'])) {
  $get_line = '';
  foreach ($_GET as $key => $value) {
    if ($key != 'routed') {
      $get_line .= $key . '=' . $value . '&';
    }
  }
  header('Location: ' . PROJECT_URL . '/admin/orders.php?' . trim($get_line, '&'));
}
//Данные для пагинации
$per_page = 4;
$page_num = 1;
if (isset($_GET['page_num']) && !empty($_GET['page_num'])) {
  $page_num = $_GET['page_num'];
}
if (!preg_match('/^[0-9]+$/s', $page_num)) {
  $page_num = 1;
}

$user = new Member();
$table = $user->setTable();
$sql_user = $pdo->prepare("SELECT * FROM $table WHERE adm>0");
$sql_user->execute();
$root = [];
$manager = [];
$admin_mail = [];
$manager_mail = [];
$item = $sql_user->fetchAll();
foreach ($item as $adm) {
  if ($adm['adm'] === '1') {
    $root[] = $adm['id'];
    $admin_mail[] = $adm['email'];
  } elseif ($adm['adm'] === '2') {
    $manager[] = $adm['id'];
    $manager_mail[] = $adm['email'];
  }
}
//Меню на странице профиля и в админке.
$menu = '';
$user_id = '';
$username = '';
if (isset($_COOKIE["member_id"])) {
  $user_id = $_COOKIE["member_id"];
  $name_user = new Member($_COOKIE["member_id"]);
  $username = $name_user->getField('username');
}
if (in_array($user_id, $root)) {
  $menu = '<div class="flex-box flex-wrap box-small">
            <a href="' . PROJECT_URL . '/profile.php">Профиль</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/profile.php?history=1&page_num=1">История</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/orders.php?orders=act&page_num=1">Заказы</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/goods.php?page_num=1">Товары</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/messages.php?adm=1&page_num=1">Сообщения</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/users.php?page_num=1">Пользователи</a>
          </div>' . PHP_EOL;
} elseif (in_array($user_id, $manager)) {
  $menu = '<div class="flex-box flex-wrap box-small">
            <a href="' . PROJECT_URL . '/profile.php">Профиль</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/profile.php?history=1&page_num=1">История</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/orders.php?orders=act&page_num=1">Заказы</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/goods.php?page_num=1">Товары</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/messages.php?page_num=1">Сообщения</a>
          </div>' . PHP_EOL;
} else {
  $menu = '<div class="flex-box flex-wrap box-small">
            <a href="' . PROJECT_URL . '/profile.php">Профиль</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/profile.php?history=1&page_num=1">История</a>
          </div>' . PHP_EOL;
}
//Меню, переменные для SQL запроса и пагинации на странице сообщений.
$adm = '';
$limit = null;
$adm_msg = 'adm_msg=2';
$adm_msg_menu = '<div class="box-small"></div>';
if (in_array($user_id, $root) && in_array(isset($_GET['adm']), array(1, 2, 3))) {
  if ($_GET['adm'] == 1) {
    $adm_msg = 'adm_msg=1';
    $adm = 'adm=1&';
  } elseif ($_GET['adm'] == 2) {
    $adm_msg = 'adm_msg=2';
    $adm = 'adm=2&';
  } else {
    $adm_msg = 'adm_msg>0';
    $adm = 'adm=3&';
  }
  $adm_msg_menu = '<div class="flex-box flex-wrap box-small">
            <a href="' . PROJECT_URL . '/admin/messages.php?adm=1&page_num=1">Администраторам</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/messages.php?adm=2&page_num=1">Менеджерам</a>
            <div class="box-small"></div>
            <a href="' . PROJECT_URL . '/admin/messages.php?adm=3&page_num=1">Все сообщения</a>
          </div>';
}
