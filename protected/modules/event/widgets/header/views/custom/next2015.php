<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>
<div class="b-event-promo <?=$event->Type->Code?> <?=$event->IdName?>">
    <div class="container">
        <div class="row">
            <div class="side left span2">
                <div class="logo">
                    <img src="<?=$event->getLogo()->getNormal()?>" alt="<?=htmlspecialchars($event->Title)?>" />
                </div>
            </div>

            <div class="details span8 offset2">
                <h2 class="title"><?=$event->Title?></h2>
                <div class="type"></div>
                <div class="duration">
          <span class="datetime">
            <span class="date">
              <?$this->widget('\event\widgets\Date', array('event' => $event))?>
            </span>
          </span>
                </div>
                <?if($event->getContactAddress() != null):?>
                    <div class="location">
                        <?if(!empty($event->getContactAddress()->Place)) echo $event->getContactAddress()->Place?>
                    </div>
                <?endif?>
            </div>

            <?if($this->eventPage):?>
                <div class="side right span2">
                    <div class="actions">
                        <a href="http://raec.ru" target="_blank"><img src="http://getlogo.org/img/raec/4/120x/" alt="РАЭК" title="РАЭК" /></a>
                    </div>
                </div>
            <?endif?>
        </div>

        <?if($this->eventPage):?>
            <span class="all">
      <a href="<?=Yii::app()->createUrl('/event/list/index')?>"><?=Yii::t('app', 'Все мероприятия')?></a>
    </span>
        <?endif?>
    </div>
</div>