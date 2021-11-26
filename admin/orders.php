<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  require_once PROJECT_ROOT . '/components/header.inc.php';
  require_once PROJECT_ROOT . '/components/check_adm.inc.php';
  if (!isset($_GET['orders'])) {
    header('Location: ' . PROJECT_URL . '/admin/orders.php?orders=act&page_num=1');
  }
  require_once PROJECT_ROOT . '/components/orders_adm.inc.php';
  require_once PROJECT_ROOT . '/components/pagination.inc.php';
  $sql_orders = $pdo->prepare("SELECT * FROM orders WHERE $act $end $all LIMIT $per_page OFFSET $list");
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="profile">
            <?=$menu;?>
            <div class="line"></div>
            <?php
            if (in_array($user_id, $manager)) {
              $orders = '<div class="box-small"></div>'; //Скрываем меню админа для менеджера
            }
            echo $orders; // Меню админа скрытое для менеджера
            $sql_orders->execute();
            $items = $sql_orders->fetchAll();
            if (empty($items)) {
              echo '<div class="box-small">Заказов нет.</div>';
            }?>
            <div class="flex-box flex-wrap">
              <?php foreach ($items as $item) {
                $product_name = str_replace('","', ', ', trim($item['product_name'], '["]'));
                $art = str_replace('","', ', ', trim($item['article'], '["]'));
                $quantity = str_replace('","', ', ', trim($item['quantity'], '["]'));
                if ($item['delivery'] == 500) {
                  $delivery = 'Курьерская служба - ' . $item['delivery'];
                } elseif ($item['delivery'] == 250) {
                  $delivery = 'Пункт самовывоза - ' . $item['delivery'];
                } elseif ($item['delivery'] == 1000) {
                  $delivery = 'Почта России - ' . $item['delivery'];
                }
              ?>
              <div class="order-box">
                <div class="flex-box">
                  <div class="field">Заказ &numero;</div>
                  <div><?=$item['id'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Товар</div>
                  <div><?=$product_name;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Артикул</div>
                  <div><?=$art;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Размер</div>
                  <div><?=$item['sized'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Количество</div>
                  <div><?=$quantity;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Сумма</div>
                  <div><?=$item['amount'];?> руб.</div>
                </div>
                <div class="flex-box">
                  <div class="field">Доставка</div>
                  <div><?=$delivery;?> руб.</div>
                </div>
                <div class="flex-box">
                  <div class="field">Имя</div>
                  <div><?=$item['first_name'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Фамилия</div>
                  <div><?=$item['last_name'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Адрес</div>
                  <div><?=$item['address'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Город</div>
                  <div><?=$item['city'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Индекс</div>
                  <div><?=$item['postcode'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Телефон</div>
                  <div><?=$item['phone'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">E-mail</div>
                  <div><?=$item['email'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Итог</div>
                  <div><?=$item['total'];?> руб.</div>
                </div>
                <div class="flex-box">
                  <div class="field">Оплата</div>
                  <div><?=$item['payment'];?></div>
                </div>
                <?php if ($item['status'] !== 'end' && $item['status'] !== 'new') {?>
                <div class="flex-box">
                  <div>Заказ выполняется</div>
                  <div class="box-small"></div>
                  Да
                </div>
                <?php } elseif ($item['status'] === 'end' && in_array($user_id, $root)) {?>
                <div class="flex-box">
                  <div>Заказ выполнен</div>
                  <div class="box-small"></div>
                  Да
                </div>
                <?php }?>
                <?php if ($item['status'] == 'new') {?>
                <form name="order" method="POST" action="<?=PROJECT_URL;?>/system/controllers/orders/work.php">
                  <input hidden name="id" value="<?=$item['id'];?>" />
                  <input hidden name="user_id" value="<?=$user_id;?>" />
                  <input hidden name="username" value="<?=$username;?>" />
                  <button class="admin-button">Выполнить заказ</button>
                </form>
                <?php } elseif ($item['status'] == 'act' . $user_id) {?>
                <form name="order" method="POST" action="<?=PROJECT_URL;?>/system/controllers/orders/update.php">
                  <input hidden name="id" value="<?=$item['id'];?>" />
                  <button class="admin-button">Заказ выполнен</button>
                </form>
                <?php }?>
              </div>
              <?php }?>
            </div>
            <div class="page-num flex-box flex-wrap box">
              <?php pagination('&', $total_page, $page_num);?>
            </div>
          </div>
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
