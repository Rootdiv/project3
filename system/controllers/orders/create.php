<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/config_mail.php';
session_start();
if(isset($_SESSION['basket']) == false || isset($_SESSION['basket']) == null){
  header('Location: '.PROJECT_URL.'/basket.php');
}else{
  if(form_valid($_POST) === false) exit;
  require_once PROJECT_ROOT.'/components/menu_adm.inc.php';
  $all_goods = $_SESSION['basket'];
  foreach($all_goods as $elem){
    $item = new Goods($elem);
    $product[] = $item->getField('title');
    $art_arr[] = $item->getField('article');
    $sum[] = $item->getField('price');
  }
  $size = $item->getField('sized');
  $quantity_arr = $_POST['quantity'];
  $product_name = json_encode($product, JSON_UNESCAPED_UNICODE);
  $art = json_encode($art_arr, JSON_UNESCAPED_UNICODE);
  $quantity = json_encode($quantity_arr, JSON_UNESCAPED_UNICODE);
  //Записываем заказ базу данных
  $order_base = new Orders(0);
  $name_columns_table = $order_base->getTableColumnsNames();
  //Через array_splice выкидываем элементы которые будут добавлены и админ поле.
  $name_columns = array_splice($name_columns_table, 5, -1);
  foreach($name_columns as $columns){
    if($_POST[$columns]){
      $arr_fields[] = $columns;
      $arr_values[] = trim($_POST[$columns]);
    }
  }
  //Через array_unshift добавляем ранее выкинутые элементы кроме админ поля.
  array_unshift($arr_values, "$product_name", "$art", "$size", "$quantity");
  array_unshift($arr_fields, 'product_name', 'article', 'sized', 'quantity');
  if(!$order_base->createLine($arr_fields, $arr_values)) exit('Произошла системная ошибка');
  //Если заказ успешно записан базу данных, отправляем его на почту и боту.
  //Формируем текст сообщения для почты и бота.
  $order = 'Новый заказ &numero;'.$order_base->getField('id');
  $product_name_tm = 'Товар: '.str_replace('","', ', ', trim($product_name, '["]'));
  $art_tm = 'Артикул: '.str_replace('","', ', ', trim($art, '["]'));
  $size_tm = 'Размер: '.$size;
  $quantity_tm = 'Количество: '.str_replace('","', ', ', trim($quantity, '["]'));
  $amount_tm = 'Сумма: '.$_POST['amount'].' руб.';
  if($_POST['delivery'] == 500){
    $delivery_tm = 'Доставка: Курьерская служба - '.$_POST['delivery'].' руб.';
  }elseif($_POST['delivery'] == 250){
    $delivery_tm = 'Доставка: Пункт самовывоза - '.$_POST['delivery'].' руб.';
  }elseif($_POST['delivery'] == 1000){
    $delivery_tm = 'Доставка: Почта России - '.$_POST['delivery'].' руб.';
  }
  $first_name_tm = 'Имя: '.$_POST['first_name'];
  $last_name_tm = 'Фамилия: '.$_POST['last_name'];
  $address_tm = 'Адрес: '.$_POST['address'];
  $city_tm = 'Город: '.$_POST['city'];
  $postcode_tm = 'Индекс: '.$_POST['postcode'];
  $phone_tm = 'Телефон: '.$_POST['phone'];
  $email_tm = 'E-Mail: '.$_POST['email'];
  $total_tm = 'Сумма с доставкой: '.$_POST['total'].' руб.';
  $payment_tm = 'Способ оплаты: '.$_POST['payment'];
  $msg_orders = $order.PHP_EOL.
    $product_name_tm.PHP_EOL.
    $art_tm.PHP_EOL.
    $size_tm.PHP_EOL.
    $quantity_tm.PHP_EOL.
    $amount_tm.PHP_EOL.
    $delivery_tm.PHP_EOL.
    $first_name_tm.PHP_EOL.
    $last_name_tm.PHP_EOL.
    $address_tm.PHP_EOL.
    $city_tm.PHP_EOL.
    $postcode_tm.PHP_EOL.
    $phone_tm.PHP_EOL.
    $email_tm.PHP_EOL.
    $total_tm.PHP_EOL.
    $payment_tm.PHP_EOL;
  //Отправляем письмо всем менеджерам.
  $mail_orders = str_replace(PHP_EOL, "<br>", $msg_orders);
  $mail_send_to = count($manager_mail);
  for($i = 0; $i < $mail_send_to; $i++){
    if(!smtpmail('Менеджер', $manager_mail[$i], 'Новый заказ', $mail_orders)){
      $mail_orders_tm = 1;
      //exit('Письма нет');
    }
  }
  //Если произошла ошибка при отправке на почту добавляем соответствующие сообщение боту.
  if(isset($mail_orders_tm) == 1) $mail_error = 'Письмо не доставлено, произошла ошибка.';
  else $mail_error = '';
  $msg = urlencode($msg_orders.$mail_error); //кодируем сообщение для передачи в url запросе
  file_get_contents(URL.'sendMessage?parse_mode=HTML&chat_id='.USER_TG.'&text='.$msg);
  unset($_SESSION['basket']);
  session_destroy();
  echo 'Новый заказ записан';
}
