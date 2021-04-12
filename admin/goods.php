<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc';
  require_once PROJECT_ROOT.'/components/check_adm.inc';
?>
        <main class="box-small">
          <div class="line"></div>
          <?php //Пагинация на странице редактирования товаров
          $count_product = $pdo->query("SELECT COUNT(*) FROM core_goods")->fetchColumn();
          $total_page = ceil($count_product / $per_page);
          if($page_num > $total_page) $page_num = $total_page; //Если значение $page_num большем чем страниц, то выводим последнюю страницу
          if($count_product == 0) $from_num = 1;
          else $from_num = ($page_num - 1) * $per_page;
          $sql = $pdo->prepare("SELECT * FROM core_goods WHERE id>0 LIMIT $from_num, $per_page");
          echo PHP_EOL ?>
          <div class="profile">
            <?=$menu?>
            <div class="line"></div>
            <div class="box-small">
              <div class="products-new" data-id="0">
                Добавить товар
                <div class="show"></div>
              </div>
            </div>
            <div class="line"></div>
            <div class="flex-box">
              <div class="product flex-box box-small">
                <div>Фото</div>
                <div>Наименование</div>
              </div>
              <div class="basket-line flex-box box-small to-end">
                <div>Размер</div>
                <div>Стоимость</div>
                <div>Удалить</div>
              </div>
            </div>
            <div class="line"></div>
            <?php $sql->execute();
            while($item = $sql->fetch(PDO::FETCH_LAZY)){
              ?><div class="products basket flex-box box-small center">
              <div class="flex-box center">
                <div class="product-photo">
                  <img src="<?=PROJECT_URL.$item['photo']?>" alt="Фото" />
                </div>
                <div class="box-small"></div>
                <div>
                  <div class="big-font"><b><?=$item['title']?></b></div>
                  <div>арт. <?=$item['article']?></div>
                  <div class="box-small"></div>
                  <div class="products-edit" data-id="<?=$item['id']?>">
                    Редактировать
                  </div>
                </div>
              </div>
              <div class="basket-line center flex-box to-end">
                <div>
                  <?=$item['sized'].PHP_EOL?>
                </div>
                <div class="price">
                  <?=$item['price'].PHP_EOL?>
                </div>
                <div>
                  <form method="POST" action="<?=PROJECT_URL?>/system/controllers/posts/delete.php">
                    <input hidden name="id" value="<?=$item['id']?>">
                    <input hidden name="table_id" value="1">
                    <button class="admin-button">Удалить</button>
                  </form>
                </div>
              </div>
              </div>
            <?php }
            ?><div class="page-num flex-box flex-wrap box-small">
              <?php for($i = 1; $i <= $total_page; $i++){ //Пагинация на странице редактирования товаров
                if($i == $page_num){ echo PHP_EOL ?>
              <a class="pagination-active" href="<?=PROJECT_URL?>/admin/goods.php?page_num=<?=$i?>"><?=$i?></a>
                <?php }else{ echo PHP_EOL ?>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/goods.php?page_num=<?=$i?>"><?=$i?></a>
                <?php } ?>
              <?php } echo PHP_EOL ?>
            </div>
            <div id="modal-kit" class="modal-kit">
              <div class="overlay"></div>
              <div class="modal box" id="modal">

              </div>
            </div>
          </div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
