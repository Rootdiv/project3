<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
if(!empty($_POST['id'])){
  $id = $_POST['id'];
  $sql = $pdo->prepare("UPDATE orders SET status='end' WHERE id=:id");
  $sql->bindParam(":id", $id);
  try{
    $sql->execute();
    $order = 'Заказ №'.$id.' обработан';
    file_get_contents(URL.'sendMessage?parse_mode=HTML&chat_id='.USER_TG.'&text='.$order);
    header('Location: '.@$_SERVER['HTTP_REFERER']);
  }catch(PDOException $e){
    die('Подключение не удалось: '.$e->getMessage());
  }
}else{
  header('Location: '.PROJECT_URL.'/admin/orders.php');
}
