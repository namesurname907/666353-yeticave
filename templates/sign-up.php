  <nav class="nav">
    <ul class="nav__list container">
    <?php foreach ($categories as $category): ?>
      <li class="nav__item">
        <a href="all-lots.html"><?=$category['name']; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <form class="form container <?=isset($errors) ? 'form--invalid' : '';?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item  <?=isset($errors['email']) ? $error_class : '';?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=esc($email); ?>">
      <span class="form__error"><?=isset($errors['email']) ? $errors['email'] : '';?></span>
    </div>
    <div class="form__item  <?=isset($errors['password']) ? $error_class : '';?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?=esc($password); ?>">
      <span class="form__error"><?=isset($errors['password']) ? $errors['password'] : '';?></span>
    </div>
    <div class="form__item  <?=isset($errors['name']) ? $error_class : '';?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=esc($name); ?>">
      <span class="form__error"><?=isset($errors['name']) ? $errors['name'] : '';?></span>
    </div>
   <div class="form__item <?=isset($errors['message']) ? $error_class : '';?>">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" ><?=esc($message); ?></textarea>
      <span class="form__error"><span class="form__error"><?=isset($errors['message']) ? $errors['message'] : '';?></span></span>
    </div>
    <div class="form__item form__item--file form__item--last">
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>
      <div class="form__input-file  <?=isset($errors['file']) ? $error_class : '';?>">
        <input class="visually-hidden" name = 'avatar' type="file" id="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      <span class="form__error"><?=isset($errors['file']) ? $errors['file'] : '';?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
  </form>
