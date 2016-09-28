<?php
/**
 * @var $this \event\widgets\LinkRegistration
 */
?>

<form class="registration">
    <?$this->widget('\event\widgets\Participant', ['event' => $this->getEvent()])?>
    <h5 class="title"><?=Yii::t('app', 'Регистрация')?></h5>
    <p>Регистрация на&nbsp;данное мероприятие осуществляется на&nbsp;официальном сайте.</p>
    <div class="text-center">
        <?=\CHtml::link(\Yii::t('app', 'Зарегистрироваться'), $this->LinkRegistration, ['class' => 'btn btn-success', 'target' => '_blank'])?>
    </div>
</form>