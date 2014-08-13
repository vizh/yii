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
    на данном шаге Вы можете сформировать или отредактировать свой заказ.</p>

    <?if ($paidEvent):?>
        <?if (count($products->all) > 1):?>
            <p>Оплата может быть произведена как за одного, так и за несколько пользователей: все услуги для <?=$event->Title;?> разделены на группы, внутри каждой из которых вы можете указать получателей.</p>
        <?else:?>
            <p>Оплата на <?=$event->Title;?> может быть произведена как за одного, так и за несколько пользователей. Просто укажите своих коллег и друзей в качестве получателей услуги.</p>
        <?endif;?>
    <?endif;?>

  <?if (!empty($account->SandBoxUserRegisterUrl)):?>
    <p>
      <strong>Если ваши коллеги еще не зарегистрированы на конференцию, вы можете сделать это за них, пройдя по <a target="_blank" href="<?=$account->SandBoxUserRegisterUrl;?>">ссылке</a>.</strong>
    </p>
  <?endif;?>

  <?if (!$account->SandBoxUser):?>
    <p>Для добавления участника достаточным будет ввести его ФИО или RUNET-ID, система автоматически проверит наличие пользователя среди участников ИТ-мероприятия и если будут найдены совпадения - предложит добавить существующий профиль. В противном случае нужно будет заполнить необходимую контактную информацию для участника.</p>

    <?if ($unpaidOwnerCount > 0 || $unpaidJuridicalOrderCount > 0):?>
      <p><strong>Важно:</strong> у Вас уже есть сформированные, но <a href="<?=$this->createUrl('/pay/cabinet/index', array('eventIdName' => $event->IdName));?>">неоплаченные заказы</a>.</p>
    <?endif;?>
  <?endif;?>
</div>