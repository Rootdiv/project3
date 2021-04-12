<?php
if(isset($_COOKIE['member_id']) === false){
  header('Location: '.PROJECT_URL.'/auth/login.php');
}else{
  require_once PROJECT_ROOT.'/components/menu_adm.inc';
  if(!in_array($user_id, $root) && !in_array($user_id, $manager)){
    header('Location: '.PROJECT_URL.'/errors/err403.php');
  }
}
