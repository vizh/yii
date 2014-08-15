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
      <?=$user->getShortName();?>,
    <?else:?>
      Уважаемый пользователь,
    <?endif;?>
    на данном шаге Вы можете подтвердить или отредактировать свой заказ.</p>

  <p>После совершения оплаты, на вашу электронную почту будет выслано письмо с подробными инструкциями по использованию билетов на <?=$event->Title;?>.</p>

  <?if ($unpaidOwnerCount > 0 || $unpaidJuridicalOrderCount > 0):?>
    <p><strong>Важно:</strong> у Вас уже есть сформированные, но <a href="<?=$this->getNextStepUrl();?>">неоплаченные заказы</a>.</p>
  <?else:?>
    <p><strong>Внимание!</strong> На билеты данного типа не распространяются промо-коды.</p>
  <?endif;?>
</div>