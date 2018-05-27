<nav class="nav">
    <ul class="nav__list container">
    <?php foreach ($categories as $category): ?>
      <li class="nav__item">
        <a href="all-lots.html"><?=$category['name']; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <form class="form form--add-lot container <?=!empty($errors) ? 'form--invalid' : '';?> action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <div class="form__item <?=isset($errors['name']) ? $error_class : '';?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=esc($lot['name']); ?>">
        <span class="form__error"><?=isset($errors['name']) ? $errors['name'] : '';?></span>
      </div>
      <div class="form__item <?=isset($errors['category']) ? $error_class : '';?>">
        <label for="category">Категория</label>
        <select id="category" name="category" value="<?=$lot['category']; ?>">
          <option value="">Выберите категорию</option>
          <option value="1" <?=(1 == $lot['category']) ? 'selected' : '';?>>Доски и лыжи</option>
          <option value="2" <?=(2  ==  $lot['category']) ? 'selected' : '';?>>Крепления</option>
          <option value="3" <?=(3  ==  $lot['category']) ? 'selected' : '';?>>Ботинки</option>
          <option value="4" <?=(4  ==  $lot['category']) ? 'selected' : '';?>>Одежда</option>
          <option value="5" <?=(5  ==  $lot['category']) ? 'selected' : '';?>>Инструменты</option>
          <option value="6" <?=(6  ==  $lot['category']) ? 'selected' : '';?>>Разное</option>
        </select>
        <span class="form__error"><?=isset($errors['category']) ? $errors['category'] : '';?></span>
      </div>
    </div>
    <div class="form__item form__item--wide <?=isset($errors['message']) ? $error_class : '';?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" ><?=esc($lot['message']); ?></textarea>
      <span class="form__error"><span class="form__error"><?=isset($errors['message']) ? $errors['message'] : '';?></span></span>
    </div>
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file  <?=!empty($errors['file']) ? $error_class : '';?>">
        <input class="visually-hidden" type="file" id="photo2" name ="lot-img" value="">
        <label for="photo2">
          <span class="">+ Добавить</span>
        </label>
        <span class="form__error"><?=isset($errors['file']) ? $errors['file'] : '';?></span>
      </div>
    </div>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=isset($errors['rate']) ? $error_class : '';?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=esc($lot['rate']); ?>">
        <span class="form__error"><span class="form__error"><?=isset($errors['rate']) ? $errors['rate'] : '';?></span></span>
      </div>
      <div class="form__item form__item--small <?=isset($errors['step']) ? $error_class : '';?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=esc($lot['step']); ?>">
        <span class="form__error"><?=isset($errors['step']) ? $errors['step'] : '';?></span>
      </div>
      <div class="form__item <?=isset($errors['date']) ? $error_class : '';?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=esc($lot['date']); ?>">
        <span class="form__error"><?=isset($errors['date']) ? $errors['date'] : '';?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
