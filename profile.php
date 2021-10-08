<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/project/project3/global_pass.php';
require_once PROJECT_ROOT.'/components/header.inc';
if(isset($_COOKIE['member_id']) === false){
  header('Location: '.PROJECT_URL.'/auth/login.php');
}else{
  require_once PROJECT_ROOT.'/components/menu_adm.inc'; ?>
        <main class="box-small">
          <div class="line"></div>
        <?php if(isset($_GET['history']) == null){
          echo PHP_EOL ?>
          <div class="profile">
            <?=$menu?>
            <div class="line"></div>
            <div class="box-small">При изменении пароля будет необходимо повторно авторизоваться.</div>
            <div class="box-small">
              <?php $item_profile = new Member((int)$user_id)
              ?><div class="member">Логин: <?=$item_profile->getField('login')?></div>
              <form name="profile" method="POST" action="<?=PROJECT_URL?>/system/controllers/posts/update.php">
                <label class="member">
                  <input hidden name="table_id" value="5">
                  <input hidden name="id" value="<?=$item_profile->getField('id')?>">
                  Имя:&nbsp;<input type="text" name="username" value="<?=$item_profile->getField('username')?>" autocomplete="off" required>
                </label>
                <label class="member">E-mail:&nbsp;
                  <input type="email" name="email" value="<?=$item_profile->getField('email')?>" autocomplete="off" required>
                </label>
                <div class="member pass">Пароль:&nbsp;
                  <input id="pass-input" type="password" name="password" autocomplete="off">
                  <label for="pass-input" class="pass-control"></label>
                </div>
                <button class="user">Сохранить</button>
              </form>
            </div>
          </div>
        <?php }elseif($_GET['history'] == 1){ echo PHP_EOL ?>
          <div class="profile">
            <?=$menu?>
            <div class="line"></div>
            <?php $count_profile = $pdo->query("SELECT COUNT(*) FROM orders WHERE member_id=$user_id")->fetchColumn();
            $limit = $per_page;
            $total_page = ceil($count_profile / $per_page);
            $total_page++; //увеличиваем число страниц на единицу чтобы начальное значение было равно единице, а не нулю.
            if($page_num > $total_page){ //Если значение $page_num большем чем страниц, то выводим последнюю страницу
              $page_num = $total_page - 1;
            }
            if(!isset($list)) $list = 0; //Указываем начало вывода данных
            $list = --$page_num * $per_page;
            $sql = $pdo->prepare("SELECT * FROM orders WHERE member_id=$user_id LIMIT $per_page OFFSET $list");
            $sql->execute();
            $rows = $sql->fetch(PDO::FETCH_LAZY);
            if(isset($rows['member_id']) == $user_id){
              echo PHP_EOL ?>
              <div class="box-small"></div>
              <div class="box-small">
                <?php $sql->execute();
                $i = 0;
                while($item_profile = $sql->fetch(PDO::FETCH_LAZY)){
                  ++$i;
                  if(($i % 2) == 1) echo '<div class="d-row">'."\t";
                  echo '<div class="d-cell">';
                  $product_name_profile = str_replace('","', ', ', trim($item_profile['product_name'], '["]'));
                  $art_profile = str_replace('","', ', ', trim($item_profile['article'], '["]'));
                  $size_profile = str_replace('","', ', ', trim($item_profile['sized'], '["]'));
                  $quantity_profile = str_replace('","', ', ', trim($item_profile['quantity'], '["]'));
                  if($item_profile['delivery'] == 500){
                    $delivery_profile = 'Курьерская служба - '.$item_profile['delivery'];
                  }elseif($item_profile['delivery'] == 250){
                    $delivery_profile = 'Пункт самовывоза - '.$item_profile['delivery'];
                  }elseif($item_profile['delivery'] == 1000){
                    $delivery_profile = 'Почта России - '.$item_profile['delivery'];
                  } echo PHP_EOL ?>
                  <div class="orders">
                    <div class="flex-box">
                      <div>Товар</div>
                      <div class="box-small"></div><?=$product_name_profile.PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Артикул</div>
                      <div class="box-small"></div><?=$art_profile.PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Размер</div>
                      <div class="box-small"></div><?=$size_profile.PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Количество</div>
                      <div class="box-small"></div><?=$quantity_profile.PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Сумма</div>
                      <div class="box-small"></div><?=$item_profile['amount']?> руб.
                    </div>
                    <div class="flex-box">
                      <div>Доставка</div>
                      <div class="box-small"></div><?=$delivery_profile?> руб.
                    </div>
                    <div class="flex-box">
                      <div>Имя</div>
                      <div class="box-small"></div><?=$item_profile['first_name'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Фамилия</div>
                      <div class="box-small"></div><?=$item_profile['last_name'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Адрес</div>
                      <div class="box-small"></div><?=$item_profile['address'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Город</div>
                      <div class="box-small"></div><?=$item_profile['city'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Индекс</div>
                      <div class="box-small"></div><?=$item_profile['postcode'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Телефон</div>
                      <div class="box-small"></div><?=$item_profile['phone'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>E-mail</div>
                      <div class="box-small"></div><?=$item_profile['email'].PHP_EOL?>
                    </div>
                    <div class="flex-box">
                      <div>Итог</div>
                      <div class="box-small"></div><?=$item_profile['total']?> руб.
                    </div>
                    <div class="flex-box">
                      <div>Оплата</div>
                      <div class="box-small"></div><?=$item_profile['payment'].PHP_EOL?>
                    </div>
                    <div class="box-small"></div>
                  </div>
                  <?php echo (!($i % 2) || $i == $count_profile) ? '</div> </div>' : '</div>';
                } echo PHP_EOL ?>
              </div>
              <div class="page-num flex-box flex-wrap box">
                <?php if($page_num >= 1){ echo PHP_EOL ?>
                <a class="pagination" href="<?=PROJECT_URL?>/profile.php?history=1&page_num=1"> << </a>
                <a class="pagination" href="<?=PROJECT_URL?>/profile.php?history=1&page_num=<?=$page_num?>"> < </a>
                <?php } //Пагинация на странице истории заказов пользователя
                $start = $page_num + 1 - $limit;
                $end = $page_num + 1 + $limit;
                for($i = 1; $i < $total_page; $i++){
                  if($i >= $start && $i <= $end){
                    if($i == $page_num + 1){ echo PHP_EOL ?>
                <a class="pagination-active" href="<?=PROJECT_URL?>/profile.php?history=1&page_num=<?=$i?>"><?=$i?></a>
                    <?php }else{
                      echo PHP_EOL ?>
                <a class="pagination" href="<?=PROJECT_URL?>/profile.php?history=1&page_num=<?=$i?>"><?=$i?></a>
                    <?php } ?>
                  <?php }
                }
                if($i > $page_num && ($page_num + 2) < $i){ echo PHP_EOL ?>
                <a class="pagination" href="<?=PROJECT_URL?>/profile.php?history=1&page_num=<?=($page_num + 2)?>"> > </a>
                <a class="pagination" href="<?=PROJECT_URL?>/profile.php?history=1&page_num=<?=($i - 1)?>"> >> </a>
                <?php } echo PHP_EOL ?>
              </div>
            <?php }else{
              ?><div class="box">
                У Вас нет заказов
              </div>
            <?php }
            echo PHP_EOL ?>
          </div>
        <?php }else{ echo PHP_EOL ?>
          <div class="profile">
            <div class="box">
              Вы пришли по не правильной ссылке.
            </div>
          </div>
        <?php } echo PHP_EOL ?>
          <div class="box-small"></div>
        </main>
<?php }
  require_once PROJECT_ROOT.'/components/footer.inc';
?>
