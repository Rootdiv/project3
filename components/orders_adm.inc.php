<?php
$orders = '<div class="flex-box flex-wrap box-small">
              <a href="' . PROJECT_URL . '/admin/orders.php?orders=act&page_num=1">Текущие заказы</a>
              <div class="box-small"></div>
              <a href="' . PROJECT_URL . '/admin/orders.php?orders=end&page_num=1">Завершённые заказы</a>
              <div class="box-small"></div>
              <a href="' . PROJECT_URL . '/admin/orders.php?orders=all&page_num=1">Все заказы</a>
            </div>';
if ($_GET['orders'] === 'end' && in_array($user_id, $root)) { //Выводим только завершённые заказы для админа
  $end = "status='end'";
  $all = '';
  $act = '';
} elseif ($_GET['orders'] === 'all' && in_array($user_id, $root)) { //Выводим все заказы для админа
  $end = '';
  $all = "status='end' OR status='new' OR status LIKE 'act%'";
  $act = '';
} else {
  $end = '';
  $all = '';
  $act = "status LIKE 'act%' OR status='new'";
}
$count = $pdo->query("SELECT COUNT(*) FROM orders WHERE $act $end $all")->fetchColumn();
$list = null;
