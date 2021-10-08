<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once PROJECT_ROOT.'/components/header.inc';
if(isset($_COOKIE['member_id']) === false){
  header('Location: '.PROJECT_URL.'/auth/login.php');
}else{
  require_once PROJECT_ROOT.'/components/menu_adm.inc';
  if(!in_array($user_id, $root) && !in_array($user_id, $manager)) header('Location: '.PROJECT_URL.'/errors/err403.php');
  else header('Location: '.PROJECT_URL.'/admin/orders.php?orders=act&page_num=1');
}
require_once PROJECT_ROOT.'/components/footer.inc';
