<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc.php';
  require_once PROJECT_ROOT.'/components/check_adm.inc.php';
?>
        <main class="box-small">
          <div class="line"></div>
          <?php if(in_array($user_id, $root)){
            $per_page = 5; //Количество записей на странице редактирования пользователей
            $count_user = $pdo->query("SELECT COUNT(*) FROM core_users")->fetchColumn();
            $total_page = ceil($count_user / $per_page);
            if($page_num > $total_page) $page_num = $total_page; //Если значение $page_num большем чем страниц, то выводим последнюю страницу
            $from_num = ($page_num - 1) * $per_page;
            $sql_user = $pdo->prepare("SELECT * FROM core_users WHERE id>0 LIMIT $from_num, $per_page");
            echo PHP_EOL ?>
          <div class="profile">
            <?=$menu?>
            <div class="line"></div>
            <div class="flex-box flex-wrap">
              <div class="flex-box box-small">
                <div>Логин</div>
                <div class="box-small"></div>
                <div>Имя</div>
                <div class="box-small"></div>
                <div>Доступ</div>
                <div class="box-small"></div>
                <div>Ред.</div>
              </div>
              <div class="flex-box box-small to-end">
                <div>E-mail</div>
                <div class="box-small"></div>
                <div>IP Адрес</div>
                <div class="box-small"></div>
                <div>Удалить</div>
              </div>
            </div>
            <div class="line"></div>
            <?php $sql_user->execute();
            while($item = $sql_user->fetch(PDO::FETCH_LAZY)){
              ?><div class="users flex-box flex-wrap center">
              <div class="flex-box center box-small" data-id="<?=$item['id']?>">
                <div class="show">
                  <?=$item['login'].PHP_EOL?>
                </div>
                <div class="box-small">
                  <?=$item['username'].PHP_EOL?>
                </div>
                <div class="box-small">
                  <?=$item['adm'].PHP_EOL?>
                </div>
                <div class="users-edit" data-id="<?=$item['id']?>">
                  Ред.
                </div>
              </div>
              <div class="users-info center flex-box to-end">
                <div class="box-small">
                  <?=$item['email'].PHP_EOL?>
                </div>
                <div class="box-small">
                  <?=$item['ip_address'].PHP_EOL?>
                </div>
                <div>
                  <form method="POST" action="<?=PROJECT_URL?>/system/controllers/posts/delete.php">
                    <input hidden name="id" value="<?=$item['id']?>">
                    <input hidden name="table_id" value="5">
                    <button class="admin-button">Удалить</button>
                  </form>
                </div>
              </div>
              </div>
            <?php }
            ?><div class="page-num flex-box flex-wrap box">
              <?php for($i = 1; $i <= $total_page; $i++){ //Пагинация на странице редактирования пользователей
                if($i == $page_num){
                  echo PHP_EOL ?>
              <a class="pagination-active" href="<?=PROJECT_URL?>/admin/users.php?page_num=<?=$i?>"><?=$i?></a>
                <?php }else{
                  echo PHP_EOL ?>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/users.php?page_num=<?=$i?>"><?=$i?></a>
                <?php } ?>
              <?php } echo PHP_EOL ?>
            </div>
            <div id="modal-kit" class="modal-kit">
              <div class="overlay"></div>
              <div class="modal box" id="modal">

              </div>
            </div>
          </div>
          <?php }else{
            echo PHP_EOL ?>
          <div class="box">
            Не правильная ссылка.
          </div>
          <?php } echo PHP_EOL ?>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc.php';
?>
