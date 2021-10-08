<?php
class Member extends Unit {
  public $login;
  public $password;
  public $result;

  public function setTableId(){
    $table = new Table(0);
    $table->getTableByName($this->setTable());
    return $table->tableId();
  }

  public function setTable(){
    return 'core_users';
  }

  public function member_id(){
    if($this->getField('id')){
      return $this->getField('id');
    }
    return 0;
  }

  public function login(){
    return $this->getField('login');
  }

  /* check login and pass  */
  public function loginCheck($login, $password){
    $member_sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE BINARY login=:login OR email=:email ");
    $member_sql->bindParam(':login', $login);
    $member_sql->bindParam(':email', $login);
    $member_sql->execute();
    $members = $member_sql->fetchAll();
    $host = $_SERVER['HTTP_HOST'];
    if($member_sql->rowCount()){
      $flag = 0;
      foreach($members as $member){
        if(hash_equals($member['password'], crypt($password, $member['password']))){
          $id = $member['id'];
          $member_password_hash = $member['password'];
          setcookie("member_id", "$id", time() + 36000, "/", "$host", true, true); //поставить тут переменное значение
          $user_hash = md5($_SERVER ['HTTP_USER_AGENT'].'%'.$member_password_hash); //создаем хэш для защиты куки
          $sql = $this->pdo->prepare("UPDATE ".$this->setTable()." SET ip_address=:ip_address , user_hash=:user_hash  WHERE id=:id");
          $sql->bindParam(":ip_address", $_SERVER['REMOTE_ADDR']);
          $sql->bindParam(":user_hash", $user_hash);
          $sql->bindParam(":id", $id);
          $sql->execute();
          $flag = 1;
          break;
        }else{
          setcookie("member_id", "0", time() - 3600, "/", "$host", true, true);
        }
      }
      if($flag == 1){
        return true;
      }else{
        return false;
      }
    }else{
      setcookie("member_id", "0", time() - 3600, "/", "$host", true, true);
      return false;
    }
  }

  /* validate the users id*/
  public function is_valid(){
    $sql = $this->pdo->prepare("SELECT * FROM ".$this->setTable()." WHERE id=:id");
    $sql->bindParam(":id", $this->id);
    $sql->execute();
    $member = $sql->fetch(PDO::FETCH_LAZY);
    $user_hash = md5($_SERVER ['HTTP_USER_AGENT'].'%'.$member['password']); //создаем хэш для проверки
    if(!hash_equals($member['user_hash'], $user_hash)){
      $host = $_SERVER['HTTP_HOST'];
      setcookie("member_id", "0", time() - 3600, "/", "$host", true, true);
      header('Location: '.PROJECT_URL.'/auth/login.php');
      return false;
    }else{
      return true;
    }
  }
}
