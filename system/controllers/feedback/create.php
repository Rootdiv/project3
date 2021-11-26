<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/config_mail.php';
if (!empty($_POST['full_name']) && !empty($_POST['email']) && !empty($_POST['email']) && !empty($_POST['text'])) {
  if (formValid($_POST) === false) {
    exit;
  }
  require_once PROJECT_ROOT . '/components/menu_adm.inc.php';
  $arr_fields = [];
  $arr_values = [];
  $message = new Feedback(0);
  $name_columns_name = $message->getTableColumnsNames();
  $name_columns = array_slice($name_columns_name, 1);
  foreach ($name_columns as $columns) {
    if ($_POST[$columns]) {
      $arr_fields[] = $columns;
      $arr_values[] = trim($_POST[$columns]);
    }
  }
  if ($message->createLine($arr_fields, $arr_values)) {
    echo 'Сообщение записано.';
    $subject = 'Новое сообщение';
    $text = 'пришло новое сообщения по обратной связи.';
    if (in_array(1, $arr_values)) {
      $mail_send_to = count($admin_mail);
      for ($i = 0; $i < $mail_send_to; $i++) {
        if (!smtpmail('Администратор', $admin_mail[$i], $subject, 'Администрации ' . $text)) {
          exit;//('Письма нет');
        }
      }
    } elseif (in_array(2, $arr_values)) {
      $mail_send_to = count($manager_mail);
      for ($i = 0; $i < $mail_send_to; $i++) {
        if (!smtpmail('Менеджер', $manager_mail[$i], $subject, 'Менеджерам ' . $text)) {
          exit;//('Письма нет');
        }
      }
    }
    exit;
  }
}
echo 'Произошла ошибка';
