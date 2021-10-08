<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc';
  if(isset($_GET['routed'])){
    $get_line = '';
    foreach($_GET as $key => $value){
      if($key != 'routed'){
        $get_line .= $key.'='.$value.'&';
      }
    }
    header('Location: '.PROJECT_URL.'/catalog.php?'.trim($get_line, '&'));
  }
  $catalog = new Goods(0);
  $goods = $catalog->setTable();
  if(isset($_GET['category']) && $_GET['category'] != 0){
    $category = new Category((int)$_GET['category']);
    $category_title = $category->getField('title');
  }
  else{
    $category_title = 'Каталог';
  }
  if(stristr($_SERVER['REQUEST_URI'], '?') ? $z = '&' : $z = '?') //Проверяем наличие get параметров в адресной строке
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="box-small"></div>
          <div class="menu">
            <a href="<?=PROJECT_URL ?>/main.php">Главная</a> / <?=$category_title.PHP_EOL?>
          </div>
          <div>
            <div class="space-min"></div>
            <div class="big-font title-font title-pad">
              <?=$category_title.PHP_EOL?>
            </div>
            <div class="new-font size-font title-mess">
              Все товары
            </div>
          </div>
          <div class="flex-box catalog-sort">
            <div class="categories">
              <div class="catalog-name">
                Категория
                <img class="categories-img" src="<?=PROJECT_URL?>/img/icons/show.png" alt="Иконка" />
              </div>
              <div class="categories-items new-font hidden">
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&categories=1">Курки</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&categories=2">Джинсы</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&categories=3">Обувь</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&categories=4">Аксессуары</a>
              </div>
            </div>
            <div class="box-small"></div>
            <div class="size">
              <div class="catalog-name">
                Размер
                <img class="size-img" src="<?=PROJECT_URL?>/img/icons/show.png" alt="Иконка" />
              </div>
              <div class="size-items hidden new-font">
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&size=38">38</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&size=39">39</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&size=40">40</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&size=41">41</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&size=42">42</a>
              </div>
            </div>
            <div class="box-small"></div>
            <div class="prices">
              <div class="catalog-name">
                Стоимость
                <img class="prices-img" src="<?=PROJECT_URL?>/img/icons/show.png" alt="Иконка" />
              </div>
              <div class="prices-items hidden new-font">
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&price=1">0-1000 руб.</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&price=2">1000-3000 руб.</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&price=3">3000-6000 руб.</a>
                <a href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&price=4">6000-20000 руб.</a>
              </div>
            </div>
          </div>
          <div class="box"></div>
          <div class="flex-box flex-wrap catalog">
            <?php if(isset($_GET['category'])){
              $category = (int)$_GET['category'];
              $category_text = "AND category=$category";
            }
            else{
              $category_text = '';
            }
            if(isset($_GET['categories'])){
              $categories = (int)$_GET['categories'];
              $categories_text = "AND categories=$categories";
            }
            else{
              $categories_text = '';
            }
            if(isset($_GET['size'])){
              $size = (int)$_GET['size'];
              $size_text = "AND razmer=$size";
            }
            else{
              $size_text = '';
            }
            if(isset($_GET['price'])){
              if((int)$_GET['price'] == 1){
                $price_text = "AND price<=1000";
              }
              elseif((int)$_GET['price'] == 2){
                $price_text = "AND price>1000 AND price<=3000";
              }
              elseif((int)$_GET['price'] == 3){
                $price_text = "AND price>3000 AND price<=6000";
              }
              elseif((int)$_GET['price'] == 4){
                $price_text = "AND price>6000";
              }
              else{
                $price_text = '';
              }
            }
            else{
              $price_text = '';
            }
            $count = $pdo->query("SELECT COUNT(*) FROM $goods WHERE id>0 $category_text $categories_text $size_text $price_text")->fetchColumn();
            $total_page = ceil($count / $per_page);
            if($page_num > $total_page) echo '<div style="padding-bottom: 15px">По Вашему запросу товаров нет.</div>';
            $from_num = ($page_num - 1) * $per_page;
            $sql = $pdo->prepare("SELECT * FROM $goods WHERE id>0 $category_text $categories_text $size_text $price_text LIMIT $from_num, $per_page");
            $sql->execute();
            while($item = $sql->fetch(PDO::FETCH_LAZY)){
              echo PHP_EOL ?>
              <div>
                <a href="<?=PROJECT_URL?>/card.php?id=<?=$item['id']?>" class="catalog-photo box bg-fix"
                   style="background-image: url('<?=PROJECT_URL.$item['photo']?>');">
                </a>
                <div class="name box-small">
                  <a href="<?=PROJECT_URL?>/card.php?id=<?=$item['id']?>"><b><?=$item['title']?></b></a>
                </div>
                <div class="price">
                  <?=$item['price']?> руб.
                </div>
                <div class="space-min"></div>
              </div>
            <?php } echo PHP_EOL; ?>
          </div>
          <div class="page-num flex-box box">
            <?php for($i = 1; $i <= $total_page; $i++){
              if($i == $page_num){ echo PHP_EOL ?>
            <a class="pagination-active" href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&page_num=<?=$i?>"><?=$i?></a>
              <?php }else{ echo PHP_EOL ?>
            <a class="pagination" href="<?=$_SERVER['REQUEST_URI'].$z?>routed=1&page_num=<?=$i?>"><?=$i?></a>
              <?php }
            } echo PHP_EOL ?>
          </div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
