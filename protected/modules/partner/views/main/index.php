<style type="text/css">
  .label {font-size: 16px;}
</style>

<h1 class="indent-bottom3">Статистика по платежам</h1>
<div class="row indent-bottom3">
  <div class="span4">
    <h2 class="indent-bottom1">Юридические лица:</h2>
    <p>Выставлено счетов: <span class="label"><?php echo $stat->Pay->Juridical->Orders;?></span></p>
    <p>Из них оплачено: <span class="label label-success"><?php echo $stat->Pay->Juridical->OrdersPaid;?></span></p>
    <p>На сумму: <span class="label label-warning"><?php echo $stat->Pay->Juridical->Total;?> руб.</span></p>
  </div>
  <div class="span4">
    <h2 class="indent-bottom1">Физические лица:</h2>
    <p>Оплатили: <span class="label label-success"><?php echo $stat->Pay->Individual->Paid;?></span></p>
    <p>На сумму: <span class="label label-warning"><?php echo $stat->Pay->Individual->Total;?> руб.</span></p>
  </div>
</div>

<div class="row">
  <div class="span6">
    <h2 class="indent-bottom1">Участники</h2>
    <?php if (!empty($event->Days)):?>
      <?php foreach ($stat->Participants as $day):?>
        <h4><?php echo $day->Title;?></h4>
        <table class="table">
          <thead>
            <th>Роль</th>
            <th>Кол-во</th>
          </thead>
          <tbody>
            <?php foreach ($day->Roles as $role):?>
              <tr>
                <td><?php echo $role->RoleName;?></td>
                <td><?php echo $role->Count;?></td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      <?php endforeach;?>
    <?php else:?>
      <table class="table">
        <thead>
          <th>Роль</th>
          <th>Кол-во</th>
        </thead>
        <tbody>
          <?php foreach ($stat->Participants as $role):?>
            <tr>
              <td><?php echo $role->RoleName;?></td>
              <td><?php echo $role->Count;?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    <?php endif;?>
  </div>
</div>