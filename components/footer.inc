        <footer class="box-small">
          <div class="footer box-small">
            <div class="line mobile">
              <?php $count_f = $pdo->query('SELECT COUNT(*) FROM core_goods WHERE id>0 AND category=1')->fetchColumn();
              $count_m = $pdo->query('SELECT COUNT(*) FROM core_goods WHERE id>0 AND category=2')->fetchColumn();
              $count_ch = $pdo->query('SELECT COUNT(*) FROM core_goods WHERE id>0 AND category=3')->fetchColumn();
              $count_n = $pdo->query('SELECT COUNT(*) FROM core_goods WHERE id>0')->fetchColumn(); ?>

            </div>
            <div class="footer-category">
              <p>Коллекции</p>
              <ul>
                <li>
                  <a href="<?=PROJECT_URL?>/catalog.php?category=1&page_num=1">Женщинам (<?=$count_f?>)</a>
                </li>
                <li>
                  <a href="<?=PROJECT_URL?>/catalog.php?category=2&page_num=1">Мужчинам (<?=$count_m?>)</a>
                </li>
                <li>
                  <a href="<?=PROJECT_URL?>/catalog.php?category=3&page_num=1">Детям (<?=$count_ch?>)</a>
                </li>
                <li>
                  <a href="<?=PROJECT_URL?>/catalog.php?page_num=1">Новинки (<?=$count_n?>)</a>
                </li>
              </ul>
            </div>
            <div class="line"></div>
            <div class="footer-shop">
              <p>Магазин</p>
              <ul>
                <li>
                  <a href="<?=PROJECT_URL?>/about.php">О нас</a>
                </li>
                <li>
                  <a href="<?=PROJECT_URL?>/transportation.php">Доставка</a>
                </li>
                <li>
                  <a href="<?=PROJECT_URL?>/vacancies.php">Работай с нами</a>
                </li>
                <li>
                  <a href="<?=PROJECT_URL?>/contacts.php">Контакты</a>
                </li>
              </ul>
            </div>
            <div class="line"></div>
            <div class="sots-seti">
              <p>Мы в социальных сетях</p>
              Сайт разработан в inordic.ru<br>2018 © Все права защищены
              <div class="space-small"></div>
              <?php $sn = new Social_networks(1);
              ?><div class="flex-box">
                <?php foreach($sn->getAllUnits() as $item){
                  ?><a href="<?=$item['link']?>" rel="noopener noreferrer" target="_blank">
                  <img src="<?=PROJECT_URL.$item['icon']?>" alt="" /></a>
                  <div class="box-small"></div>
                <?php } echo PHP_EOL; ?>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="<?=PROJECT_URL?>/js/script.js"></script>
  </body>
</html>
