<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  if (isset($_GET['routed'])) {
    $get_line = '';
    foreach ($_GET as $key => $value) {
      if ($key != 'routed') {
        $get_line .= $key . '=' . $value . '&';
      }
    }
    header('Location: ' . PROJECT_URL . '/catalog.php?' . trim($get_line, '&'));
  }
  require_once PROJECT_ROOT . '/components/header.inc.php';
  require_once PROJECT_ROOT . '/components/catalog.inc.php';
  //Считаем количество товаров по запросу для пагинации
  $count = $pdo->query("SELECT COUNT(*) FROM $goods WHERE id>0 $category_text $categories_text $size_text
    $price_text")->fetchColumn();
  $z = stristr($_SERVER['REQUEST_URI'], '?') ? '&' : '?'; //Проверяем наличие get параметров в адресной строке
  require_once PROJECT_ROOT . '/components/pagination.inc.php';
  //Получаем товары в соответствии с запросом
  $sql = $pdo->prepare("SELECT * FROM $goods WHERE id>0 $category_text $categories_text $size_text $price_text
    LIMIT $per_page OFFSET $list");
  $sql->execute();
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="menu">
            <a href="<?=PROJECT_URL;?>/main.php">Главная</a> / <?=$category_title;?>
          </div>
          <div class="catalog-title">
            <div class="space-min"></div>
            <div class="big-font title">
              <?=$category_title;?>
            </div>
            <div class="new-font size-font title-mess">
              Все товары
            </div>
          </div>
          <div class="flex-box catalog-sort">
            <div class="categories">
              <div class="catalog-name">
                Категория
                <img class="categories-img" src="<?=PROJECT_URL;?>/img/icons/show.png" alt="Стрелка" />
              </div>
              <div class="categories-items new-font hidden">
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&categories=1">Курки</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&categories=2">Джинсы</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&categories=3">Обувь</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&categories=4">Аксессуары</a>
              </div>
            </div>
            <div class="box-small"></div>
            <div class="size">
              <div class="catalog-name">
                Размер
                <img class="size-img" src="<?=PROJECT_URL;?>/img/icons/show.png" alt="Стрелка" />
              </div>
              <div class="size-items hidden new-font">
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&size=38">38</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&size=39">39</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&size=40">40</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&size=41">41</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&size=42">42</a>
              </div>
            </div>
            <div class="box-small"></div>
            <div class="prices">
              <div class="catalog-name">
                Стоимость
                <img class="prices-img" src="<?=PROJECT_URL;?>/img/icons/show.png" alt="Стрелка" />
              </div>
              <div class="prices-items hidden new-font">
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&price=1">0-1000 руб.</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&price=2">1000-3000 руб.</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&price=3">3000-6000 руб.</a>
                <a href="<?=$_SERVER['REQUEST_URI'] . $z;?>routed=1&price=4">6000-20000 руб.</a>
              </div>
            </div>
          </div>
          <div class="box"></div>
          <div class="flex-box flex-wrap catalog">
          <?php $items = $sql->fetchAll();
          if (empty($items)) {
            echo '<div style="padding-bottom: 15px">По Вашему запросу товаров нет.</div>';
          } //код внутри foreach отработает только если в $items что-то есть
          foreach ($items as $item) {?>
            <a href="<?=PROJECT_URL;?>/card.php?id=<?=$item['id'];?>" class="card">
              <div class="catalog-photo">
                <img src="<?=PROJECT_URL . $item['photo'];?>" alt="<?=$item['title'];?>" />
              </div>
              <div class="box">
                <b><?=$item['title'];?></b>
              </div>
              <div class="price">
                <?=$item['price'];?> руб.
              </div>
            </a>
          <?php }?>
          </div>
          <!-- /.catalog -->
          <div class="page-num flex-box box">
            <?php pagination($z, $total_page, $page_num);?>
          </div>
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
