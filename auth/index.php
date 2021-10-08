<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once PROJECT_ROOT.'/components/header.inc';
if(isset($_COOKIE['member_id'])) header('Location: '.PROJECT_URL.'/main.php');
else header('Location: '.PROJECT_URL.'/auth/login.php');
require_once PROJECT_ROOT.'/components/footer.inc';
