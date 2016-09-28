<?php
/**
 * @var $this \event\widgets\Header
 */
$event = $this->event;
?>
<?if(\Yii::app()->getController()->getModule()->getId() == 'pay'):?>
  <style type="text/css">
    header#header {
      display: none;
    }
  </style>
<?endif?>

<div class="b-event-promo" style="background: #ffffff;">
  <a href="http://www.msdevcon.ru/register/" target="_blank"><img src="/img/event/devcon14/bg.png" border="0" /></a>
</div>