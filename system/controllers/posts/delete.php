<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
if(!empty($_POST['id']) && !empty($_POST['table_id'])){
  if(!form_valid($_POST)) exit;
  $id = (int)$_POST['id'];
  $table_id = (int)$_POST['table_id'];
  $post = new Post($id);
  $table = new Table($table_id);
  $post->getTable($table->title());
  $file = $post->getField('photo');
  $files = json_decode($file);
  $dir = '/uploads/'.$table->getField('table_folder').'/';
  if($files !== null && is_dir(PROJECT_ROOT.$dir.$id) !== false){
    $files_count = count($files);
    for($f = 0; $f < $files_count; $f++){
      unlink(PROJECT_ROOT.$files[$f]);
    }
    rmdir(PROJECT_ROOT.$dir.$id);
    $post->deleteLine();
  }elseif(is_dir(PROJECT_ROOT.$dir.$id) !== false){
    unlink(PROJECT_ROOT.$file);
    rmdir(PROJECT_ROOT.$dir.$id);
    $post->deleteLine();
  }else{
    $post->deleteLine();
  }
  echo 'Удалено';
}else{
  echo 'Ошибка';
}
