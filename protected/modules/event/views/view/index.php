<?php
/**
 * @var $event \event\models\Event
 * @var $this ViewController
 */

use event\components\WidgetPosition;

$renderTabs = true;

if ($event->CounterHeadHTML) {
    $this->beginClip('event-counter-head');
    echo $event->CounterHeadHTML;
    $this->endClip();
}

if ($event->CounterBodyHTML) {
    $this->beginClip('event-counter-body');
    echo $event->CounterBodyHTML;
    $this->endClip();
}

foreach ($event->Widgets as $widget) {
    if ($widget->getPosition() == WidgetPosition::Header) {
        $widget->run();
    }
}

$fullWidth = false;
foreach ($event->Widgets as $widget) {
    if ($widget->getPosition() == WidgetPosition::FullWidth) {
        $widget->run();
        $fullWidth = true;
    }
}
if ($fullWidth) {
    return;
}

?>

<div class="event-page <?=$event->IdName?> <?=$event->FullWidth ? 'event-page-fullwidth' : ''?>" itemscope itemtype="http://schema.org/Event">
    <meta itemprop="name" content="<?=htmlspecialchars($event->Title)?>"/>
    <meta itemprop="startDate" content="<?=$event->getFormattedStartDate('yyyy-MM-dd')?>"/>
    <meta itemprop="image" content="<?=$event->getLogo()->getNormal()?>"/>

    <?if(!$event->FullWidth):?>
        <div class="container">
            <div class="row">
                <aside class="sidebar span3 pull-left">
                    <?foreach($event->Widgets as $widget):?>
                        <?if($widget->getPosition() == WidgetPosition::Sidebar && $widget->getIsActive()):?>
                            <?$widget->run()?>
                        <?endif?>
                    <?endforeach?>
                </aside>
                <div class="span8 pull-right">
                    <?foreach($event->Widgets as $widget):?>
                        <?if($widget->getIsActive()):?>
                            <?if($widget->getPosition() == WidgetPosition::Content):?>
                                <?$widget->run()?>
                            <?php elseif ($renderTabs && $widget->getPosition() == WidgetPosition::Tabs):?>
                                <?$this->renderPartial('tabs', ['event' => $event])?>
                                <?$renderTabs = false?>
                            <?endif?>
                        <?endif?>
                    <?endforeach?>
                </div>
            </div>
        </div>
    <?else:?>
        <?foreach($event->Widgets as $widget):?>
            <?if($widget->getIsActive()):?>
                <?if($widget->getPosition() != WidgetPosition::Tabs && $widget->getPosition() != WidgetPosition::Header):?>
                    <?if($widget->getName() == 'event\widgets\Location'):?>
                        <?$widget->run()?>
                    <?else:?>
                        <div class="container">
                            <?$widget->run()?>
                        </div>
                    <?endif?>
                <?php elseif ($renderTabs && $widget->getPosition() == \event\components\WidgetPosition::Tabs):?>
                    <div class="container">
                        <?$this->renderPartial('tabs', ['event' => $event])?>
                    </div>
                    <?$renderTabs = false?>
                <?endif?>
            <?endif?>
        <?endforeach?>
    <?endif?>
</div>
