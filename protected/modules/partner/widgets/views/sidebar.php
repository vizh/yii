<?php
/**
 * @var Event $event
 */
use event\models\Event;
?>
<div id="main-menu" role="navigation">
    <div id="main-menu-inner">
        <?php if ($event !== null): ?>
            <div class="menu-content top animated fadeIn">
                <div class="text-center">
                    <span class="menu-content-event-logo">
                        <?=\CHtml::img($event->getLogo()->get120px(), ['alt' => $event->Name])?>
                    </span>
                    <p class="text-light-gray"><?=Html::encode($event->Title)?></p>
                </div>
            </div>
        <?php endif ?>
        <?=Menu::widget(['items' => $items, 'activateParents' => true, 'options' => ['class' => 'navigation']])?>
    </div>
</div>