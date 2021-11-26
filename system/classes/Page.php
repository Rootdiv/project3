<?php
class Page extends Post {
  public function getIdByName($name) {
    $sql = $this->pdo->prepare("SELECT * FROM " . $this->setTable() . " WHERE filename='$name' ");
    $sql->execute();
    $page = $sql->fetch(PDO::FETCH_LAZY);
    $this->id = $page->id;
  }

  public function setTable() {
    return 'core_pages';
  }
}
