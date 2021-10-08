<?php
class Connect extends Singleton {
  public function getConnection(){
    $this->pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $this->pdo->exec("set names utf8");
    return $this->pdo;
  }
}
