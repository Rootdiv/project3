<?php
if (isset($_COOKIE['member_id']) && !empty($_COOKIE['member_id'])) {
  require_once PROJECT_ROOT . '/components/menu_adm.inc.php';
  if (!in_array($user_id, $root) && !in_array($user_id, $manager)) {
    header('Location: ' . PROJECT_URL . '/errors/err403.php');
  }
} else {
  header('Location: ' . PROJECT_URL . '/auth/login.php');
}
