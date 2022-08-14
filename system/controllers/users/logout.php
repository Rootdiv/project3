<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
$host = $_SERVER['HTTP_HOST'];
setcookie('member_id', 0, [
  'expires' => time() - 36000,
  'path' => '/',
  'domain' => $host,
  'secure' => true,
  'httpOnly' => true,
  'SameSite' => 'Lax',
]);
unset($_COOKIE['member_id']);
session_start();
unset($_SESSION['basket']);
session_destroy();
header('Location: ' . PROJECT_URL);
