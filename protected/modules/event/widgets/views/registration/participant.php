<?php
/**
 * @var \event\widgets\Registration $this
 * @var \event\models\Participant $participant
 */
?>

<?if($participant !== null && $participant->RoleId != 24):?>
    <p class="text-success" style="font-size: 16px; line-height: 20px; margin: 15px 0 30px;">
        <strong><?=Yii::app()->user->getCurrentUser()->getFullName()?></strong>,<br>
        <?=Yii::t('app', 'Вы зарегистрированы на')?> «<?=$this->event->Title?>».<br>
        <?=Yii::t('app', 'Ваш статус')?> - <strong><?=$participant->Role->Title?></strong><br>
        <a target="_blank" href="<?=$participant->getTicketUrl()?>"><?=Yii::t('app', 'Скачать электронный билет')?></a>
        <?if(isset($this->RegistrationAfterInfo)):?>
            <br><br><span class="muted" style="font-size: 14px; line-height: 16px;"><?=$this->RegistrationAfterInfo?></span>
        <?endif?>
    </p>

    <h5 class="title"><?=Yii::t('app', 'Регистрация других участников')?></h5>
<?else:?>
    <h5 class="title"><?=isset($this->RegistrationTitle) ? $this->RegistrationTitle : \Yii::t('app', 'Регистрация')?></h5>

    <?if(isset($this->RegistrationBeforeInfo)):?>
        <?=$this->RegistrationBeforeInfo?>
    <?endif?>

<?endif?>