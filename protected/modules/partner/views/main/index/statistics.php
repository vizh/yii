<?php
/**
 * @var $roles \event\models\Role[]
 * @var $statistics array
 */
?>

<table class="table">
  <thead>
  <tr>
    <th>Роль</th>
    <th>Кол-во</th>
    <th>За Сегодня</th>
    <th>За неделю</th>
  </tr>
  </thead>
  <tbody>

  <?foreach ($roles as $role):?>
    <tr>
      <td><?=$role->Title;?></td>
      <td><?=isset($statistics['Count'][$role->Id]) ? $statistics['Count'][$role->Id] : 0;?></td>
      <td><?=isset($statistics['CountToday'][$role->Id]) ? $statistics['CountToday'][$role->Id] : 0;?></td>
      <td><?=isset($statistics['CountWeek'][$role->Id]) ? $statistics['CountWeek'][$role->Id] : 0;?></td>
    </tr>
  <?endforeach;?>

  <tr>
    <td><strong>Всего:</strong></td>
    <td><?=isset($statistics['Total']) ? $statistics['Total'] : 0;?></td>
    <td><?=isset($statistics['TotalToday']) ? $statistics['TotalToday'] : 0;?></td>
    <td><?=isset($statistics['TotalWeek']) ? $statistics['TotalWeek'] : 0;?></td>
  </tr>
  </tbody>
</table>