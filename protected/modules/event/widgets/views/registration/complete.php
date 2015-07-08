<?php
/**
 * @var \event\models\Participant $participant
 * @var bool $successRegister
 * @var \event\widgets\DetailedRegistration $this
 */
?>

<div class="registration" id="event_widgets_Registration">
    <p class="text-success" style="font-size: 16px; line-height: 20px; margin: 15px 0 5px;">
        <?if (isset($this->WidgetRegistrationCompleteText)):?>
            <?=$this->WidgetRegistrationCompleteText;?>
        <?else:?>
            <?=Yii::t('registration', 'Спасибо за регистрацию!');?>
        <?endif;?>
    </p>
</div>