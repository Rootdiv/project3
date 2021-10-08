<?php
function form_valid($post){
  //Создаем класс-валидатор формы
  $validator = new FormValidator($post);
  //Проверяем на ошибки
  $errors_mass = $validator->validate();
  //Объединяем массив в строку для вывода сообщения об ошибке
  $errors = join("<br>\n", $errors_mass);
  if($errors){
    echo $errors;
    return false;
  }else return true;
}
