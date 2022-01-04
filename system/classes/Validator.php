<?php
abstract class Validator {
  private array $errors = [];
  //Проверяет значения на соответствие условию и если условия нарушаются, помещает в массив $errors сообщение об ошибке
  abstract function validate(): array;

  //Добавляет сообщение об ошибке в массив
  public function addError($message) {
    $this->errors[] = 'Ошибка. ' . $message;
  }
  //Возвращает список всех найденных ошибок
  public function getErrors() {
    return $this->errors;
  }
}
