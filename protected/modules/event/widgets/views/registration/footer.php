<?php
/**
 * @var \event\widgets\Registration $this
 * @var \event\models\Participant $participant
 * @var bool $paidEvent
 */
?>

<div class="clearfix">
    <?if ($paidEvent):?>
        <img src="/img/pay/pay-methods.png" class="pull-left" alt="Поддерживаемые способы оплаты"/>
        <a style="margin-top: -2px; display: inline-block;" href="http://money.yandex.ru" target="_blank"><img src="http://money.yandex.ru/img/yamoney_logo88x31.gif " alt="Я принимаю Яндекс.Деньги" title="Я принимаю Яндекс.Деньги" border="0" /></a>
    <?endif;?>
    <button type="submit" class="btn btn-info pull-right">
        <?if (isset($this->RegistrationBuyLabel)):?>
            <?=$this->RegistrationBuyLabel;?>
        <?else:?>
            <?if ($participant !== null && $participant->RoleId != 24):?>
                <?=Yii::t('app', $paidEvent ? 'Оплатить (за себя или коллег)' : 'Зарегистрировать коллег');?>
            <?else:?>
                <?=Yii::t('app', 'Зарегистрироваться');?>
            <?endif;?>
        <?endif;?>
    </button>
</div>