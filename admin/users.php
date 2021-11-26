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
            $items = $sql_user->fetchAll();
            foreach ($items as $item) {?>
            <div class="users flex-box flex-wrap center">
              <div class="flex-box center box-small" data-id="<?=$item['id'];?>">
                <div class="show">
                  <?=$item['login'];?>
                </div>
                <div class="box-small">
                  <?=$item['username'];?>
                </div>
                <div class="box-small">
                  <?=$item['adm'];?>
                </div>
                <div class="users-edit" data-id="<?=$item['id'];?>">
                  Ред.
                </div>
              </div>
              <div class="users-info center flex-box to-end">
                <div class="box-small">
                  <?=$item['email'];?>
                </div>
                <div class="box-small">
                  <?=$item['ip_address'];?>
                </div>
                <div>
                  <form method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/delete.php">
                    <input hidden name="id" value="<?=$item['id'];?>" />
                    <input hidden name="table_id" value="5" />
                    <button class="admin-button">Удалить</button>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.users -->
            <?php }?>
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
