<?php
/**
 * @var \event\widgets\Registration $this
 * @var \event\models\Participant $participant
 * @var bool $paidEvent
 */
?>

<hr/>
<div class="clearfix">
    <?if($paidEvent):?>
        <img src="/img/pay/pay-methods.png" class="pull-left" alt="Поддерживаемые способы оплаты"/>
        <a style="margin-top: -2px; display: inline-block;" href="http://money.yandex.ru" target="_blank"><img src="//money.yandex.ru/img/yamoney_logo88x31.gif " alt="Я принимаю Яндекс.Деньги" title="Я принимаю Яндекс.Деньги" border="0" /></a>
    <?endif?>
    <button type="submit" class="btn btn-success pull-right">
        <?if(isset($this->RegistrationBuyLabel)):?>
            <?=$this->RegistrationBuyLabel?>
        <?else:?>
            <?=Yii::t('app', 'Зарегистрироваться')?>
        <?endif?>
    </button>
</div>