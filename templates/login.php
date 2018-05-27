  <nav class="nav">
    <ul class="nav__list container">
    <?php foreach ($categories as $category): ?>
      <li class="nav__item">
        <a href="all-lots.html"><?=$category['name']; ?></a>
      </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <form class="form container" action="login.php" method="post" <?=isset($errors) ? 'form--invalid' : '';?>> <!-- form--invalid -->
    <h2>Вход</h2>
    <div class="form__item <?=isset($errors['email']) ? $error_class: '';?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=esc($email); ?>">
      <span class="form__error"><?=isset($errors['email']) ? $errors['email'] : '';?></span>
    </div>
    <div class="form__item form__item--last <?=isset($errors['password']) ? $error_class : ''; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="text" name="password" placeholder="Введите пароль">
      <span class="form__error"><?=isset($errors['password']) ? $errors['password'] : '';?></span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>
</main>
