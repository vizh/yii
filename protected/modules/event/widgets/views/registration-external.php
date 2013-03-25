<?php
/**
 * @var $this \event\widgets\Registration
 * @var $account \pay\models\Account
 */
?>

<form class="registration">
  <h5 class="title">Регистрация</h5>
  <p>
    Регистрация на&nbsp;данное мероприятие осуществляется на&nbsp;официальном сайте. Перейдя по&nbsp;ссылке &laquo;Регистрация&raquo; вам нужно будет авторизоваться используя ваш аккаунт в&nbsp;системе <nobr>RUNET-ID</nobr>.
  </p>
  <div class="clearfix">
    <a target="_blank" href="<?=$account->ReturnUrl;?>" class="btn btn-small btn-info pull-right">Зарегистрироваться</a>
  </div>
</form>