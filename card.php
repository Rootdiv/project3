<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc';
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="box-small"></div>
          <?php if(isset($_GET['id']) == false || ctype_digit($_GET['id']) == false || $_GET['id'] == 0){
            echo '<div class="box-small">Вы пришли по неправильной ссылке.</div>';
          }else{
            $item = new Goods((int)$_GET['id']);
            if(@$item->getField('id') !== ''){
              $category = new Category($item->getField('category'));
              $category_title = $category->getField('title');
              $category_link = $category->getField('path');
              $categories = new Categories($item->getField('categories'));
              $categories_title = $categories->getField('title');
              $categories_link = $categories->getField('path');
              $product_link = '<a href='.PROJECT_URL.$category_link.'>'.$category_title.'</a> / <a href='.PROJECT_URL
                .$categories_link.'>'.$categories_title.'</a> / '.$item->getField("title").PHP_EOL;
              $no_product = false;
            }else{
              $product_link = 'Ошибка'.PHP_EOL;
              $no_product = true;
            }
          ?><div class="menu">
            <a href="<?=PROJECT_URL?>/main.php">Главная</a> / <?=$product_link?>
          </div>
            <?php if(!$no_product){ echo PHP_EOL ?>
          <div class="box-small"></div>
          <div>
            <div class="detail-photo flex-box">
              <div class="detail-photo-img bg-fix"
                   style="background-image: url('<?=PROJECT_URL.$item->getField('photo')?>')">
              </div>
            </div>
            <div class="box"></div>
            <div class="detail-title big-font">
              <b><?=$item->getField('title')?></b>
            </div>
            <div class="detail-article">Артикул: <?=$item->getField('article')?></div>
            <div class="box new-font size-font"><?=$item->getField('price')?> руб.</div>
            <div class="description box-small"> <?=$item->getField('description')?></div>
            <div class="big-font box">Размер</div>
            <div class="detail-size flex-box">
              <div class="detail-size-item">38</div>
              <div class="box-small"></div>
              <div class="detail-size-item">39</div>
              <div class="box-small"></div>
              <div class="detail-size-item">40</div>
              <div class="box-small"></div>
              <div class="detail-size-item">41</div>
              <div class="box-small"></div>
              <div class="detail-size-item">42</div>
            </div>
            <div class="box"></div>
            <div class="box">
              <a class="add-basket big-font" href="<?=PROJECT_URL?>/system/controllers/basket/create.php?id=<?=$item->getField('id')?>">
                Добавить в корзину
              </a>
            </div>
          </div>
          <div class="box"></div>
          <?php } else echo '<div class="box">Товар отсутствует в каталоге</div>';
        } echo PHP_EOL ?>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
