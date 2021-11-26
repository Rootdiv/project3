<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
if (isset($_POST) && !empty($_POST['id']) && !empty($_POST['user_id']) && !empty($_POST['username'])) {
  $id = $_POST['id'];
  $user_id = $_POST['user_id'];
  $username = $_POST['username'];
  $sql = $pdo->prepare("UPDATE orders SET status='act$user_id' WHERE id=:id");
  $sql->bindParam(":id", $id);
  try {
    $sql->execute();
    $order = 'Заказ №' . $id . ' обрабатывает менеджер ' . $username;
    file_get_contents(URL . 'sendMessage?parse_mode=HTML&chat_id=' . USER_TG . '&text=' . $order);
    echo 'Заказ выполняется';
  } catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
  }
}
