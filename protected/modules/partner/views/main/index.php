<?php
/**
 * @var $roles \event\models\Role[]
 * @var $statistics array
 * @var $event \event\models\Event
 * @var $this MainController
 * @var $timeSteps array
 */
?>

<div class="row">
  <div class="span8">
    <h2 class="indent-bottom1">Участники</h2>

    <table class="table">
      <thead>
      <tr>
        <th>Роль</th>
        <?foreach ($timeSteps as $key => $time):?>
          <th><?=$key;?></th>
        <?endforeach;?>
      </tr>
      </thead>
      <tbody>

      <?foreach ($roles as $role):?>
        <tr>
          <td><?=$role->Title;?></td>
          <?foreach ($timeSteps as $key => $time):?>
            <td><?=isset($statistics[$key][$role->Id]) ? $statistics[$key][$role->Id] : 0;?></td>
          <?endforeach;?>
        </tr>
      <?endforeach;?>

      <tr>
        <td><strong>Всего:</strong></td>
        <?foreach ($timeSteps as $key => $time):?>
          <td><?=$statistics[$key]['Total'];?></td>
        <?endforeach;?>
      </tr>
      </tbody>
    </table>



    <?if (sizeof($event->Parts) > 0):?>
      <?$this->renderPartial('index/parts', [
        'statistics' => $statistics,
        'event' => $event,
        'timeSteps' => $timeSteps
      ]);?>
    <?endif;?>
  </div>
</div>