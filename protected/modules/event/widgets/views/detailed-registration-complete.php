<?php
/**
 * @var \event\models\Participant $participant
 * @var bool $successRegister
 * @var \event\widgets\DetailedRegistration $this
 */
?>

<div class="registration">
    <?if ($successRegister):?>
        <div class="alert alert-success">
            Вы успешно зарегистрировались на <strong>«<?=$this->event->Title;?>»</strong>!
        </div>
    <?endif;?>

    <p class="text-success" style="font-size: 16px; line-height: 20px; margin: 15px 0 30px;">
        <strong><?=Yii::app()->user->getCurrentUser()->getFullName();?></strong>,<br>
        <?=Yii::t('app', 'Вы зарегистрированы на');?> «<?=$this->event->Title;?>».<br>
        <?=Yii::t('app', 'Ваш статус')?> - <strong><?=$participant->Role->Title;?></strong><br>
        <a target="_blank" href="<?=$participant->getTicketUrl();?>"><?=Yii::t('app', 'Скачать электронный билет');?></a>
    </p>
</div>