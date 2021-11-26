<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
  require_once PROJECT_ROOT . '/components/header.inc.php';
?>
        <main class="box-small">
          <div class="line"></div>
          <div class="title-block">
            <div class="space-min"></div>
            <div class="title-main big-font">
              Новые поступления весны
            </div>
            <div class="new-font title-mess">
              Мы подготовили для Вас лучшие новинки сезона
            </div>
            <a href="<?=PROJECT_URL;?>/catalog.php?page_num=1" class="title-button big-font">
              Посмотреть новинки
            </a>
          </div>
          <div class="photo-block flex-box">
            <div class="photo">
              <div class="photo-box bg-fix flex-box photo-block-mess box size-font"
                style="background-image: url(<?=PROJECT_URL;?>/img/1.jpg); height: 600px;">
                <div class="big-font">Джинсовые<br>куртки</div>
                <div class="new-font big-font">New Arrival</div>
              </div>
              <div class="photo-box bg-fix" style="background-image: url(<?=PROJECT_URL;?>/img/5.jpg);">

              </div>
            </div>
            <div class="photo">
              <div class="photo-box flex-box photo-block-mess box">
                <div>
                  &mdash;&nbsp;&nbsp;&nbsp;<img src="<?=PROJECT_URL;?>/img/icons/attention-sign-outline.png"
                    alt="!" />&nbsp;&nbsp;&nbsp;&mdash;
                </div>
                <div class="new-font photo-mess">
                  Каждый сезон мы подготавливаем для Вас исключительно лучшую модную одежду.
                  Следите за нашими новинками.
                </div>
              </div>
              <div class="photo-box bg-fix flex-box photo-block-mess box size-font"
                style="background-image: url(<?=PROJECT_URL;?>/img/2.jpg);">
                <div class="big-font">Джинсы</div>
                <div class="new-font">от 3200 руб.</div>
              </div>
              <div class="photo-box flex-box photo-block-mess box size-font">
                <div>
                  <img src="<?=PROJECT_URL;?>/img/icons/arrow.png" alt="стрелка">
                </div>
                <div class="big-font photo-mess">Аксессуары</div>
              </div>
            </div>
            <div class="photo">
              <div class="photo-box bg-fix" style="background-image: url(<?=PROJECT_URL;?>/img/3.jpg);">

              </div>
              <div class="photo-box flex-box photo-block-mess box">
                <div>&mdash;&nbsp;&nbsp;&nbsp;<img src="<?=PROJECT_URL;?>/img/icons/attention-sign-outline.png"
                  alt="!" />&nbsp;&nbsp;&nbsp;&mdash;
                </div>
                <div class="new-font photo-mess">
                  Самые низкие цены в<br>Москве.<br>Нашли дешевле? Вернём<br>разницу.
                </div>
              </div>
              <div class="photo-box bg-fix flex-box photo-block-mess box size-font"
                style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url(<?=PROJECT_URL;?>/img/6.jpg);">
                <div class="big-font">Спортивная<br>одежда</div>
                <div class="new-font">от 590 руб.</div>
              </div>
            </div>
            <div class="photo">
              <div class="photo-box flex-box photo-block-mess box size-font">
                <div>
                  <img src="<?=PROJECT_URL;?>/img/icons/arrow.png" alt="Стрелка" />
                </div>
                <div class="big-font photo-mess">Элегантная<br>обувь</div>
                <div class="new-font big-font">ботинки, кроссовки</div>
              </div>
              <div class="photo-box bg-fix flex-box photo-block-mess box size-font"
                style="background-image: url(<?=PROJECT_URL;?>/img/4.jpg); height: 600px;">
                <div class="big-font">Детская<br>одежда</div>
                <div class="new-font big-font">New Arrival</div>
              </div>
            </div>
          </div>
          <div class="scribe-block">
            <div class="space"></div>
            <div class="title big-font">
              Будь всегда в курсе выгодных предложений
            </div>
            <div class="new-font size-font title-mess">
              Подписывайся и следи за новинками и выгодными предложениями.
            </div>
            <form name="scribe" method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/create.php">
              <input hidden name="table_id" value="6">
              <input class="input" type="email" name="email" placeholder="e-mail">
              <button class="scribe">Подписаться</button>
            </form>
          </div>
          <div class="space"></div>
        </main>
<?php
  require_once PROJECT_ROOT . '/components/footer.inc.php';
?>
