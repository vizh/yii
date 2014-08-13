<?php
/**
 * @var \user\models\User $user
 * @var \pay\models\Product[] $products
 * @var \pay\models\Account $account
 * @var \event\models\Event $event
 * @var int $unpaidOwnerCount
 * @var int $unpaidJuridicalOrderCount
 * @var bool $paidEvent
 */
?>
<div class="alert alert-block alert-muted">
  <p>
    <?if (!empty($user->FirstName)):?>
      Dear <?=$user->getShortName();?>,
    <?else:?>
      Dear customer,
    <?endif;?>
    this step allows you make or edit your order.</p>

  <p>После совершения оплаты, на вашу электронную почту будет выслано письмо с подробными инструкциями по использованию билетов на <?=$event->Title;?>.</p>

  <?if ($unpaidOwnerCount > 0 || $unpaidJuridicalOrderCount > 0):?>
    <p><strong>Important:</strong> you have already formed but still <a href="<?=$this->createUrl('/pay/cabinet/index', array('eventIdName' => $event->IdName));?>">unpaid orders</a>.</p>
  <?else:?>
    <p><strong>Important!</strong> На билеты данного типа не распространяются промо-коды.</p>
  <?endif;?>
</div>