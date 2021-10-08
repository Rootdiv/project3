<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc';
  require_once PROJECT_ROOT.'/components/check_adm.inc';
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="profile">
            <?=$menu?>
            <div class="line"></div>
            <?php echo $adm_msg_menu; // Меню админа скрытое для менеджера
            $count_msg = $pdo->query("SELECT COUNT(*) FROM feedback WHERE id>0 AND $adm_msg")->fetchColumn();
            $limit = 2;
            $total_page = ceil($count_msg / $per_page);
            $total_page++; //увеличиваем число страниц на единицу чтобы начальное значение было равно единице, а не нулю.
            if($page_num > $total_page){ //Если значение $page_num большем чем страниц, то выводим последнюю страницу
              $page_num = $total_page - 1;
            }
            if(!isset($list)) $list = 0; //Указываем начало вывода данных
            $list = --$page_num * $per_page;
            $sql_msg = $pdo->prepare("SELECT * FROM feedback WHERE id>0 AND $adm_msg LIMIT $per_page OFFSET $list");
            $sql_msg->execute();
            $rows = $sql_msg->fetch(PDO::FETCH_LAZY);
            if(isset($rows['id']) !== false){
              echo PHP_EOL ?>
            <div class="box-small">
              <?php $i = 0;
              $sql_msg->execute();
              while($item_msg = $sql_msg->fetch(PDO::FETCH_LAZY)){
                ++$i;
                if(($i % 2) == 1) echo '<div class="d-row">'."\t";
                echo '<div class="d-cell">';
                $text = str_replace(PHP_EOL, '<br>', $item_msg['text']);
                if($item_msg['adm_msg'] == 1) $msg_from = 'Администрация';
                elseif($item_msg['adm_msg'] == 2) $msg_from = 'Менеджеры';
                echo PHP_EOL ?>
                <div class="messages">
                  <div class="flex-box">
                    <div>Сообщение &#8470;</div>
                    <div class="box-small"></div><?=$item_msg['id'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Адресат</div>
                    <div class="box-small"></div><?=$msg_from.PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>ФИО</div>
                    <div class="box-small"></div><?=$item_msg['fio'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>E-mail</div>
                    <div class="box-small"></div><?=$item_msg['email'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Телефон</div>
                    <div class="box-small"></div><?=$item_msg['phone'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Сообщение</div>
                    <div class="box-small"></div><?=$text.PHP_EOL?>
                  </div>
                  <form method="POST" action="<?=PROJECT_URL?>/system/controllers/posts/delete.php">
                    <input hidden name="id" value="<?=$item_msg['id']?>">
                    <input hidden name="table_id" value="7">
                    <button class="admin-button" style="width: 150px">Удалить</button>
                  </form>
                  <div class="box-small"></div>
                </div>
                <?php echo (!($i % 2) || $i == $count_msg) ? '</div> </div>' : '</div>';
              } echo PHP_EOL ?>
            </div>
            <div class="page-num flex-box flex-wrap box">
              <?php if($page_num >= 1){ echo PHP_EOL ?>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/messages.php?<?=$adm?>page_num=1"> <<</a>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/messages.php?<?=$adm?>page_num=<?=$page_num?>"> <</a>
              <?php } //Пагинация на странице истории заказов пользователя
              $start = $page_num + 1 - $limit;
              $end = $page_num + 1 + $limit;
              for($i = 1; $i < $total_page; $i++){
                if($i >= $start && $i <= $end){
                  if($i == $page_num + 1){ echo PHP_EOL ?>
              <a class="pagination-active" href="<?=PROJECT_URL?>/admin/messages.php?<?=$adm?>page_num=<?=$i?>"><?=$i?></a>
                  <?php }else{ echo PHP_EOL ?>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/messages.php?<?=$adm?>page_num=<?=$i?>"><?=$i?></a>
                  <?php } ?>
                <?php }
              }
              if($i > $page_num && ($page_num + 2) < $i){ echo PHP_EOL ?>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/messages.php?<?=$adm?>page_num=<?=($page_num + 2)?>"> > </a>
              <a class="pagination" href="<?=PROJECT_URL?>/admin/messages.php?<?=$adm?>page_num=<?=($i - 1)?>"> >> </a>
              <?php } echo PHP_EOL ?>
            </div>
            <?php }else{ echo PHP_EOL ?>
            <div class="box">
              Сообщений нет
            </div>
            <?php } echo PHP_EOL ?>
          <div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
