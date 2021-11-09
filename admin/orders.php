<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
  require_once PROJECT_ROOT.'/components/header.inc.php';
  require_once PROJECT_ROOT.'/components/check_adm.inc.php';
      if(!isset($_GET['orders'])) header('Location: '.PROJECT_URL.'/admin/orders.php?orders=act&page_num=1'); ?>
        <main class="box-small">
          <div class="line"></div>
          <div class="profile">
            <?=$menu?>
            <div class="line"></div>
            <?php require_once PROJECT_ROOT.'/components/orders_adm.inc.php';
            if(in_array($user_id, $manager)) $orders = ''; //Скрываем меню админа для менеджера
            echo $orders; // Меню админа скрытое для менеджера
            $sql_orders->execute();
            $rows = $sql_orders->fetch(PDO::FETCH_LAZY);
            if(isset($rows['id']) !== false){
              echo PHP_EOL ?>
            <div class="box-small">
              <?php $i = 0;
              $sql_orders->execute();
              while($item = $sql_orders->fetch(PDO::FETCH_LAZY)){
                ++$i;
                if(($i % 2) == 1) echo '<div class="d-row">'."\t";
                echo '<div class="d-cell">';
                $product_name = str_replace('","', ', ', trim($item['product_name'], '["]'));
                $art = str_replace('","', ', ', trim($item['article'], '["]'));
                $quantity = str_replace('","', ', ', trim($item['quantity'], '["]'));
                if($item['delivery'] == 500) $delivery = 'Курьерская служба - '.$item['delivery'];
                elseif($item['delivery'] == 250) $delivery = 'Пункт самовывоза - '.$item['delivery'];
                elseif($item['delivery'] == 1000) $delivery = 'Почта России - '.$item['delivery'];
                echo PHP_EOL ?>
                <div class="orders">
                  <div class="flex-box">
                    <div>Заказ &numero;</div>
                    <div class="box-small"></div><?=$item['id'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Товар</div>
                    <div class="box-small"></div><?=$product_name.PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Артикул</div>
                    <div class="box-small"></div><?=$art.PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Размер</div>
                    <div class="box-small"></div><?=$item['sized'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Количество</div>
                    <div class="box-small"></div><?=$quantity.PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Сумма</div>
                    <div class="box-small"></div><?=$item['amount']?> руб.
                  </div>
                  <div class="flex-box">
                    <div>Доставка</div>
                    <div class="box-small"></div><?=$delivery?> руб.
                  </div>
                  <div class="flex-box">
                    <div>Имя</div>
                    <div class="box-small"></div><?=$item['first_name'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Фамилия</div>
                    <div class="box-small"></div><?=$item['last_name'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Адрес</div>
                    <div class="box-small"></div><?=$item['address'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Город</div>
                    <div class="box-small"></div><?=$item['city'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Индекс</div>
                    <div class="box-small"></div><?=$item['postcode'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Телефон</div>
                    <div class="box-small"></div><?=$item['phone'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>E-mail</div>
                    <div class="box-small"></div><?=$item['email'].PHP_EOL?>
                  </div>
                  <div class="flex-box">
                    <div>Итог</div>
                    <div class="box-small"></div><?=$item['total']?> руб.
                  </div>
                  <div class="flex-box">
                    <div>Оплата</div>
                    <div class="box-small"></div><?=$item['payment'].PHP_EOL?>
                  </div>
                  <?php if($item['status'] !== 'end' && $item['status'] !== 'new'){
                    ?>
                    <div class="flex-box">
                      <div>Заказ выполняется</div>
                      <div class="box-small"></div>
                      Да
                    </div>
                  <?php }
                  elseif($item['status'] == 'end' && in_array($user_id, $root)){
                    ?>
                    <div class="flex-box">
                      <div>Заказ выполнен</div>
                      <div class="box-small"></div>
                      Да
                    </div>
                  <?php } ?>
                  <?php if($item['status'] == 'new'){ echo PHP_EOL ?>
                    <form name="order" method="POST" action="<?=PROJECT_URL?>/system/controllers/orders/work.php">
                      <input hidden name="id" value="<?=$item['id']?>">
                      <input hidden name="user_id" value="<?=$user_id?>">
                      <input hidden name="name" value="<?=$username?>">
                      <button class="admin-button">Выполнить заказ</button>
                    </form>
                  <?php }elseif($item['status'] == 'act'.$user_id){
                    echo PHP_EOL ?>
                    <form name="order" method="POST" action="<?=PROJECT_URL?>/system/controllers/orders/update.php">
                      <input hidden name="id" value="<?=$item['id']?>">
                      <button class="admin-button">Заказ выполнен</button>
                    </form>
                  <?php } echo PHP_EOL ?>
                  <div class="box-small"></div>
                </div>
                <?php echo (!($i % 2) || $i == $count) ? '</div> </div>' : '</div>';
              } echo PHP_EOL ?>
            </div>
            <div class="page-num flex-box flex-wrap box">
              <?php for($i = 1; $i <= $total_page; $i++){ //Пагинация на странице заказов
                if($i == $page_num){
                  echo PHP_EOL ?>
              <a class="pagination-active" href="<?=$_SERVER['REQUEST_URI']?>&routed=1&page_num=<?=$i?>"><?=$i?></a>
                <?php }else{
                  echo PHP_EOL ?>
              <a class="pagination" href="<?=$_SERVER['REQUEST_URI']?>&routed=1&page_num=<?=$i?>"><?=$i?></a>
                <?php } ?>
              <?php }
              echo PHP_EOL ?>
            </div>
            <?php }else{ echo PHP_EOL ?>
            <div class="box">
              Заказов нет
            </div>
            <?php } echo PHP_EOL ?>
          </div>
        </main>
<?php
  require_once PROJECT_ROOT.'/components/footer.inc.php';
?>
