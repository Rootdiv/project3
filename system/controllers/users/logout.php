<?php
$host = $_SERVER['HTTP_HOST'];
setcookie('member_id', '0', time() - 3600, '/', $host, true, true);
unset($_COOKIE['member_id']);
session_start();
unset($_SESSION['basket']);
session_destroy();
header('Location: ' . $_SERVER['HTTP_REFERER']);
