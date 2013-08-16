<?php
/**
 * @var $event \event\models\Event
 * @var $statistics array
 * @var $timeSteps array
 */
?>

<h3>Распределение участников по мероприятию</h3>

<table class="table">
  <thead>
  <tr>
    <th>&nbsp;</th>
    <?foreach ($timeSteps as $key => $time):?>
      <th><?=$key;?></th>
    <?endforeach;?>
  </tr>
  </thead>
  <tbody>

  <?foreach ($event->Parts as $part):?>
    <tr>
      <td><?=$part->Title;?></td>
      <?foreach ($timeSteps as $key => $time):?>
        <td><?=isset($statistics['Parts'][$key][$part->Id]) ? $statistics['Parts'][$key][$part->Id] : 0;?></td>
      <?endforeach;?>
    </tr>
  <?endforeach;?>

  <tr>
    <td><strong>Всего:</strong></td>
    <?foreach ($timeSteps as $key => $time):?>
      <td><?=$statistics['Parts'][$key]['Total'];?></td>
    <?endforeach;?>
  </tr>
  </tbody>
</table>