<nav class="nav">
<ul class="nav__list container">
<?php foreach ($categories as $category): ?>
  <li class="nav__item">
    <a href="all-lots.html"><?=$category['name']; ?></a>
  </li>
  <?php endforeach; ?>
</ul>
</nav>
<section class="lot-item container">
<h2><?=$lot['name']; ?></h2>
<div class="lot-item__content">
  <div class="lot-item__left">
    <div class="lot-item__image">
      <img src="<?=$lot['image']; ?>" width="730" height="548" alt="Сноуборд">
    </div>
    <p class="lot-item__category">Категория: <span><?=$categories[$lot['category_id']-1]['name']; ?></span></p>
    <p class="lot-item__description"><?=$lot['description']; ?></p>
  </div>
  <div class="lot-item__right">
    <div class="lot-item__state">
      <div class="lot-item__timer timer">
        <?=timeToEnd($lot['date_end']);?>
      </div>
      <div class="lot-item__cost-state">
        <div class="lot-item__rate">
          <span class="lot-item__amount"><?=price_format($lot['price_start']); ?></span>
          <span class="lot-item__cost"><?=price_format($yourBet - $lot['step_bet']); ?></span>
        </div>
        <div class="lot-item__min-cost">
          Мин. ставка <span><?=price_format($lot['step_bet']); ?></span>
        </div>
      </div>
      <?php if ((isset($_SESSION['user'])) && ($log_user_id !== $lot_user_id) && ($max_bet_user_id !== $log_user_id)): ?>
      <form class="lot-item__form" action="lot.php" method="post">
        <p class="lot-item__form-item">
          <label for="cost">Ваша ставка</label>
          <input <?=isset($error_bet) ? "style='border: 1px solid red;'" : '';?> id="cost" type="number" name="cost" placeholder="<?=price_format($yourBet); ?>">
        </p>
        <button type="submit" class="button">Сделать ставку</button>
      </form>
        <span style="font-size: 15px; color: red;"><?=isset($error_bet) ? $error_bet : ''; ?></span>
      <?php endif; ?>
    </div>
    <div class="history">
    <h3>История ставок (<span><?=count($bets);?></span>)</h3>
      <table class="history__list">
            <?php foreach($bets as $bet): ?>
            <tr class="history__item">
              <td class="history__name"><?=$bet['user_name']; ?></td>
              <td class="history__price"><?=price_format($bet['price']); ?></td>
              <td class="history__time"><?=$bet['date_start']; ?></td>
            </tr>
            <?php endforeach; ?>
      </table>
    </div>
  </div>
</div>
</section>
