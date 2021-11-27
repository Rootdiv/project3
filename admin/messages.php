<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  require_once PROJECT_ROOT . '/components/header.inc.php';
  require_once PROJECT_ROOT . '/components/check_adm.inc.php';
  $count = $pdo->query("SELECT COUNT(*) FROM feedback WHERE id>0 AND $adm_msg")->fetchColumn();
  require_once PROJECT_ROOT . '/components/pagination.inc.php';
  $sql = $pdo->prepare("SELECT * FROM feedback WHERE id>0 AND $adm_msg LIMIT $per_page OFFSET $list");
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="profile">
            <?=$menu;?>
            <div class="line"></div>
            <?php echo $adm_msg_menu; // Меню админа скрытое для менеджера
            $sql->execute();
            $items = $sql->fetchAll();
            if (empty($items)) {
              echo '<div class="box-small">Сообщений нет</div>';
            }?>
            <div class="flex-box flex-wrap">
              <?php foreach ($items as $item_msg) {
              $text = str_replace(PHP_EOL, '<br>', $item_msg['text']);
              if ($item_msg['adm_msg'] == 1) {
                $msg_from = 'Администрация';
              } elseif ($item_msg['adm_msg'] == 2) {
                $msg_from = 'Менеджеры';
              }?>
              <div class="messages">
                <div class="flex-box">
                  <div class="field">Сообщение &#8470;</div>
                  <div><?=$item_msg['id'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Адресат</div>
                  <div><?=$msg_from;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">ФИО</div>
                  <div><?=$item_msg['full_name'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">E-mail</div>
                  <div><?=$item_msg['email'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Телефон</div>
                  <div><?=$item_msg['phone'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Сообщение</div>
                  <div><?=$text;?></div>
                </div>
                <form method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/delete.php">
                  <input hidden name="id" value="<?=$item_msg['id'];?>" />
                  <input hidden name="table_id" value="7" />
                  <button class="admin-button">Удалить</button>
                </form>
              </div>
              <!-- /.message -->
              <?php }?>
            </div>
            <div class="page-num flex-box flex-wrap box">
              <?php paginationArrow('admin/' . $filename, $total_page, $page_num, $per_page, $adm);?>
            </div>
          <div>
          <!-- /.profile -->
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
