<?php
/** @var $event Event */
$event = $this->Event;
/** @var $product Product */
$product = $this->Product;
?>
<div class="content">
  <div class="vacancies add-vacancy">
    <h2>Регистрация на мероприятии</h2>

    <?if ($event->FastRole != null):?>
    <p>Подтвердите свое согласие на регистрацию на мероприятие <strong><?=$event->Name;?></strong></p>
    <?elseif (!empty($product)):?>
    <p>Подтвердите свое согласие на регистрацию на мероприятие <strong><?=$event->Name;?></strong>. Стоимость участия в мероприятии <?=$product->GetPrice();?> руб.</p>

    <p>После подтверждения участия, вы будете перенаправлены на страницу оплаты участия в мероприятии.</p>
    <?endif;?>


    <?if ($event->FastRole != null || !empty($product)):?>
    <div class="response" style="float: left; padding-right: 35px;">
      <form id="register_on_event" action="" method="post">
        <a href="" onclick="$('#register_on_event')[0].submit(); return false;">Зарегистрироваться</a>
      </form>
    </div>

    <div class="response" style="float: left;">
      <a href="<?=RouteRegistry::GetUrl('event', '', 'show', array('idName' => $event->IdName));?>">Отмена</a>
    </div>
    <?else:?>
    <p>
      При создании мероприятия произошла ошибка. Для регистрации свяжитесь со службой технической поддержки.
    </p>
    <?endif;?>

  </div>

</div>