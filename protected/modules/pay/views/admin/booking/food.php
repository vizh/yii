<?php
/**
 * @var string[] $dates
 * @var array $food
 * @var array $usersFood
 */
?>

<div class="btn-toolbar"></div>
<div class="well">

  <h3>Поляны</h3>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th>&nbsp;</th>
      <?foreach ($dates as $date):?>
        <th><?=date('d.m', strtotime($date));?></th>
      <?endforeach;?>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Завтраки</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['breakfastP'][$food['breakfast'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    <tr>
      <td>Обеды</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['allOtherP'][$food['lunch'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    <tr>
      <td>Ужины</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['allOtherP'][$food['dinner'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    <tr>
      <td>Фуршет</td>
      <td><?=count($usersFood['banquetP'][$food['banquet']]);?></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    </tbody>
  </table>

  <h3>Поляны (Андерсон)</h3>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th>&nbsp;</th>
      <?foreach ($dates as $date):?>
        <th><?=date('d.m', strtotime($date));?></th>
      <?endforeach;?>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Обеды</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['anderson'][$food['anderson'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    </tbody>
  </table>

  <h3>Лесные дали</h3>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th>&nbsp;</th>
      <?foreach ($dates as $date):?>
        <th><?=date('d.m', strtotime($date));?></th>
      <?endforeach;?>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Завтраки</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['allLD'][$food['breakfast'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    <tr>
      <td>Обеды</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['allLD'][$food['lunch'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    <tr>
      <td>Ужины</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['allLD'][$food['dinner'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    </tbody>
  </table>

  <h3>Назарьево</h3>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th>&nbsp;</th>
      <?foreach ($dates as $date):?>
        <th><?=date('d.m', strtotime($date));?></th>
      <?endforeach;?>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Завтраки</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['breakfastN'][$food['breakfast'][$key]]);?></td>
      <?endforeach;?>
    </tr>

    <tr>
      <td>Список завтракающих</td>

      <?foreach ($dates as $key => $value):?>
        <?
        $criteria = new CDbCriteria();
        $criteria->addInCondition('t."RunetId"', $usersFood['breakfastN'][$food['breakfast'][$key]]);
        $criteria->order = 't."LastName"';
        $users = \user\models\User::model()->findAll($criteria);
        ?>
        <td>
          <?foreach ($users as $user):?>
            <?=$user->RunetId;?>, <?=$user->getFullName();?><br>
          <?endforeach;?>
        </td>
      <?endforeach;?>
    </tr>
    </tbody>
  </table>

  <h3>Сосны</h3>
  <table class="table table-bordered">
    <thead>
    <tr>
      <th>&nbsp;</th>
      <?foreach ($dates as $date):?>
        <th><?=date('d.m', strtotime($date));?></th>
      <?endforeach;?>
    </tr>
    </thead>
    <tbody>
    <tr>
      <td>Завтраки</td>
      <?foreach ($dates as $key => $value):?>
        <td><?=count($usersFood['breakfastS'][$food['breakfast'][$key]]);?></td>
      <?endforeach;?>
    </tr>
    </tbody>
  </table>



</div>