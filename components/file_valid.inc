<?php
function file_valid($file){
  $image = $file;
  if(is_array($image['name'])){
    for($i = 0; $i < count($image['tmp_name']); $i++){
      if(!preg_match('/^[a-zA-Z0-9\-._]{5,20}$/isu', $image['name'][$i])){
        echo 'Файл или один из файлов содержит недопустимые символы';
        return false;
      }
      $ext = pathinfo($image['name'][$i], PATHINFO_EXTENSION);
      $ext_valid = ['png', 'jpg',];
      if(!in_array($ext, $ext_valid)){
        echo 'Файл или один из файлов неправильный';
        return false;
      }
      $size = $image['size'][$i];
      if($size < 35600){
        echo 'Картинка или одна из картинок слишком маленькая';
        return false;
      }
      if($size > 5242880){
        echo 'Картинка или одна из картинок слишком большая';
        return false;
      }
      $file = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($file, $image['tmp_name'][$i]);
      if(strpos($mime, 'image/jpeg') === false && strpos($mime, 'image/png') === false){
        echo 'Загружать можно только изображения';
        return false;
      }
    }
  }else{
    if(!preg_match('/^[a-zA-Z0-9\-._]{5,20}$/isu', $image['name'])){
      echo 'Файл содержит недопустимые символы';
      return false;
    }
    $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
    $ext_valid = ['png', 'jpg',];
    if(!in_array($ext, $ext_valid)){
      echo 'Файл неправильный';
      return false;
    }
    $size = $image['size'];
    if($size < 35600){
      echo 'Картинка слишком маленькая';
      return false;
    }
    if($size > 5242880){
      echo 'Картинка слишком большая';
      return false;
    }
    $file = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($file, $image['tmp_name']);
    if(strpos($mime, 'image/jpeg') === false && strpos($mime, 'image/png') === false){
      echo 'Загружать можно только изображения';
      return false;
    }
  }
  return true;
}
