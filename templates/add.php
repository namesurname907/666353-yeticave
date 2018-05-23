<nav class="nav">
    <ul class="nav__list container">
    <?php foreach ($categories as $category): ?>
      <li class="nav__item">
        <a href="all-lots.html"><?=$category['name']; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <form class="form form--add-lot container <?=insertIfIsset($errors, 'form--invalid');?> action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?=insertIfIsset($errors['lot-name'], $error_class);?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$name; ?>">
        <span class="form__error"><?=insertIfIsset($errors['lot-name'], $errors['lot-name']);?></span>
      </div>
      <div class="form__item <?=insertIfIsset($errors['category'], $error_class);?>">
        <label for="category">Категория</label>
        <select id="category" name="category" value="<?=$category; ?>">
          <option value="">Выберите категорию</option>
          <option value="1" <?=insertIfIsset($cat[1]);?>>Доски и лыжи</option>
          <option value="2" <?=insertIfIsset($cat[2]);?>>Крепления</option>
          <option value="3" <?=insertIfIsset($cat[3]);?>>Ботинки</option>
          <option value="4" <?=insertIfIsset($cat[4]);?>>Одежда</option>
          <option value="5" <?=insertIfIsset($cat[5]);?>>Инструменты</option>
          <option value="6" <?=insertIfIsset($cat[6]);?>>Разное</option>
        </select>
        <span class="form__error"><?=insertIfIsset($errors['category'], $errors['category']); ?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=insertIfIsset($errors['message'], $error_class);?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" ><?=$message; ?></textarea>
      <span class="form__error"><span class="form__error"><?=insertIfIsset($errors['message'], $errors['message']); ?></span></span>
    </div>
    <div class="form__item form__item--file <?=insertIfIsset($errors['file'], $error_class);?>"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name ="lot-img" value="">
        <label for="photo2">
          <span class="">+ Добавить</span>
        </label>
        <span class="form__error"><?=insertIfIsset($errors['file'], $errors['file']); ?></span>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=insertIfIsset($errors['lot-rate'], $error_class);?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=esc($lot_rate); ?>">
        <span class="form__error"><span class="form__error"><?=insertIfIsset($errors['lot-rate'], $errors['lot-rate']); ?></span></span>
      </div>
      <div class="form__item form__item--small <?=insertIfIsset($errors['lot-step'], $error_class);?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=esc($lot_step); ?>">
        <span class="form__error"><?=insertIfIsset($errors['lot-step'], $errors['lot-step']); ?></span>
      </div>
      <div class="form__item <?=insertIfIsset($errors['lot-date'], $error_class);?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=esc($lot_date); ?>">
        <span class="form__error"><?=insertIfIsset($errors['lot-date'], $errors['lot-date']); ?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
