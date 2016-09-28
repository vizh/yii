<?php
/**
 * @var \event\models\Participant $participant
 * @var bool $successRegister
 * @var \event\widgets\DetailedRegistration $this
 */
?>
<div class="registration" id="<?=$this->getNameId()?>">
    <?=isset($this->WidgetRegistrationTitle)? $this->WidgetRegistrationTitle : \CHtml::tag('h5', ['class' => 'title text-center'], Yii::t('app', 'Регистрация'))?>
    <?$this->widget('\event\widgets\Participant', ['widget' => $this])?>
    <?if(isset($this->WidgetRegistrationCompleteText)):?>
    <p class="text-success text-center">
        <?=$this->WidgetRegistrationCompleteText?>
    </p>
    <?endif?>
</div>