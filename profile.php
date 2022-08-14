<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  require_once PROJECT_ROOT . '/components/header.inc.php';
  if (empty($_COOKIE['member_id'])) {
    header('Location: ' . PROJECT_URL . '/auth/login.php');
  }
  require_once PROJECT_ROOT . '/components/menu_adm.inc.php';
?>
        <main class="box-small">
          <div class="line"></div>
          <?php if (empty($_GET['history'])) {?>
          <div class="profile">
            <?=$menu;?>
            <div class="line"></div>
            <div class="box-small">При изменении пароля будет необходимо повторно авторизоваться.</div>
            <div class="box-small">
              <?php $item_profile = new Member((int) $user_id);?>
              <div class="member">Логин: <?=$item_profile->getField('login');?></div>
              <form name="profile" method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/update.php">
                <label class="member">
                  <input hidden name="table_id" value="5" />
                  <input hidden name="id" value="<?=$item_profile->getField('id');?>" />
                  Имя:&nbsp;<input type="text" name="username" value="<?=$item_profile->getField('username');?>"
                    autocomplete="off" required />
                </label>
                <label class="member">E-mail:&nbsp;
                  <input type="email" name="email" value="<?=$item_profile->getField('email');?>"
                    autocomplete="off" required />
                </label>
                <div class="member pass">Пароль:&nbsp;
                  <input id="pass-input" type="password" name="password" autocomplete="off" />
                  <label for="pass-input" class="pass-control"></label>
                </div>
                <button class="user">Сохранить</button>
              </form>
            </div>
          </div>
          <!-- /.profile -->
          <?php } elseif (isset($_GET['history'])) {?>
          <div class="profile">
            <?=$menu;?>
            <div class="line"></div>
            <div class="box-small"></div>
            <?php $count = $pdo->query("SELECT COUNT(*) FROM orders WHERE member_id=$user_id")->fetchColumn();
            require_once PROJECT_ROOT . '/components/pagination.inc.php';
            $sql = $pdo->prepare("SELECT * FROM orders WHERE member_id=$user_id LIMIT $per_page OFFSET $list");
            $sql->execute();
            $items = $sql->fetchAll();
            if (empty($items)) {
              echo '<div class="box-small">У Вас нет заказов.</div>';
            }?>
            <div class="flex-box flex-wrap">
            <?php foreach ($items as $item_profile) {
              if ($item_profile['member_id'] == $user_id) {
                $product_name_profile = str_replace('","', ', ', trim($item_profile['product_name'], '["]'));
                $art_profile = str_replace('","', ', ', trim($item_profile['article'], '["]'));
                $size_profile = str_replace('","', ', ', trim($item_profile['sized'], '["]'));
                $quantity_profile = str_replace('","', ', ', trim($item_profile['quantity'], '["]'));
                if ($item_profile['delivery'] == 500) {
                  $delivery_profile = 'Курьерская служба - ' . $item_profile['delivery'];
                } elseif ($item_profile['delivery'] == 250) {
                  $delivery_profile = 'Пункт самовывоза - ' . $item_profile['delivery'];
                } elseif ($item_profile['delivery'] == 1000) {
                  $delivery_profile = 'Почта России - ' . $item_profile['delivery'];
                }
              ?>
              <div class="order-box">
                <div class="flex-box">
                  <div class="field">Товар</div>
                  <div><?=$product_name_profile;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Артикул</div>
                  <div><?=$art_profile;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Размер</div>
                  <div><?=$size_profile;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Количество</div>
                  <div><?=$quantity_profile;?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Сумма</div>
                  <div><?=$item_profile['amount'];?> руб.</div>
                </div>
                <div class="flex-box">
                  <div class="field">Доставка</div>
                  <div><?=$delivery_profile;?> руб.</div>
                </div>
                <div class="flex-box">
                  <div class="field">Имя</div>
                  <div><?=$item_profile['first_name'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Фамилия</div>
                  <div><?=$item_profile['last_name'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Адрес</div>
                  <div><?=$item_profile['address'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Город</div>
                  <div><?=$item_profile['city'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Индекс</div>
                  <div><?=$item_profile['postcode'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Телефон</div>
                  <div><?=$item_profile['phone'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">E-mail</div>
                  <div><?=$item_profile['email'];?></div>
                </div>
                <div class="flex-box">
                  <div class="field">Итог</div>
                  <div><?=$item_profile['total'];?> руб.</div>
                </div>
                <div class="flex-box">
                  <div class="field">Оплата</div>
                  <div><?=$item_profile['payment'];?></div>
                </div>
              </div>
              <!-- /.order-box -->
              <?php } #endif-id
              } #endforeach?>
            </div>
            <!-- /.profile -->
          <div class="page-num flex-box flex-wrap box">
            <?php paginationArrow($filename, $total_page, $page_num, $per_page, 'history=1&');?>
          </div>
          <!-- /.page-num -->
          <?php } #endif-history?>
          <div class="box-small"></div>
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
