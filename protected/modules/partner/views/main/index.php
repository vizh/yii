<?php
/**
 * @var $roles \event\models\Role[]
 * @var $statistics array
 * @var $event \event\models\Event
 * @var $this MainController
 */
?>

<div class="row">
  <div class="span8">
    <h2 class="indent-bottom1">Участники</h2>
    <?php if (sizeof($event->Parts) === 0):?>
      <?$this->renderPartial('index/statistics', array('statistics' => $statistics, 'roles' => $roles));?>
    <?php else:?>
      <?php foreach ($event->Parts as $part):?>
        <h4><?php echo $part->Title;?></h4>
        <?$this->renderPartial('index/statistics', array('statistics' => $statistics[$part->Id], 'roles' => $roles));?>
      <?php endforeach;?>
    <?php endif;?>
  </div>
</div>