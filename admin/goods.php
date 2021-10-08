<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once PROJECT_ROOT.'/components/header.inc';
if(isset($_COOKIE['member_id']) === false){
  header('Location: '.PROJECT_URL.'/auth/login.php');
}else{
  require_once PROJECT_ROOT.'/components/menu_adm.inc';
  if(!in_array($user_id, $root) && !in_array($user_id, $manager)){
    header('Location: '.PROJECT_URL.'/errors/err403.php');
  }else{ ?>
        <main class="box-small">
          <div class="line"></div>
          <?php //Пагинация на странице редактирования товаров
          $count_tovar = $pdo->query("SELECT COUNT(*) FROM core_goods")->fetchColumn();
          $total_page = ceil($count_tovar / $per_page);
          if($page_num > $total_page) $page_num = $total_page; //Если значение $page_num большем чем страниц, то выводим последнюю страницу
          if($count_tovar == 0) $from_num = 1;
          else $from_num = ($page_num - 1) * $per_page;
          $sql = $pdo->prepare("SELECT * FROM core_goods WHERE id>0 LIMIT $from_num, $per_page");
          echo PHP_EOL ?>
          <div class="profile" onclick="errUnset()">
            <?=$menu?>
            <div class="line"></div>
            <div class="box-small">
              <div class="tovars-new" data-id="0" onclick="tovarModalShow('new')">
                Добавить товар
                <div class="show"></div>
              </div>
            </div>
            <div class="line"></div>
            <div class="flex-box">
              <div class="tovar flex-box box-small">
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
              ?><div class="tovars basket flex-box box-small center">
              <div class="flex-box center">
                <div class="tovar-photo">
                  <img src="<?=PROJECT_URL.$item['photo']?>" alt="Фото" />
                </div>
                <div class="box-small"></div>
                <div>
                  <div class="big-font"><b><?=$item['title']?></b></div>
                  <div>арт. <?=$item['art']?></div>
                  <div class="box-small"></div>
                  <div class="tovars-edit" data-id="<?=$item['id']?>" onclick="tovarModalShow('edit')">
                    Редактировать
                    <div class="show"></div>
                  </div>
                </div>
              </div>
              <div class="basket-line center flex-box to-end">
                <div>
                  <?=$item['razmer'].PHP_EOL?>
                </div>
                <div class="price">
                  <?=$item['price'].PHP_EOL?>
                </div>
                <div>
                  <form method="POST" action="<?=PROJECT_URL?>/system/controllers/posts/delete.php">
                    <input hidden name="id" value="<?=$item['id']?>">
                    <input hidden name="tableID" value="1">
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
              <div class="modal box" id="modal">

              </div>
            </div>
          </div>
        </main>
  <?php }
  echo PHP_EOL;
}
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
