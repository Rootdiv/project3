<?php
if(isset($_GET['id'])){
  session_start();
  $id = (int)$_GET['id'];
  $basket = @$_SESSION['basket'];

  if(@!in_array($id, $basket)){
    $basket[] = $id;
  }

  $_SESSION['basket'] = $basket;
  header('Location: '.@$_SERVER['HTTP_REFERER']);
}else{
  header('Location: '.@$_SERVER['HTTP_REFERER']);
}