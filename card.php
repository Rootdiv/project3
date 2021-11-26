<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  require_once PROJECT_ROOT . '/components/header.inc.php';
?>
        <main class="box-small">
          <div class="line"></div>
          <?php
          if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
            echo '<div class="box">Вы пришли по неправильной ссылке.</div>';
          } else {
            $item = new Goods((int) $_GET['id']);
            if (@$item->getField('id') !== '') {
              $category = new Category($item->getField('category'));
              $category_title = $category->getField('title');
              $category_link = PROJECT_URL . $category->getField('path');
              $categories = new Categories($item->getField('categories'));
              $categories_title = $categories->getField('title');
              $categories_link = PROJECT_URL . $categories->getField('path');
              $product = '<a href="' . $category_link . '">' . $category_title . '</a> / <a href="'
              . $categories_link . '">' . $categories_title . '</a> / ' . $item->getField("title");
              $no_product = false;
            } else {
              $product = 'Ошибка';
              $no_product = true;
            }
            ?>
          <div class="menu">
            <a href="<?=PROJECT_URL;?>/main.php">Главная</a> / <?=$product . PHP_EOL;?>
          </div>
          <?php if (!$no_product) {?>
          <div class="detail">
            <div class="detail-photo flex-box">
              <img class="detail-photo-img" src="<?=PROJECT_URL . $item->getField('photo');?>"
                alt="<?=$item->getField('title');?>" />
            </div>
            <div class="box"></div>
            <div class="detail-title big-font">
              <b><?=$item->getField('title');?></b>
            </div>
            <div class="detail-article">Артикул: <?=$item->getField('article');?></div>
            <div class="box new-font size-font"><?=$item->getField('price');?> руб.</div>
            <div class="description box-small"> <?=$item->getField('description');?></div>
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
              <a class="add-basket big-font"
                href="<?=PROJECT_URL;?>/system/controllers/basket/create.php?id=<?=$item->getField('id');?>">
                Добавить в корзину
              </a>
            </div>
          </div>
          <?php } else {
              echo '<div class="box">Товар отсутствует в каталоге</div>';
            }
          }?>
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
