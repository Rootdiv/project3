<?php
declare(strict_types=1);
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/config_mail.php';
if(!empty($_POST['fio']) && !empty($_POST['email']) && !empty($_POST['email']) && !empty($_POST['text'])){
  if(form_valid($_POST) === false){
    exit;
  }
  require_once PROJECT_ROOT.'/components/menu_adm.inc';
  $arr_fields = [];
  $arr_values = [];
  $message = new Feedback(0);
  $name_columns_name = $message->getTableColumnsNames();
  $name_columns = array_slice($name_columns_name, 1);
  foreach($name_columns as $columns){
    if($_POST[$columns]){
      $arr_fields[] = $columns;
      $arr_values[] = trim($_POST[$columns]);
    }
  }
  if($message->createLine($arr_fields, $arr_values)){
    echo 'Сообщение записано';
    $msg = 'пришло новое сообщения по обратной связи.';
    $subject = 'Новое сообщение';
    if(in_array(1, $arr_values)){
      $mail_send_to = count($admin_mail);
      for($i = 0; $i < $mail_send_to; $i++){
        if(!smtpmail('Администратор', $admin_mail[$i], $subject, 'Администрации '.$msg)){
          echo 'Письма нет';
          //exit;
        }
      }
    }elseif(in_array(2, $arr_values)){
      $mail_send_to = count($manager_mail);
      for($i = 0; $i < $mail_send_to; $i++){
        if(!smtpmail('Менеджер', $manager_mail[$i], $subject, 'Менеджерам '.$msg)){
          echo 'Письма нет';
          //exit;
        }
      }
    }
  }else{
    echo 'Произошла ошибка';
  }
}else{
  header('Location: '.PROJECT_URL.'/contacts.php');
}
