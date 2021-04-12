<?php
$sql_orders = [];
$page_num = '';
if(isset($_GET['page_num']) == false || $_GET['page_num'] == 0) $page_num = 1;
else $page_num = $_GET['page_num'];

$orders = '<div class="flex-box flex-wrap box-small">
              <a href="'.PROJECT_URL.'/admin/orders.php?orders=act&page_num=1">Текущие заказы</a>
              <div class="box-small"></div>
              <a href="'.PROJECT_URL.'/admin/orders.php?orders=end&page_num=1">Завершённые заказы</a>
              <div class="box-small"></div>
              <a href="'.PROJECT_URL.'/admin/orders.php?orders=all&page_num=1">Все заказы</a>
            </div>';
if($_GET['orders'] == 'end' && in_array($user_id, $root)){ //Выводим только завершённые заказы для админа
  $end = "status='end'";
  $all = '';
  $act = '';
}elseif($_GET['orders'] == 'all' && in_array($user_id, $root)) { //Выводим все заказы для админа
  $end = '';
  $all = "status='end' OR status='new' OR status LIKE 'act%'";
  $act = '';
}else{
  $end = '';
  $all = '';
  $act = "status LIKE 'act%' OR status='new'";
}
$count = $pdo->query("SELECT COUNT(*) FROM orders WHERE $act $end $all")->fetchColumn();
$total_page = ceil($count/$per_page);
if($page_num > $total_page) $page_num = $total_page; //Если значение $page_num большем чем страниц, то выводим последнюю страницу
if($count == 0) $from_num = 1;
else $from_num = ($page_num-1)*$per_page;
$sql_orders = $pdo->prepare("SELECT * FROM orders WHERE $act $end $all LIMIT $from_num, $per_page");
