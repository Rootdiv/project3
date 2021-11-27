<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
require_once PROJECT_ROOT . '/components/header.inc.php';
require_once PROJECT_ROOT . '/components/check_adm.inc.php';
$per_page = 5; //Количество записей на странице редактирования пользователей
$count = $pdo->query("SELECT COUNT(*) FROM core_users")->fetchColumn();
require_once PROJECT_ROOT . '/components/pagination.inc.php';
$sql_user = $pdo->prepare("SELECT * FROM core_users WHERE id>0 LIMIT $per_page OFFSET $list");
?>
        <main class="box-small">
          <div class="profile">
            <div class="line"></div>
            <?=$menu;?>
            <div class="line"></div>
            <?php if (in_array($user_id, $manager)) {
              echo '<div class="box">Не правильная ссылка.</div>';
            } else {?>
            <div class="box-small"></div>
            <div class="flex-box flex-wrap">
            <?php $sql_user->execute();
            $items = $sql_user->fetchAll();
            foreach ($items as $item) {
              if ($item['adm'] == 1) {
                $item_adm = 'Администрация';
              } elseif ($item['adm'] == 2) {
                $item_adm = 'Менеджеры';
              } elseif ($item['adm'] == 3) {
                $item_adm = 'Пользователи';
              }?>
              <div class="users show" data-id="<?=$item['id'];?>">
                <div class="flex-box">
                  <div class="field">Логин</div>
                  <div><?=$item['login'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Имя</div>
                  <div><?=$item['username'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Доступ</div>
                  <div><?=$item_adm;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">E-mail</div>
                  <div><?=$item['email'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">IP Адрес</div>
                  <div><?=$item['ip_address'];?></div>
                </div>
                <div class="flex-box">
                  <div class="users-edit" data-id="<?=$item['id'];?>">
                    Редактировать
                  </div>
                  <form method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/delete.php">
                    <input hidden name="id" value="<?=$item['id'];?>" />
                    <input hidden name="table_id" value="5" />
                    <button class="admin-button">Удалить</button>
                  </form>
                </div>
              </div>
              <!-- /.users -->
              <?php }?>
            </div>
            <div class="page-num flex-box flex-wrap box">
              <?php paginationNoArrow('admin/'.$filename, $total_page, $page_num);?>
            </div>
            <!-- /.page-num -->
            <div id="modal-kit" class="modal-kit">
              <div class="overlay"></div>
              <div class="modal box" id="modal">

              </div>
            </div>
            <!-- /.modal-kit -->
            <?php }?>
          </div>
          <!-- /.profile -->
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
