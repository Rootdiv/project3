<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
if(!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])){
  if(form_valid($_POST) === false) exit;

  $arr_fields = [];
  $arr_values = [];
  $login = $_POST['login'];
  $new_user = new Member();
  $table = $new_user->setTable();
  $sql = $pdo->prepare("SELECT * FROM $table WHERE login=:login");
  $sql->bindParam(':login', $login);
  $sql->execute();
  $rows = $sql->fetch(PDO::FETCH_LAZY);
  if(strcmp($rows['login'], $login) == 0 || strcmp($rows['login'], $login) == 1){
    echo 'Аккаунт существует';
  }else{
    $name_columns_user = $new_user->getTableColumnsNames();
    $name_columns = array_splice($name_columns_user, 1, -3);
    foreach($name_columns as $column){
      if($_POST[$column]){
        $arr_fields[] = $column;
        if($column == 'password'){
          $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
        }else{
          $value = $_POST[$column];
        }
        $arr_values[] = $value;
      }
    }
    if($new_user->createLine($arr_fields, $arr_values)) echo 'Зарегистрирован';
    else echo 'Аккаунт не создан';
  }
}else{
  header('Location: '.PROJECT_URL.'/auth/index.php');
}
