<?php
/**
 * @var Event $event
 */
use event\models\Event;
?>
<div id="main-menu" role="navigation">
    <div id="main-menu-inner">
        <?if($event !== null):?>
            <div class="menu-content top animated fadeIn">
                <div class="text-center">
                    <span class="menu-content-event-logo">
                        <?=\CHtml::image($event->getLogo()->get120px(), $event->Title)?>
                    </span>
                    <p class="text-light-gray m-top_10"><?=\CHtml::encode($event->Title)?></p>
                    <?=\CHtml::link(\Yii::t('app', 'Страница мероприятия'), $event->getUrl(), ['target' => '_blank', 'class' => 'btn btn-xs'])?>
                </div>
            </div>
        <?endif?>
        <?$this->widget('partner\widgets\Menu', ['items' => $items, 'activateParents' => true, 'htmlOptions' => ['class' => 'navigation']])?>
    </div>
</div>