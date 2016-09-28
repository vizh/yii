<?php
/**
 * @var $this \event\widgets\header\Banner
 */
?>
<div class="b-event-promo <?=$this->event->IdName?>">
    <div class="container">
        <div class="row">
            <div class="span12"></div>
        </div>
        <?if($this->eventPage):?>
            <span class="all">
                <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
            </span>
        <?endif?>
    </div>
</div>