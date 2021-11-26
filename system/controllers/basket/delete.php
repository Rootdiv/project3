<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  session_start();
  //Удаляем товар
  $id = (int) $_GET['id'];
  $basket = $_SESSION['basket'];
  if (in_array($id, $basket)) {
    //считаем количество товаров в корзине
    $count_id = count($basket);
    //бежим по корзине и ищем конкретный товар
    for ($i = 0; $i < $count_id; $i++) {
      //если нашли этот товар
      if ($basket[$i] == $id) {
        //то удаляем из корзины
        unset($basket[$i]);
        break;
      }
    }
    sort($basket);
  }
  $_SESSION['basket'] = $basket;
}
