<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/config_mail.php';
if (isset($_POST) && !empty($_POST['login']) && !empty($_POST['email'])) {
  if (formValid($_POST) === false) {
    exit;
  }

  $login = $_POST['login'];
  $email = $_POST['email'];
  $new_user = new Member();
  $table = $new_user->setTable();
  $sql = $pdo->prepare("SELECT * FROM $table WHERE BINARY login=:login AND email=:email");
  $sql->bindParam(':login', $login);
  $sql->bindParam(':email', $email);
  $sql->execute();
  $rows = $sql->fetch();
  if (!empty($rows) && $rows['login'] === $login && $rows['email'] === $email) {
    //Символы, которые будут использоваться в пароле
    $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
    $max = 10; //Количество символов в пароле
    $size = strlen($chars) - 1; //Определяем количество символов в $chars
    $pass = null; //Определяем пустую переменную, в которую и будем записывать символы
    while ($max--) { //Создаём пароль
      $pass .= $chars[rand(0, $size)];
    }

    //Сообщение с паролем
    $message = 'Ваш логин <b>' . $login . '</b><br>';
    $message .= 'Ваш новый пароль <b>' . $pass . '</b><br><br>Теперь можно войти на сайт используя новый пароль.';
    $password = password_hash($pass, PASSWORD_DEFAULT); //Обновляем пароль в базе.
    $sql = $pdo->prepare("UPDATE $table SET password=:password WHERE login=:login AND email=:email");
    $sql->bindParam(':password', $password);
    $sql->bindParam(':login', $login);
    $sql->bindParam(':email', $email);
    try {
      $sql->execute();
      if (smtpmail($login, $email, 'Новый пароль', $message)) {
        exit('Пароль сгенерирован, проверьте Вашу почту.');
      } else {
        exit('Письма нет, обратитесь к администрации для восстановления доступа.');
      }
    } catch (PDOException $e) {
      die('Подключение не удалось: ' . $e->getMessage());
    }
  }
}
echo 'Аккаунт не существует';
