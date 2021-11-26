<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
if (!empty($_POST['table_id'])) {
  if (!formValid($_POST)) {
    exit;
  }
  if (!empty($_FILES)) {
    $files = $_FILES['photo'];
    //Влидируем массив $_FILES если в имени переданного файла есть 1 символ или если передан массив файлов
    if (($files['name'][0]) !== '') {
      if (!fileValid($files)) {
        exit;
      }

    }
  }
  //создаем экземпляр универсального класса Post что работать с таблицей (записывать в нее)
  //Важно! Код ниже будет работать если таблица работать если отключён строгий режим базы данных
  //иначе необходимо установить значение столбца в NULL при создании базы данных.
  $post = new Post(0);
  //Создаем экземпляр класса Table чтобы по переданному айдишнику таблицы  узнать инфу о таблице например её название
  $table = new Table($_POST['table_id']);
  $table_name = $table->getField('title');
  //смотри название таблицы
  //сообщаем название экзэмпляру класса - теперь он знает с какой таблицей работать
  $post->getTable($table_name);
  //получаем все колонки в таблице с данными сущностями
  $post_columns_name = $post->getTableColumnsNames();
  $post_columns = array_slice($post_columns_name, 1);
  //создаем новую строку(пост) в таблице и получаем его id
  $post_id = $post->createLine([], []);
  //набираем массив полей и массив значений
  $arr_fields = [];
  $arr_values = [];
  //для каждого столбца в таблице
  foreach ($post_columns as $column) {
    //если передан пост элемент для этой колонки то обрабатываем
    if (@$_POST[$column] && $_POST[$column] !== 'photo') {
      //добавляем это поле в массив полей
      $arr_fields[] = $column;
      if ($column == 'password') {
        //если это поле пароль то шифруем значение в нём
        $value = $value = password_hash($_POST[$column], PASSWORD_DEFAULT);
      } elseif (is_array($_POST[$column])) {
        //если это поле массив то сериализуем его в json строку
        $value = json_encode($_POST[$column]);
      } else {
        //иначе просто сохраняем
        $value = trim($_POST[$column]);
      }
      //записываем значение для поля в массив значений
      $arr_values[] = $value;
    } else {
      //если передан файл для этой колонки обрабатываем
      if ($_FILES[$column]) {
        //смотрим название папки для сущностей в таблице таблиц
        $dir = '/uploads/' . $table->getField('table_folder') . '/';
        //если папка не существует то ее создаем с правами
        if (!file_exists(PROJECT_ROOT . $dir) && !is_file(PROJECT_ROOT . $dir)) {
          mkdir(PROJECT_ROOT . $dir, 0775);
        }
        //создаем путь для папки конкретного поста по id (название папки совпадает с id поста в таблице в БД)
        $post_dir = $dir . $post_id . '/';
        //если папка не существует то ее создаем с правами
        if (!file_exists(PROJECT_ROOT . $post_dir) && !is_file(PROJECT_ROOT . $post_dir)) {
          mkdir(PROJECT_ROOT . $post_dir, 0775);
        }
        //если это множественные файлы
        if (is_array($_FILES[$column]['name'])) {
          //считаем количество файлов
          $names_count = count($_FILES[$column]['name']);
          for ($i = 0; $i < $names_count; $i++) {
            //загружаем файл и пишем ссылку на него в массив ссылок для этого файла
            move_uploaded_file($_FILES[$column]['tmp_name'][$i], PROJECT_ROOT . $post_dir . $_FILES[$column]['name'][$i]);
            $arr_files[] = $post_dir . $_FILES[$column]['name'][$i];
          }
          //добавляем поле в массив полей
          $arr_fields[] = $column;
          //сериализуем все ссылки и добавляем в массив значений
          $arr_values[] = json_encode($arr_files);
        } else {
          //иначе загружаем файлы
          move_uploaded_file($_FILES[$column]['tmp_name'], PROJECT_ROOT . $post_dir . $_FILES[$column]['name']);
          //добавляем поле в массив полей
          $arr_fields[] = $column;
          //сериализуем все ссылки и добавляем в массив значений
          $arr_values[] = $post_dir . $_FILES[$column]['name'];
        }
      }
    }
  }
  if ($post->updateLine($arr_fields, $arr_values)) {
    exit('Данные успешно добавлены');
  }
}
echo 'Ошибка';
