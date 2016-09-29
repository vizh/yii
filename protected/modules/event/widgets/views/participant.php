<?php
/**
 * @var \event\widgets\Participant $this
 * @var \event\models\Participant $participant
 */
?>
<div class="text-center m-bottom_20">
    <hr/>
    <p><?=$participant->User->getShortName()?>, <?=\Yii::t('app', 'ваш статус')?>: <strong><?=$participant->Role->Title?></strong></p>
    <?if($this->message):?>
        <?=$this->message?>
    <?endif?>
    <p><?=\CHtml::link(\Yii::t('app', 'Электронный билет'), $participant->getTicketUrl(), ['class' => 'btn btn-small btn-info', 'target' => '_blank'])?></p>
    <hr/>
</div>
