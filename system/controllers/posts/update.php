<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
if(!empty($_POST['table_id']) && !empty($_POST['id'])){
  if(!form_valid($_POST)) exit;
  if($_FILES && $_FILES['photo']['name'] !== ''){
    $files = $_FILES['photo'];
    //Валидируем массив $_FILES если в имени переданного файла есть 1 символ или если передан массив файлов
    if(($files['name'][0]) !== ''){
      if(!file_valid($files)) exit;
    }
  }
  $post = new Post($_POST['id']);
  $table = new Table($_POST['table_id']);
  $table_name = $table->getField('title');
  $post->getTable($table_name);
  $post_columns_name = $post->getTableColumnsNames();
  $post_columns = array_slice($post_columns_name, 1);
  $post_id = $_POST['id'];
  $arr_fields = [];
  $arr_values = [];
  foreach($post_columns as $column){
    if(@$_POST[$column] && $_POST[$column] !== 'photo'){
      $arr_fields[] = $column;
      if($column == 'password'){
        if($_POST[$column] !== ''){
          $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
        }
      }elseif(is_array($_POST[$column])){
        $value = json_encode($_POST[$column]);
      }else{
        $value = $_POST[$column];
      }
      $arr_values[] = $value;
    }else{
      if(isset($_FILES[$column]) && $_FILES[$column]['name'] !== ''){
        $dir = '/uploads/'.$table->getField('table_folder').'/';
        if(!file_exists(PROJECT_ROOT.$dir) && !is_file(PROJECT_ROOT.$dir)){
          mkdir(PROJECT_ROOT.$dir, 0775);
        }
        $post_dir = $dir.$post_id.'/';
        if(!file_exists(PROJECT_ROOT.$post_dir) && !is_file(PROJECT_ROOT.$post_dir)){
          mkdir(PROJECT_ROOT.$post_dir, 0775);
        }
        if(is_array($_FILES[$column]['name'])){
          $file_mass = $post->getField('photo');
          $files = json_decode($file_mass);
          $files_count = count($files);
          for($f = 0; $f < $files_count; $f++){
            unlink(PROJECT_ROOT.$files[$f]);
          }
          $names_count = count($_FILES[$column]['name']);
          for($i = 0; $i < $names_count; $i++){
            move_uploaded_file($_FILES[$column]['tmp_name'][$i], PROJECT_ROOT.$post_dir.$_FILES[$column]['name'][$i]);
            $arr_files[] = $post_dir.$_FILES[$column]['name'][$i];
          }
          $arr_fields[] = $column;
          $arr_values[] = json_encode($arr_files);
        }else{
          $file = $post->getField('photo');
          unlink(PROJECT_ROOT.$file);
          move_uploaded_file($_FILES[$column]['tmp_name'], PROJECT_ROOT.$post_dir.$_FILES[$column]['name']);
          $arr_fields[] = $column;
          $arr_values[] = $post_dir.$_FILES[$column]['name'];
        }
      }
    }
  }
  if($post->updateLine($arr_fields, $arr_values)) echo 'Данные успешно обновлены';
}else{
  echo 'Ошибка';
}
