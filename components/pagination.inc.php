<?php
//Считаем общее количество страниц в соответствии со значением $count полученным со страницы подключения
$total_page = ceil($count / $per_page);
$total_page++; //увеличиваем число страниц на единицу чтобы начальное значение было равно единице, а не нулю.
if ($page_num > $total_page - 1) { //Если значение $page_num большем чем страниц, то выводим последнюю страницу
  $page_num = $total_page - 1;
}
$list = --$page_num * $per_page; //Указываем начало вывода данных
$list < 0 ? $list = 0 : $list; //Если $list меньше нуля, то приравниваем его к нулю

function paginationArrow(string $page, int $total, int $num, int $limit, string $sub_page = '') {
  if ($num >= 1) {
    echo '<a class="pagination" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=1"> << </a>';
    echo '<a class="pagination" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . $num . '"> < </a>';
  }
  $start = $num + 1 - $limit;
  $end = $num + 1 + $limit;
  for ($i = 1; $i < $total; $i++) {
    if ($i >= $start && $i <= $end) {
      if ($i == $num + 1) {
        echo '<a class="pagination active" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . $i . '">' . $i . '</a>';
      } else {
        echo '<a class="pagination" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . $i . '">' . $i . '</a>';
      }
    }
  }
  if ($i > $num && ($num + 2) < $i) {
    echo '<a class="pagination" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . ($num + 2) . '"> > </a>';
    echo '<a class="pagination" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . ($i - 1) . '"> >> </a>';
  }
}

function paginationNoArrow(string $page, int $total, int $num, string $sub_page = '') {
  for ($i = 1; $i <= $total - 1; $i++) {
    if ($i == $num + 1) {
      echo '<a class="pagination active" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . $i . '">' . $i . '</a>';
    } else {
      echo '<a class="pagination" href="' . PROJECT_URL . '/' . $page . '?' . $sub_page . 'page_num=' . $i . '">' . $i . '</a>';
    }
  }
}
//Функция пагинации в каталоге товаров и на странице заказов
function pagination(string $z, int $total, int $num) {
  for ($i = 1; $i <= $total - 1; $i++) {
    if ($i == $num + 1) {
      echo '<a class="pagination active" href="' . $_SERVER['REQUEST_URI'] . $z . 'routed=1&page_num=' . $i . '">' . $i . '</a>';
    } else {
      echo '<a class="pagination" href="' . $_SERVER['REQUEST_URI'] . $z . 'routed=1&page_num=' . $i . '">' . $i . '</a>';
    }
  }
}
