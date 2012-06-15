<?php
/** @var $juridical OrderJuridical */
$juridical = $this->OrderJuridical;
?>
<div class="span16">
  <h2>Счет №<?=$this->OrderId;?></h2>

  <?if($juridical->Paid == 1):?><span class="label success">оплачен</span><?endif;?>

  <h3>Данные заказчика</h3>

  <div class="row">
    <div class="span6">
      <address>
        <strong><?=$juridical->Name;?></strong><br>
        <?=$juridical->Address;?>
      </address>
    </div>
    <div class="span6">
      <address>
        <strong>ИНН/КПП</strong><br>
        <?=$juridical->INN;?> / <?=$juridical->KPP;?>
      </address>
    </div>
  </div>

  <h3>Сумма счета: <?=$this->Total;?> руб.</h3>

  <form action="" method="post">
    <input type="hidden" name="step" value="2">
    <input type="hidden" name="orderId" value="<?=$juridical->OrderId;?>">
    <fieldset>
      <div class="clearfix">
        <input type="submit" value="Отметить &quot;Счет оплачен&quot;" class="btn primary" <?if($juridical->Paid == 1):?>onclick="return confirm('Счет уже отмечен как оплаченный. Повторить?');"<?endif;?>>
        <a target="_blank" class="btn" href="<?=RouteRegistry::GetUrl('main', 'juridical', 'order', array('orderId' => $juridical->OrderId, 'hash' => $juridical->GetHash(), 'clear' => 'clear'));?>">Просмотреть счет</a>
        <a class="btn" href="<?=RouteRegistry::GetAdminUrl('juridical', '', 'index');?>">Назад</a>
      </div>
    </fieldset>
  </form>
</div>