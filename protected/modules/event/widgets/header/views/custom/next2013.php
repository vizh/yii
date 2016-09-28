<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>

<div class="b-event-promo" style="background-image: url('/img/event/next2013/header.png'); background-position: center;">
    <div class="container">
        <div class="row">
            <div class="side left span4">
                <div class="logo img-square">
                    <img src="<?=$event->getLogo()->get120px()?>" alt="">
                </div>
            </div>
            <div class="details span4 offset4">
                <h2 class="title" style="font-size: 25px; white-space: nowrap;"><span><?=CHtml::encode($event->Title)?></span></h2>
                <div class="type">
                    Конференция
                </div>
                <div class="duration">
                  <span class="datetime">
                    <span class="date">
                      <?$this->widget('\event\widgets\Date', array('event' => $event))?>
                    </span>
                  </span>
                </div>
                <?if($event->getContactAddress() != null):?>
                  <div class="location">
                    <?=\Yii::t('app', 'г.')?> <?=$event->getContactAddress()->City->Name?><?if(!empty($event->getContactAddress()->Place)) echo ', '.$event->getContactAddress()->Place?>
                  </div>
                <?endif?>
            </div>
        </div>
        <?if($this->eventPage):?>
            <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
        <?endif?>
    </div>
</div>