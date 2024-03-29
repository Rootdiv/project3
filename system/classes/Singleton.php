<?php
abstract class Singleton {
  protected static $instance = null; // Единственный экземпляр класса, чтобы не создавать множество подключений
  //protected static $instance = []; // Единственный экземпляр класса, чтобы не создавать множество подключений
  /* Получение экземпляра класса. Если он уже существует, то возвращается, если его не было, то создаётся и возвращается (паттерн Singleton) */
  public static function getInstance() {
    if (static::$instance === null) {
      static::$instance = new static();
    }
    return static::$instance;
  }

  /**
   * Клонирование запрещено
   */
  private function __clone() {
  }

  /**
   * Сериализация запрещена
   */
  public function __sleep() {
  }

  /**
   * Десериализация запрещена
   */
  public function __wakeup() {
  }
}
