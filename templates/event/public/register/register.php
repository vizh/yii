<?php
/** @var $event Event */
$event = $this->Event;
/** @var $products Product[] */
$products = $this->Products;
?>

<style type="text/css">
  input[type='radio']{
    margin-left: -25px;
    width: 15px;
    margin-right: 12px;
  }
  div.add-vacancy label{
    font-size: 14px;
    cursor: pointer;
    margin-left: 25px;
    display: inline-block;
  }
  div.add-vacancy label span{
    font-size: 18px;
  }
  span.product-price{
    color: #cc3333;
  }
</style>

<div class="content">
  <form id="register_on_event" action="" method="post">
    <div class="vacancies add-vacancy">
      <h2>Регистрация на мероприятии</h2>

      <?if ($event->FastRole != null):?>
      <p>Подтвердите свое согласие на регистрацию на мероприятие <strong><?=$event->Name;?></strong></p>
      <?elseif (!empty($products) && sizeof($products) == 1):?>
      <p>Подтвердите свое согласие на регистрацию на мероприятие <strong><?=$event->Name;?></strong>. Стоимость участия в мероприятии <span class="product-price"><?=$products[0]->GetPrice();?>&nbsp;руб.</span></p>

      <p>После подтверждения участия, вы будете перенаправлены на страницу оплаты участия в мероприятии.</p>

        <input type="hidden" name="productId" value="<?=$products[0]->ProductId;?>">

      <?elseif (!empty($products)):?>
    <p>Подтвердите свое согласие на регистрацию на мероприятие <strong><?=$event->Name;?></strong>. Стоимость участия платная, выберите подходящий вариант из списка.</p>



        <?$flag=true; foreach ($products as $product):?>
        <p>
          <label><input type="radio" <?=$flag?'checked="checked"':'';?> name="productId" value="<?=$product->ProductId;?>"><?=$product->Title;?><br>
          Стоимость: <span class="product-price"><?=$product->GetPrice();?>&nbsp;руб.</span></label>
        </p>
        <?$flag = false; endforeach;?>


      <p>После подтверждения участия, вы будете перенаправлены на страницу оплаты участия в мероприятии.</p>
      <?endif;?>


      <?if ($event->FastRole != null || (!empty($products))):?>
      <div class="response" style="float: left; padding-right: 35px;">

        <a href="" onclick="$('#register_on_event')[0].submit(); return false;">Зарегистрироваться</a>

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
  </form>

</div>