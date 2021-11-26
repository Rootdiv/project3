<?php
class FormValidator extends Validator {
  private array $request; // массив значений формы

  public function __construct(array $request) {
    $this->request = $request;
  }

  public function validate(): array{
    $req = $this->request;
    $pattern_mail = '/^[a-z0-9\_\.\-]+@[a-z0-9-]+\.[a-z]{2,6}$/isu';
    $pattern_num = '/^[0-9]+$/isu';
    $err = 'Недопустимое значение!';
    $err_str = 'Данные изменены вручную!';
    $not_str = 'содержит недопустимые символы';
    if (isset($req['login'])) {
      $mail = stripos($req['login'], '@');
      if ($mail) {
        if (!preg_match($pattern_mail, $req['login'])) {
          $this->addError('Недопустимый адрес E-mail');
        }

        $nameLen = mb_strlen($req['login']);
        if ($nameLen < 10 || $nameLen > 50) {
          $this->addError('Длина E-mail не может превышать 50 символов или быть менее 10 символов');
        }
      } else {
        if (!preg_match('/^[a-z0-9]{4,15}$/isu', $req["login"])) {
          $this->addError('Логин ' . $not_str);
        }

        $nameLen = mb_strlen($req['login']);
        if ($nameLen < 4 || $nameLen > 15) {
          $this->addError('Длина логина не может превышать 15 символов или быть менее 5 символов');
        }
      }
    }
    if (isset($req['password'])) {
      if(isset($req['profile']) && !empty($req['password']) || isset($req['users']) && !empty($req['password'])){
        if (!preg_match('/^[a-z0-9\+\-\#\%\!]{5,17}$/isu', $req['password'])) {
          $this->addError('Пароль ' . $not_str);
        }

        $passLen = mb_strlen($req['password']);
        if ($passLen < 5 || $passLen > 20) {
          $this->addError('Длина пароля не может превышать 17 символов или быть менее 5 символов');
        }
      }
    }
    if (isset($req['username'])) {
      if (!preg_match('/^[а-яё\-\s]{2,20}$/isu', $req['username'])) {
        $this->addError('Имя ' . $not_str);
      }

      $nameLen = mb_strlen($req['username']);
      if ($nameLen < 2 || $nameLen > 20) {
        $this->addError('Имя не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if (isset($req['email'])) {
      if (!preg_match($pattern_mail, $req['email'])) {
        $this->addError('Недопустимый адрес E-mail');
      }

      $nameLen = mb_strlen($req['email']);
      if ($nameLen < 10 || $nameLen > 50) {
        $this->addError('Длина E-mail не может превышать 50 символов или быть менее 10 символов');
      }
    }
    if (isset($req['id'])) {
      if ($req['id'] == 0 || !preg_match($pattern_num, $req['id'])) {
        $this->addError('Ошибка');
      }

    }
    if (isset($req['table_id'])) {
      if ($req['table_id'] == 0 || !preg_match($pattern_num, $req['table_id'])) {
        $this->addError('Ошибка');
      }

    }
    if (isset($req['user_id'])) {
      if ($req['user_id'] == 0 || !preg_match($pattern_num, $req['user_id'])) {
        $this->addError('Ошибка');
      }

    }
    if (isset($req['adm'])) {
      if (!preg_match($pattern_num, $req['adm'])) {
        $this->addError('Недопустимое назначение');
      }

    }
    if (isset($req['product_id'])) {
      if ($req['product_id'] == 0 || !preg_match($pattern_num, $req['product_id'])) {
        $this->addError('Ошибка');
      }

    }
    if (isset($req['title'])) {
      if (!preg_match('/^[a-zёа-я\-\s]{2,150}$/isu', $req['title'])) {
        $this->addError('Название ' . $not_str);
      }

      $nameLen = mb_strlen($req['title']);
      if ($nameLen < 2 || $nameLen > 50) {
        $this->addError('Название не может превышать 50 символов или быть менее 2 символов');
      }
    }
    if (isset($req['article'])) {
      if (!preg_match($pattern_num, $req['article'])) {
        $this->addError('Артикул может быть только цифровым');
      }

      $nameLen = mb_strlen($req['article']);
      if ($nameLen < 2 || $nameLen > 20) {
        $this->addError('Артикул не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if (isset($req['price'])) {
      if (!preg_match($pattern_num, $req['price'])) {
        $this->addError('Цена может содержать только цифры');
      }

      $nameLen = mb_strlen($req['price']);
      if ($nameLen < 2 || $nameLen > 20) {
        $this->addError('Цена не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if (isset($req['description'])) {
      if (!preg_match('/^[а-яё\-\.\,\s\!]{2,2000}$/isu', $req['description'])) {
        $this->addError('Описание ' . $not_str);
      }

      $nameLen = mb_strlen($req['description']);
      if ($nameLen < 2 || $nameLen > 1000) {
        $this->addError('Описание не может превышать 2000 символов или быть менее 2 символов');
      }
    }
    if (isset($req['category'])) {
      if ($req['category'] == 0 || !preg_match($pattern_num, $req['category'])) {
        $this->addError('Недопустимая категория');
      }

      $nameLen = mb_strlen($req['category']);
      if ($nameLen < 0 || $nameLen > 2) {
        $this->addError($err_str);
      }

    }
    if (isset($req['categories'])) {
      if ($req['categories'] == 0 || !preg_match($pattern_num, $req['categories'])) {
        $this->addError('Недопустимая подкатегория');
      }

      $nameLen = mb_strlen($req['categories']);
      if ($nameLen < 0 || $nameLen > 2) {
        $this->addError($err_str);
      }

    }
    if (isset($req['sized'])) {
      if (!preg_match($pattern_num, $req['sized'])) {
        $this->addError('Нужно указать размер цифрами');
      }

      $nameLen = mb_strlen($req['sized']);
      if ($nameLen < 2 || $nameLen > 20) {
        $this->addError('Размер не может превышать 20 символов или быть менее 2 символов');
      }
    }
    if (isset($req['quantity'])) {
      $quantity = count($req['quantity']);
      for ($i = 0; $i < $quantity; $i++) {
        if ($req['quantity'][$i] == 0 || !preg_match($pattern_num, $req['quantity'][$i])) {
          $this->addError($err);
        }

        $nameLen = mb_strlen($req['quantity'][$i]);
        if ($nameLen < 0 || $nameLen > 50) {
          $this->addError('Количество не может превышать 50 или быть менее 1');
        }
      }
    }
    if (isset($req['amount'])) {
      if (!preg_match($pattern_num, $req['amount'])) {
        $this->addError($err);
      }

      $nameLen = mb_strlen($req['amount']);
      if ($nameLen < 4 || $nameLen > 20) {
        $this->addError($err_str);
      }

    }
    if (isset($req['delivery'])) {
      if (!preg_match($pattern_num, $req['delivery']) && $req['delivery'] !== 500 && $req['delivery'] !== 250 && $req['delivery'] !== 1000) {
        $this->addError($err);
      }

      $nameLen = mb_strlen($req['delivery']);
      if ($nameLen < 3 || $nameLen > 4) {
        $this->addError($err_str);
      }

    }
    if (isset($req['first_name'])) {
      if (!preg_match('/^[а-яё\-\s]{2,50}$/isu', $req['first_name'])) {
        $this->addError('Имя ' . $not_str);
      }

      $nameLen = mb_strlen($req['first_name']);
      if ($nameLen < 2 || $nameLen > 50) {
        $this->addError('Имя не может превышать 50 символов или быть менее 2 символов');
      }
    }
    if (isset($req['last_name'])) {
      if (!preg_match('/^[а-яё\-\s]{2,50}$/isu', $req['last_name'])) {
        $this->addError('Фамилия ' . $not_str);
      }

      $nameLen = mb_strlen($req['last_name']);
      if ($nameLen < 2 || $nameLen > 20) {
        $this->addError('Фамилия не может превышать 50 символов или быть менее 2 символов');
      }
    }
    if (isset($req['address'])) {
      if (!preg_match('/^[а-яё\-\.\s\d]{2,100}$/isu', $req['address'])) {
        $this->addError('Адрес ' . $not_str);
      }

      $nameLen = mb_strlen($req['address']);
      if ($nameLen < 5 || $nameLen > 100) {
        $this->addError('Адрес не может превышать 100 символов или быть менее 2 символов');
      }
    }
    if (isset($req['city'])) {
      if (!preg_match('/^[а-яё\-\s]{2,50}$/isu', $req['city'])) {
        $this->addError('Название города ' . $not_str);
      }

      $nameLen = mb_strlen($req['city']);
      if ($nameLen < 2 || $nameLen > 50) {
        $this->addError('Название города не может превышать 50 символов или быть менее 2 символов');
      }
    }
    if (isset($req['postcode'])) {
      if (!preg_match('/^[0-9]{1,6}$/isu', $req['postcode'])) {
        $this->addError('Индекс может быть только цифровым');
      }

      $nameLen = mb_strlen($req['postcode']);
      if ($nameLen < 1 || $nameLen > 6) {
        $this->addError('Индекс не может превышать 6 цифр');
      }

    }
    if (isset($req['phone'])) {
      if (!preg_match('/^[+]{1}[0-9]{11}$/isu', $req['phone'])) {
        $this->addError('Недопустимый формат номера');
      }

      $nameLen = mb_strlen($req['phone']);
      if ($nameLen < 1 || $nameLen > 12) {
        $this->addError('Номер не может превышать 12 символов');
      }

    }
    if (isset($req['total'])) {
      if (!preg_match($pattern_num, $req['total'])) {
        $this->addError($err);
      }

      $nameLen = mb_strlen($req['total']);
      if ($nameLen < 4 || $nameLen > 20) {
        $this->addError($err_str);
      }

    }
    if (isset($req['payment'])) {
      if (!preg_match('/^[a-z\sа-я.]{2,50}$/isu', $req['payment'])) {
        $this->addError($err);
      }

      $nameLen = mb_strlen($req['payment']);
      if ($nameLen < 4 || $nameLen > 50) {
        $this->addError($err_str);
      }

    }
    if (isset($req['member_id'])) {
      if (!preg_match($pattern_num, $req['member_id'])) {
        $this->addError('Ошибка');
      }

      $nameLen = mb_strlen($req['member_id']);
      if ($nameLen < 1 || $nameLen > 10000) {
        $this->addError($err_str);
      }

    }
    if (isset($req['full_name'])) {
      if (!preg_match('/^[a-zёа-я\-\s]{2,50}$/isu', $req['full_name'])) {
        $this->addError('Поле ФИО ' . $not_str);
      }

      $nameLen = mb_strlen($req['full_name']);
      if ($nameLen < 2 || $nameLen > 50) {
        $this->addError('Поле ФИО не может превышать 50 символов или быть менее 2 символов');
      }
    }
    if (isset($req['text'])) {
      if (preg_match('/[\$\[\]*{}]+/isu', $req['text'])) {
        $this->addError('Сообщение ' . $not_str);
      }

      $nameLen = mb_strlen($req['text']);
      if ($nameLen < 15 || $nameLen > 2000) {
        $this->addError('Сообщение не может превышать 2000 символов или быть менее 20 символов');
      }
    }
    return $this->getErrors();
  }
}
