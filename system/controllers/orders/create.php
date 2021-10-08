<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/config_mail.php';
session_start();
if(isset($_SESSION['basket']) == false || isset($_SESSION['basket']) == null){
  header('Location: '.PROJECT_URL.'/basket.php');
}else{
  if(form_valid($_POST) === false) exit;
  require_once PROJECT_ROOT.'/components/menu_adm.inc';
  $all_goods = $_SESSION['basket'];
  foreach($all_goods as $elem){
    $item = new Goods($elem);
    $tovar[] = $item->getField('title');
    $art_arr[] = $item->getField('art');
    $sum[] = $item->getField('price');
  }
  $size = $item->getField('razmer');
  $kolichestvo_arr = $_POST['kolichestvo'];
  $tovar_name = json_encode($tovar, JSON_UNESCAPED_UNICODE);
  $art = json_encode($art_arr, JSON_UNESCAPED_UNICODE);
  $kolichestvo = json_encode($kolichestvo_arr, JSON_UNESCAPED_UNICODE);
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
  array_unshift($arr_values, "$tovar_name", "$art", "$size", "$kolichestvo");
  array_unshift($arr_fields, 'tovar_name', 'art', 'razmer', 'kolichestvo');
  if(!$order_base->createLine($arr_fields, $arr_values)) exit('Произошла системная ошибка');
  //Если заказ успешно записан базу данных, отправляем его на почту и боту.
  //Формируем текст сообщения для почты и бота.
  $order = 'Новый заказ №'.$order_base->getField('id');
  $tovar_name_tm = 'Товар: '.str_replace('","', ', ', trim($tovar_name, '["]'));
  $art_tm = 'Артикул: '.str_replace('","', ', ', trim($art, '["]'));
  $size_tm = 'Размер: '.$size;
  $kolichestvo_tm = 'Количество: '.str_replace('","', ', ', trim($kolichestvo, '["]'));
  $summa_tm = 'Сумма: '.$_POST['summa'].' руб.';
  if($_POST['dostavka'] == 500){
    $dostavka_tm = 'Доставка: Курьерская служба - '.$_POST['dostavka'].' руб.';
  }elseif($_POST['dostavka'] == 250){
    $dostavka_tm = 'Доставка: Пункт самовывоза - '.$_POST['dostavka'].' руб.';
  }elseif($_POST['dostavka'] == 1000){
    $dostavka_tm = 'Доставка: Почта России - '.$_POST['dostavka'].' руб.';
  }
  $first_name_tm = 'Имя: '.$_POST['first_name'];
  $last_name_tm = 'Фамилия: '.$_POST['last_name'];
  $address_tm = 'Адрес: '.$_POST['address'];
  $gorod_tm = 'Город: '.$_POST['gorod'];
  $indeks_tm = 'Индекс: '.$_POST['indeks'];
  $tel_tm = 'Телефон: '.$_POST['tel'];
  $email_tm = 'E-Mail: '.$_POST['email'];
  $itog_tm = 'Сумма с доставкой: '.$_POST['itog'].' руб.';
  $oplata_tm = 'Способ оплаты: '.$_POST['oplata'];
  $msg_orders = $order.PHP_EOL.
    $tovar_name_tm.PHP_EOL.
    $art_tm.PHP_EOL.
    $size_tm.PHP_EOL.
    $kolichestvo_tm.PHP_EOL.
    $summa_tm.PHP_EOL.
    $dostavka_tm.PHP_EOL.
    $first_name_tm.PHP_EOL.
    $last_name_tm.PHP_EOL.
    $address_tm.PHP_EOL.
    $gorod_tm.PHP_EOL.
    $indeks_tm.PHP_EOL.
    $tel_tm.PHP_EOL.
    $email_tm.PHP_EOL.
    $itog_tm.PHP_EOL.
    $oplata_tm.PHP_EOL;
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
  echo 'Заказ успешно записан';
}
