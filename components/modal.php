<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/global_pass.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/project/project3/components/menu_adm.inc.php';
if (empty($_GET['id']) && empty($_GET['user']) && empty($_GET['product'])) {
  header('Location: ' . PROJECT_URL);
} elseif (!empty($_GET['id']) && ctype_digit($_GET['id']) && empty($_GET['product']) && empty($_GET['user'])) {
  $item_modal = new Goods((int) $_GET['id']);?>
  <div class="modal-close">
    +
  </div>
  <div class="detail">
    <div class="detail-photo flex-box">
      <img class="detail-photo-img" src="<?=PROJECT_URL . $item_modal->getField('photo');?>"
        alt="<?=$item_modal->getField('title');?>" />
    </div>
    <div class="box"></div>
    <div class="detail-title big-font">
      <b><?=$item_modal->getField('title');?></b>
    </div>
    <div class="detail-article">Артикул: <?=$item_modal->getField('article');?></div>
    <div class="box new-font size-font"><?=$item_modal->getField('price');?> руб.</div>
    <div class="description box-small"> <?=$item_modal->getField('description');?></div>
    <div class="big-font box">Размер</div>
    <div class="detail-size flex-box">
      <div class="detail-size-item">38</div>
      <div class="box-small"></div>
      <div class="detail-size-item">39</div>
      <div class="box-small"></div>
      <div class="detail-size-item">40</div>
      <div class="box-small"></div>
      <div class="detail-size-item">41</div>
      <div class="box-small"></div>
      <div class="detail-size-item">42</div>
    </div>
  </div>
<?php
} elseif (!empty($_GET['id']) && ctype_digit($_GET['id']) && !empty($_GET['product']) && $_GET['product'] === 'edit') {
  if (in_array($user_id, $manager) || in_array($user_id, $root)) {
    $item_modal = new Goods((int) $_GET['id']);?>
    <div class="modal-close">
      +
    </div>
    <div class="box-small">
      <form id="edit" method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/update.php"
        enctype="multipart/form-data">
        <label><input hidden name="table_id" value="1" />
          <input hidden name="id" value="<?=$item_modal->getField('id');?>" />
          Фото<input type="file" name="photo" accept="image/png, image/jpeg" autocomplete="off" />
        </label>
        <label>Наименование
          <input type="text" name="title" value="<?=$item_modal->getField('title');?>" autocomplete="off" required />
        </label>
        <label>Артикул
          <input type="text" name="article" value="<?=$item_modal->getField('article');?>" autocomplete="off"
            required />
        </label>
        <label>Цена (руб.)
          <input type="text" name="price" value="<?=$item_modal->getField('price');?>" autocomplete="off" required />
        </label>
        <label>Описание
          <textarea name="description" required><?=$item_modal->getField('description');?></textarea>
        </label>
        <div class="box-small">
          <?php $category = $item_modal->getField('category');?>
          <div class="category">
            <label>
              <input type="radio" name="category" value="1" <?=($category == 1) ? ' checked' : '';?> />Женщинам
            </label>
            <label>
              <input type="radio" name="category" value="2" <?=($category == 2) ? ' checked' : '';?> />Мужчинам
            </label>
            <label>
              <input type="radio" name="category" value="3" <?=($category == 3) ? ' checked' : '';?> />Детям
            </label>
          </div>
        </div>
        <div class="box-small">
          <?php $categories = $item_modal->getField('categories');?>
          <div class="categories">
            <label><input type="radio" name="categories" value="1"
                <?=($categories == 1) ? ' checked' : '';?> />Куртки</label>
            <label><input type="radio" name="categories" value="2"
                <?=($categories == 2) ? ' checked' : '';?> />Джинсы</label>
            <label>
              <input type="radio" name="categories" value="3" <?=($categories == 3) ? ' checked' : '';?> />Обувь
            </label>
            <label>
              <input type="radio" name="categories" value="4" <?=($categories == 4) ? ' checked' : '';?> />Аксессуары
            </label>
          </div>
        </div>
        <label>Размер
          <input type="text" name="sized" value="<?=$item_modal->getField('sized');?>" autocomplete="off" required />
        </label>
        <div class="box-small"></div>
        <button class="admin-button">Сохранить</button>
      </form>
    </div>
<?php } else {
    echo 'Неправильная ссылка или модальное окно открыто из браузера';
  }
} elseif (empty($_GET['id']) && $_GET['product'] === 'new') {
  if (in_array($user_id, $manager) || in_array($user_id, $root)) {?>
    <div class="modal-close">
      +
    </div>
    <div class="box-small">
      <form id="edit" method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/create.php"
        enctype="multipart/form-data">
        <label><input hidden name="table_id" value="1">
          Фото<input type="file" name="photo" accept="image/png,image/jpeg" autocomplete="off" required />
        </label>
        <label>Наименование<input type="text" name="title" value="" autocomplete="off" required /></label>
        <label>Артикул<input type="text" name="article" value="" autocomplete="off" required /></label>
        <label>Цена (руб.)<input type="text" name="price" value="" autocomplete="off" required /></label>
        <label>Описание<textarea name="description" required></textarea></label>
        <div class="box-small category">
          <label><input type="radio" name="category" value="1" required />Женщинам</label>
          <label><input type="radio" name="category" value="2" />Мужчинам</label>
          <label><input type="radio" name="category" value="3" />Детям</label>
        </div>
        <div class="box-small categories">
          <label><input type="radio" name="categories" value="1" required />Куртки</label>
          <label><input type="radio" name="categories" value="2" />Джинсы</label>
          <label><input type="radio" name="categories" value="3" />Обувь</label>
          <label><input type="radio" name="categories" value="4" />Аксессуары</label>
        </div>
        <label>Размер<input type="text" name="sized" value="" autocomplete="off" required /></label>
        <div class="box-small"></div>
        <button class="admin-button">Сохранить</button>
      </form>
    </div>
<?php } else {
    echo 'Неправильная ссылка или модальное окно открыто из браузера';
  }
} elseif (!empty($_GET['id']) && ctype_digit($_GET['id']) && !empty($_GET['user']) && $_GET['user'] === 'edit') {
  if (!in_array($user_id, $manager) && in_array($user_id, $root)) {
    $item_modal_user = new Member((int) $_GET['id']);?>
      <div class="modal-close">
        +
      </div>
      <div class="box-small">
        <div>При изменении пароля активного админа будет необходимо повторно авторизоваться</div>
        <div class="box-small"></div>
        <form name="users" method="POST" action="<?=PROJECT_URL;?>/system/controllers/posts/update.php">
          <label><input hidden name="table_id" value="5">
            <input hidden name="id" value="<?=$item_modal_user->getField('id');?>">
            Логин<input type="text" name="login" value="<?=$item_modal_user->getField('login');?>" autocomplete="off"
              required />
          </label>
          <label>Имя<input type="text" name="username" value="<?=$item_modal_user->getField('username');?>"
            autocomplete="off" required /></label>
          <div class="box-small">
            <?php $admin = $item_modal_user->getField('adm');?>
            <div class="adm">
              <label>
                <input type="radio" name="adm" value="1" <?=($admin == 1) ? ' checked' : '';?> />Администратор
              </label>
              <label>
                <input type="radio" name="adm" value="2" <?=($admin == 2) ? ' checked' : '';?> />Менеджер
              </label>
              <label>
                <input type="radio" name="adm" value="3" <?=($admin == 3) ? ' checked' : '';?> />Пользователь
              </label>
            </div>
          </div>
          <label>E-mail
            <input type="email" name="email" value="<?=$item_modal_user->getField('email');?>" autocomplete="off"
              required />
          </label>
          <div class="pass">Пароль:&nbsp;
            <input id="pass-input" type="password" name="password" autocomplete="off" />
            <label for="pass-input" class="pass-control"></label>
          </div>
          <div class="box-small"></div>
          <button class="admin-button">Сохранить</button>
        </form>
      </div>
<?php } else {
    echo 'Неправильная ссылка или модальное окно открыто из браузера';
  }
} else {
  echo 'Неправильная ссылка или модальное окно открыто из браузера';
}
