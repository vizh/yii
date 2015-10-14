<?php
/**
 * @var \event\models\Participant $participant
 * @var bool $successRegister
 * @var \event\widgets\DetailedRegistration $this
 */
?>

<div class="registration" id="<?=$this->getNameId();?>">
    <h5 class="title text-center">
        <?=isset($this->WidgetRegistrationTitle)? $this->WidgetRegistrationTitle : Yii::t('app', 'Регистрация');?>
    </h5>
    <?php $this->widget('\event\widgets\Participant', ['event' => $this->getEvent()]); ?>
    <?if (isset($this->WidgetRegistrationCompleteText)):?>
    <p class="text-success text-center">
        <?=$this->WidgetRegistrationCompleteText;?>
    </p>
    <?endif;?>
</div>