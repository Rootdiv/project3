<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
if(!empty($_POST['login']) && !empty($_POST['password'])){
  if(form_valid($_POST) === false) exit;
  $auth = new Member();
  $login = $_POST['login'];
  $password = $_POST['password'];
  if($auth->loginCheck($login, $password)) echo 'Авторизован';
  else echo 'Введён некорректный пароль или логин.';
}else{
  header('Location: '.PROJECT_URL.'/auth/index.php');
}
