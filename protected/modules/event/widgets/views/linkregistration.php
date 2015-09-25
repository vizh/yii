<?php
/**
 * @var $this \event\widgets\LinkRegistration
 */
?>

<form class="registration">
    <?php $this->widget('\event\widgets\Participant', ['event' => $this->getEvent()]); ?>
    <h5 class="title"><?= Yii::t('app', 'Регистрация'); ?></h5>
    <p>
        Регистрация на&nbsp;данное мероприятие осуществляется на&nbsp;официальном сайте. Перейдя по&nbsp;ссылке &laquo;Регистрация&raquo;
        вам нужно будет авторизоваться используя ваш аккаунт в&nbsp;системе
    <nobr>RUNET-ID</nobr>
    .
    </p>
    <div class="text-center">
        <?=\CHtml::link(\Yii::t('app', 'Зарегистрироваться'), $this->LinkRegistration, ['class' => 'btn btn-success', 'target' => '_blank']);?>
    </div>
</form>