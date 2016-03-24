<?php
/**
 * @var $event \event\models\Event
 * @var $this ViewController
 */

use event\components\WidgetPosition;

$renderTabs = true;

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

<div class="event-page <?= $event->IdName; ?> <?= $event->FullWidth ? 'event-page-fullwidth' : ''; ?>" itemscope
     itemtype="http://schema.org/Event">
    <meta itemprop="name" content="<?= htmlspecialchars($event->Title); ?>"/>
    <meta itemprop="startDate" content="<?= $event->getFormattedStartDate('yyyy-MM-dd'); ?>"/>
    <meta itemprop="image" content="<?= $event->getLogo()->getNormal(); ?>"/>

    <?php if (!$event->FullWidth): ?>
        <div class="container">
            <div class="row">
                <aside class="sidebar span3 pull-left">
                    <?php foreach ($event->Widgets as $widget): ?>
                        <?php if ($widget->getPosition() == WidgetPosition::Sidebar && $widget->getIsActive()): ?>
                            <?php $widget->run() ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </aside>
                <div class="span8 pull-right">
                    <?php foreach ($event->Widgets as $widget): ?>
                        <?php if ($widget->getIsActive()): ?>
                            <?php if ($widget->getPosition() == WidgetPosition::Content): ?>
                                <?php $widget->run() ?>
                            <?php elseif ($renderTabs && $widget->getPosition() == WidgetPosition::Tabs): ?>
                                <?php $this->renderPartial('tabs', ['event' => $event]) ?>
                                <?php $renderTabs = false ?>
                            <?php endif ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($event->Widgets as $widget): ?>
            <?php if ($widget->getIsActive()): ?>
                <?php if ($widget->getPosition() != WidgetPosition::Tabs && $widget->getPosition() != WidgetPosition::Header): ?>
                    <?php if ($widget->getName() == 'event\widgets\Location'): ?>
                        <?php $widget->run() ?>
                    <?php else: ?>
                        <div class="container">
                            <?php $widget->run(); ?>
                        </div>
                    <?php endif ?>
                <?php elseif ($renderTabs && $widget->getPosition() == \event\components\WidgetPosition::Tabs): ?>
                    <div class="container">
                        <?php $this->renderPartial('tabs', ['event' => $event]) ?>
                    </div>
                    <?php $renderTabs = false ?>
                <?php endif ?>
            <?php endif ?>
        <?php endforeach ?>
    <?php endif ?>
</div>
