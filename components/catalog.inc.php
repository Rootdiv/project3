<?php
//Файл логики страницы catalog.php
//Данные для пагинации
$per_page = 4;
$page_num = 1;
if (isset($_GET['page_num']) && !empty($_GET['page_num'])) {
  $page_num = $_GET['page_num'];
}
if (!preg_match('/^[0-9]+$/s', $page_num)) {
  $page_num = 1;
}

//Данные для вывода заголовка
$catalog = new Goods(0);
$goods = $catalog->setTable();
if (isset($_GET['category']) && !empty($_GET['category'])) {
  $category = new Category((int) $_GET['category']);
  $category_title = $category->getField('title');
} else {
  $category_title = 'Каталог';
}

//Данные для фильтрации товаров
if (isset($_GET['category'])) {
  $category = (int) $_GET['category'];
  $category_text = "AND category=$category";
} else {
  $category_text = '';
}
if (isset($_GET['categories'])) {
  $categories = (int) $_GET['categories'];
  $categories_text = "AND categories=$categories";
} else {
  $categories_text = '';
}
if (isset($_GET['size'])) {
  $size = (int) $_GET['size'];
  $size_text = "AND sized=$size";
} else {
  $size_text = '';
}
if (isset($_GET['price'])) {
  if ((int) $_GET['price'] == 1) {
    $price_text = "AND price<=1000";
  } elseif ((int) $_GET['price'] == 2) {
    $price_text = "AND price>1000 AND price<=3000";
  } elseif ((int) $_GET['price'] == 3) {
    $price_text = "AND price>3000 AND price<=6000";
  } elseif ((int) $_GET['price'] == 4) {
    $price_text = "AND price>6000";
  } else {
    $price_text = '';
  }
} else {
  $price_text = '';
}
