<?php
/**
 * @var $this \event\widgets\Registration
 * @var $account \pay\models\Account
 */
?>

<form class="registration">
  <h5 class="title">Регистрация</h5>
  <p>
    Для туристов, которые в течение дня совершают большое количество поездок, вводится универсальный билет - смарт-карта на одни сутки. Ее стоимость составит 200 руб., пассажиры смогут совершать неограниченное количество поездок как в метро, так и на наземном городском транспорте.
  </p>
  <div class="clearfix">
    <a target="_blank" href="<?=$account->ReturnUrl;?>" class="btn btn-small btn-info pull-right">Зарегистрироваться</a>
  </div>
</form>