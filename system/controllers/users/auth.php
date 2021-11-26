<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
if (isset($_POST) && !empty($_POST['login']) && !empty($_POST['password'])) {
  if (formValid($_POST) === false) {
    exit;
  }

  $auth = new Member();
  $login = $_POST['login'];
  $password = $_POST['password'];
  if ($auth->loginCheck($login, $password)) {
    exit('Авторизован');
  }
}
echo 'Введён некорректный пароль или логин.';
