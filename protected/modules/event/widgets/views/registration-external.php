<?php
/**
 * @var $this \event\widgets\Registration
 * @var $account \pay\models\Account
 * @var \event\models\Participant $participant
 */
?>
<form class="registration">
    <h5 class="title"><?=Yii::t('app', 'Регистрация')?></h5>
    <?$this->widget('\event\widgets\Participant', ['event' => $this->getEvent()])?>
    <p>
        Регистрация на&nbsp;данное мероприятие осуществляется на&nbsp;официальном сайте. Перейдя по&nbsp;ссылке &laquo;Регистрация&raquo;
        вам нужно будет авторизоваться используя ваш аккаунт в&nbsp;системе <nobr>RUNET-ID</nobr>.
    </p>
    <hr/>
    <div class="text-center">
        <?=\CHtml::link(\Yii::t('app', 'Зарегистрироваться'), $account->ReturnUrl, ['class' => 'btn btn-success', 'target' => '_blank'])?>
    </div>
</form>