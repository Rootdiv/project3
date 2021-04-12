<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
if(!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['password'])){
  if(form_valid($_POST) === false) exit;

  $arr_fields = [];
  $arr_values = [];
  $login = $_POST['login'];
  $email = $_POST['email'];
  $new_user = new Member();
  $table = $new_user->setTable();
  $sql = $pdo->prepare("SELECT * FROM $table WHERE login=:login");
  $sql->bindParam(':login', $login);
  $sql->execute();
  $rows = $sql->fetch(PDO::FETCH_LAZY);
  if(strcasecmp($rows['login'], $login) == 0 || strcasecmp($rows['email'], $email) == 0){
    echo 'Аккаунт c указанным логином или e-mail адресом существует';
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
