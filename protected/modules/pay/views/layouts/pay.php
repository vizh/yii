<?php
/**
 * @var $this \pay\components\Controller
 */

use event\components\WidgetPosition;
?>
<?$this->beginContent('//layouts/public');?>
  <section id="section" role="main">
    <?php foreach ($this->getEvent()->Widgets as $link):
        $widget = $link->Class->createWidget($this->getEvent(), true);
        if ($widget->getPosition() == WidgetPosition::Header) {
            $widget->eventPage = false;
            $widget->run();
        }
    endforeach;?>
    <?php echo $content; ?>
  </section>
<?$this->endContent();?>