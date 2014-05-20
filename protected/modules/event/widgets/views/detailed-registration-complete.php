<?php
/**
 * @var \event\models\Participant $participant
 * @var bool $successRegister
 * @var \event\widgets\DetailedRegistration $this
 */
?>

<div class="registration">
    <p class="text-success" style="font-size: 16px; line-height: 20px; margin: 15px 0 30px;">
        <strong><?=Yii::app()->user->getCurrentUser()->getFullName();?></strong>,<br>
        <?=Yii::t('app', 'Регистрация на');?> <?=$this->event->Title;?> <?=Yii::t('app', 'прошла успешно, ждем Вас на мероприятии');?>.<br/><br/>
    </p>
</div>