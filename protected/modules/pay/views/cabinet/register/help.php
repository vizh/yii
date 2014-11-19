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
    <?if ($event->Id != 1420):?>
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
    <?else:?>
        <p><?=$user->getShortName();?>,</p>
        <p>XI&nbsp;Торжественная Церемония вручения «Премии Рунета 2014» состоится 25&nbsp;ноября, в&nbsp;ГлавClub Москва. </p>
        <p><strong>Участие в&nbsp;Церемонии вручения «Премии Рунета 2014»&nbsp;— только по&nbsp;приглашениям и&nbsp;билетам!</strong><br/>Для посещения Церемонии вручения 25&nbsp;ноября 2014 года Вам необходимо <strong>получить персональное приглашение</strong> от&nbsp;Оргкомитета или <strong>приобрести билет участника</strong>.</p>
        <p>Все вопросы по&nbsp;участию в&nbsp;Церемонии: <a href="mailto:info@premiaruneta.ru">info@premiaruneta.ru</a></p>
        <p>Подробная информация о&nbsp;Конкурсе «Премия Рунета 2014»&nbsp;— на&nbsp;официальном сайте проекта: <a href="http://premiaruneta.ru">www.premiaruneta.ru</a></p>
        <p>Оплата билета для участия в XI Торжественной Церемонии вручения «Премии Рунета – 2014» может быть произведена как за одного, так и за несколько пользователей. Просто укажите своих коллег и друзей в качестве получателей услуги.</p>
    <?endif;?>
</div>