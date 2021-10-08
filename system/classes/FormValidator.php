<?php
class FormValidator extends Validator {
  private array $request; // массив значений формы

  public function __construct(array $request){
    $this->request = $request;
  }

  public function validate():array{
    $req = $this->request;
    $pattern_mail = '/^[a-z0-9_.-]+@([a-z0-9-]+\.)+[a-z]{2,6}$/isu';
    $pattern_num = '/^[0-9]+$/isu';
    $err = 'Недопустимое значение!';
    $err_str = 'Данные изменены вручную!';
    $not_str = 'содержит недопустимые символы';
    if(isset($req['login'])) if(!preg_match($pattern_mail, $req['login'])){
      if(!preg_match('/^[a-z0-9]{4,15}$/isu', $req["login"])){
        $this->addError('Логин '.$not_str);
        $nameLen = mb_strlen($req['login']);
        if($nameLen < 4 || $nameLen > 15){
          $this->addError('Длина логина не может превышать 15 символов или быть менее 5 символов');
        }
      }
    }
    else{
      $this->addError('Недопустимый адрес E-mail');
      $nameLen = mb_strlen($req['login']);
      if($nameLen < 10 || $nameLen > 50){
        $this->addError('Длина E-mail не может превышать 50 символов или быть менее 10 символов');
      }
    }
    if(isset($req['password']) || isset($req['user_id'])){
      if($req['password'] !== '' && isset($req['user_id']) === false){ //Валидация пароля на странице регистрации/авторизации
        if(!preg_match('/^[a-z+0-9\-#%]{5,20}$/isu', $req['password'])) $this->addError('Пароль '.$not_str);
        $passLen = mb_strlen($req['password']);
        if($passLen < 5 || $passLen > 20){
          $this->addError('Длина пароля не может превышать 20 символов или быть менее 5 символов');
        }
      }
      elseif($req['password'] !== '' && $req['user_id'] === true){ //Валидация пароля в профиле пользователя/админа
        if(!preg_match('/^[a-zZ0-9+\-#%]{5,20}$/isu', $req['password'])) $this->addError('Пароль '.$not_str);
        $passLen = mb_strlen($req['password']);
        if($passLen < 5 || $passLen > 20){
          $this->addError('Длина пароля не может превышать 20 символов или быть менее 5 символов');
        }
      }
    }
    if(isset($req['username'])){
      if(!preg_match('/^[a-zёа-я\-\s]{2,20}$/isu', $req['username'])){
        $this->addError('Имя '.$not_str);
        $nameLen = mb_strlen($req['username']);
        if($nameLen < 2 || $nameLen > 20){
          $this->addError('Имя не может превышать 20 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['email'])){
      if(!preg_match($pattern_mail, $req['email'])){
        $this->addError('Недопустимый адрес E-mail');
        $nameLen = mb_strlen($req['email']);
        if($nameLen < 10 || $nameLen > 50){
          $this->addError('Длина E-mail не может превышать 50 символов или быть менее 10 символов');
        }
      }
    }
    if(isset($req['id'])){
      if($req['id'] == 0 || !preg_match($pattern_num, $req['id'])) $this->addError('Ошибка');
    }
    if(isset($req['tableID'])){
      if($req['tableID'] == 0 || !preg_match($pattern_num, $req['tableID'])) $this->addError('Ошибка');
    }
    if(isset($req['user_id'])){
      if($req['user_id'] == 0 || !preg_match($pattern_num, $req['user_id'])) $this->addError('Ошибка');
    }
    if(isset($req['adm'])){
      if(!preg_match($pattern_num, $req['adm'])) $this->addError('Недопустимое назначение');
    }
    if(isset($req['tovar_id'])){
      if($req['tovar_id'] == 0 || !preg_match($pattern_num, $req['tovar_id'])) $this->addError('Ошибка');
    }
    if(isset($req['title'])){
      if(!preg_match('/^[a-zёа-я\-\s]{2,150}$/isu', $req['title'])){
        $this->addError('Название '.$not_str);
        $nameLen = mb_strlen($req['title']);
        if($nameLen < 2 || $nameLen > 150){
          $this->addError('Название не может превышать 150 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['art'])){
      if(!preg_match($pattern_num, $req['art'])) $this->addError('Артикул может быть только цифровым');
      $nameLen = mb_strlen($req['art']);
      if($nameLen < 2 || $nameLen > 20){
        $this->addError('Артикул не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if(isset($req['price'])){
      if(!preg_match($pattern_num, $req['price'])) $this->addError('Цена может содержать только цифры');
      $nameLen = mb_strlen($req['price']);
      if($nameLen < 2 || $nameLen > 20){
        $this->addError('Цена не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if(isset($req['description'])){
      if(!preg_match('/^[a-zёа-я\-.,\s]{2,1000}$/isu', $req['description'])){
        $this->addError('Описание '.$not_str);
        $nameLen = mb_strlen($req['description']);
        if($nameLen < 2 || $nameLen > 1000){
          $this->addError('Название не может превышать 1000 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['category'])){
      if($req['category'] == 0 || !preg_match($pattern_num, $req['category'])) $this->addError('Недопустимая категория');
      if($nameLen < 1 || $nameLen > 20) $this->addError($err_str);
    }
    if(isset($req['categories'])){
      if($req['categories'] == 0 || !preg_match($pattern_num, $req['categories'])) $this->addError('Недопустимая подкатегория');
      if($nameLen < 1 || $nameLen > 20) $this->addError($err_str);
    }
    if(isset($req['razmer'])){
      if(!preg_match($pattern_num, $req['razmer'])) $this->addError('Нужно указать размер цифрами');
      $nameLen = mb_strlen($req['razmer']);
      if($nameLen < 2 || $nameLen > 20){
        $this->addError('Цена не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if(isset($req['kolichestvo'])){
      $kolichestvo = count($req['kolichestvo']);
      for($i = 0; $i < $kolichestvo; $i++){
        if($req['kolichestvo'][$i] == 0 || !preg_match($pattern_num, $req['kolichestvo'][$i])) $this->addError($err);
        $nameLen = mb_strlen($req['kolichestvo'][$i]);
        if($nameLen < 1 || $nameLen > 2 || $req['kolichestvo'][$i] > 50){
          $this->addError('Количество не может превышать 50 или быть менее 1');
        }
      }
    }
    if(isset($req['summa'])){
      if(!preg_match($pattern_num, $req['summa'])) $this->addError($err);
      $nameLen = mb_strlen($req['summa']);
      if($nameLen < 4 || $nameLen > 20) $this->addError($err_str);
    }
    if(isset($req['dostavka'])){
      if(!preg_match($pattern_num, $req['dostavka']) && $req['dostavka'] !== 500 && $req['dostavka'] !== 250 && $req['dostavka'] !== 1000) $this->addError($err);
      $nameLen = mb_strlen($req['dostavka']);
      if($nameLen < 3 || $nameLen > 4) $this->addError($err_str);
    }
    if(isset($req['first_name'])){
      if(!preg_match('/^[a-zёа-я\-\s]{2,35}$/isu', $req['first_name'])){
        $this->addError('Имя '.$not_str);
        $nameLen = mb_strlen($req['first_name']);
        if($nameLen < 2 || $nameLen > 35){
          $this->addError('Имя не может превышать 35 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['last_name'])){
      if(!preg_match('/^[a-zёа-я\-\s]{2,20}$/isu', $req['last_name'])){
        $this->addError('Фамилия '.$not_str);
        $nameLen = mb_strlen($req['last_name']);
        if($nameLen < 2 || $nameLen > 20){
          $this->addError('Фамилия не может превышать 20 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['address'])){
      if(!preg_match('/^[a-zёа-я\-.\s0-9]{2,100}$/isu', $req['address'])){
        $this->addError('Адрес '.$not_str);
        $nameLen = mb_strlen($req['address']);
        if($nameLen < 5 || $nameLen > 1000){
          $this->addError('Адрес не может превышать 100 символов или быть менее 5 символов');
        }
      }
    }
    if(isset($req['gorod'])){
      if(!preg_match('/^[a-zёа-я\-.\s]{2,20}$/isu', $req['gorod'])){
        $this->addError('Название города '.$not_str);
        $nameLen = mb_strlen($req['gorod']);
        if($nameLen < 2 || $nameLen > 20){
          $this->addError('Название города не может превышать 20 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['indeks'])){
      if(!preg_match('/^[0-9]{1,6}$/isu', $req['indeks'])) $this->addError('Индекс может быть только цифровым');
      $nameLen = mb_strlen($req['indeks']);
      if($nameLen < 1 || $nameLen > 6) $this->addError('Индекс не может превышать 6 цифр');
    }
    if(isset($req['tel'])){
      if(!preg_match('/^[+]?[0-9]{11}$/isu', $req['tel'])) $this->addError('Недопустимый формат номера');
      $nameLen = mb_strlen($req['tel']);
      if($nameLen < 1 || $nameLen > 12) $this->addError('Номер не может превышать 12 цифр');
    }
    if(isset($req['itog'])){
      if(!preg_match($pattern_num, $req['itog'])) $this->addError($err);
      $nameLen = mb_strlen($req['itog']);
      if($nameLen < 4 || $nameLen > 20) $this->addError($err_str);
    }
    if(isset($req['oplata'])){
      if(!preg_match('/^[a-z\sа-я.]{2,50}$/isu', $req['oplata'])){
        $this->addError($err);
        $nameLen = mb_strlen($req['oplata']);
        if($nameLen < 5 || $nameLen > 50) $this->addError($err_str);
      }
    }
    if(isset($req['member_id'])){
      if(!preg_match($pattern_num, $req['member_id'])) $this->addError('Ошибка');
      $nameLen = mb_strlen($req['member_id']);
      if($nameLen < 1 || $nameLen > 10000) $this->addError($err_str);
    }
    if(isset($req['fio'])){
      if(!preg_match('/^[a-zёа-я\-\s]{2,50}$/isu', $req['fio'])){
        $this->addError('Поле ФИО '.$not_str);
        $nameLen = mb_strlen($req['fio']);
        if($nameLen < 2 || $nameLen > 50){
          $this->addError('Поле ФИО не может превышать 50 символов или быть менее 2 символов');
        }
      }
    }
    if(isset($req['text'])){
      if(preg_match('/[\$\[\]*{}]+/isu', $req['text'])){
        $this->addError('Сообщение '.$not_str);
        $nameLen = mb_strlen($req['text']);
        if($nameLen < 15 || $nameLen > 2000){
          $this->addError('Сообщение не может превышать 2000 символов или быть менее 20 символов');
        }
      }
    }
    return $this->getErrors();
  }
}
