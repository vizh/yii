<?php
/**
 * @var $this \pay\components\Controller
 */

use event\components\WidgetPosition;

?>
<?$this->beginContent('//layouts/public')?>
    <?foreach($this->getEvent()->Widgets as $link):
    $widget = $link->Class->createWidget($this->getEvent(), true);
    if ($widget->getPosition() == WidgetPosition::Header) {
        $widget->run();
        $widget->init();
    }
    endforeach?>
    <?=$content?>
<?$this->endContent()?>