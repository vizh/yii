<?php
/**
 * @var $this \pay\components\Controller
 */
?>
<?$this->beginContent('//layouts/public');?>
  <section id="section" role="main">
    <?foreach ($this->getEvent()->Widgets as $widget):?>
      <?if ($widget->getPosition() == \event\components\WidgetPosition::Header):?>
        <?
        $widget->getWidget()->eventPage = false;
        $widget->run();
        ?>
      <?endif;?>
    <?endforeach;?>
    <?php echo $content; ?>
  </section>
<?$this->endContent();?>