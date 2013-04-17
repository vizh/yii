<?php
/**
 * @var $event \event\models\Event
 */

$dateEnd = new DateTime($event->EndYear.'-'.$event->EndMonth.'-'.$event->EndDay);
?>
<div class="row indent-bottom3">
  <div class="span12">
    <h2 class="indent-bottom2">Общая информация</h2>
    <div class="row">
      <div class="span5">
        <?php if (!empty($stat->Participants)):?>
        <table class="table table-striped">
          <thead>
          <tr>
            <th>День</th>
            <th>Участников</th>
          </tr>
          </thead>
          <tbody>
            <?php foreach ($stat->Participants as $date => $participant):?>
            <?php
            $total = 0;
            foreach($participant as $roleId => $count) {
              $total += $count;
            }
            ?>
          <tr>
            <td><?php echo $date;?></td>
            <td><?php echo $total;?></td>
          </tr>
            <?php endforeach;?>
          </tbody>
        </table>
        <?php endif;?>
      </div>
      <div class="span6 offset1">
        <p>Всего участников: <span class="label large"><?php echo $stat->CountParticipants;?></span></p>
        <p>Всего выдано бейджей: <span class="label large"><?php echo $stat->CountBadges;?></span></p>
        <p>Количество регистраторов: <span class="label large"><?php echo count($operators);?></span></p>
      </div>
    </div>
  </div>
</div>

<?php if (isset($stat->PrintBadges)):?>
<div class="row indent-bottom3">
  <div class="span12">
    <h2 class="indent-bottom2">Количество выданных бейджей</h2>
    <table class="table table-striped">
      <thead>
      <tr>
        <th>Регистратор</th>
        <?php for ($dateI = new DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay); $dateI <= $dateEnd; $dateI->modify('+1 day')):?>
        <th><?php echo $dateI->format('d.m.Y');?></th>
        <?php endfor;?>
        <?php if ($event->StartYear != $event->EndYear && $event->StartMonth != $event->EndMonth && $event->StartDay != $event->EndDay):?>
        <th>Всего</th>
        <?php endif;?>
      </tr>
      </thead>
      <tbody>
        <?php foreach ($operators as $opId => $opLogin):?>
        <?php $total = 0;?>
      <tr>
        <td><?php echo $opLogin;?></td>
        <?php for ($dateI = new DateTime($event->StartYear.'-'.$event->StartMonth.'-'.$event->StartDay); $dateI <= $dateEnd; $dateI->modify('+1 day')):?>
        <td>
          <?php if (isset($stat->PrintBadges[$dateI->format('d.m.Y')][$opId])):?>
          <?php echo $stat->PrintBadges[$dateI->format('d.m.Y')][$opId]->Count;?>
          <?php
          $total += $stat->PrintBadges[$dateI->format('d.m.Y')][$opId]->Count;
          ?>
          <?php else:?>
          &ndash;
          <?php endif;?>
        </td>
        <?php endfor;?>
        <?php if ($event->StartYear != $event->EndYear && $event->StartMonth != $event->EndMonth && $event->StartDay != $event->EndDay):?>
        <td><?php echo $total;?></td>
        <?php endif;?>
      </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?php endif;?>

<?php if (!empty($stat->Participants)):?>
<div class="row indent-bottom3">
  <div class="span12">
    <h2 class="indent-bottom2">Статус / Бейдж</h2>

    <table class="table table-striped">
      <thead>
      <tr>
        <th>Статус</th>
        <?php foreach ($stat->Participants as $date => $participants):?>
        <th><?php echo $date;?></th>
        <?php endforeach;?>
        <th>Всего</th>
      </tr>
      </thead>
      <tbody>
        <?php foreach ($stat->Roles as $roleId => $roleName):?>
      <tr>
        <td><?php echo $roleName;?></td>
        <?php $totalX = 0;?>
        <?php foreach ($stat->Participants as $date => $participants):?>
        <td>
          <?php if (isset($participants[$roleId])):?><?php echo $participants[$roleId]; $totalX += $participants[$roleId]?><?php else:?>&nbsp;<?php endif;?>
        </td>
        <?php endforeach;?>
        <td><?php echo $totalX;?></td>
      </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?php endif;?>


<div class="row indent-bottom3">
  <div class="span12">
    <h2 class="indent-bottom2">Новые участники / пользователи</h2>

    <table class="table table-striped">
      <thead>
      <tr>
        <th>Тип данных</th>
        <?php foreach ($stat->New as $date => $info):?>
        <th><?php echo $date;?></th>
        <?php endforeach;?>
        <th>Всего</th>
      </tr>
      </thead>
      <tbody>

      <tr>
        <td>Новых участников</td>
        <?php $totalX = 0;?>
        <?php foreach ($stat->New as $date => $info):?>
        <td>
          <?=$info['AllParticipants']; $totalX += $info['AllParticipants'];?>
        </td>
        <?php endforeach;?>
        <td><?php echo $totalX;?></td>
      </tr>

      <tr>
        <td>Новых участников через Ruvents</td>
        <?php $totalX = 0;?>
        <?php foreach ($stat->New as $date => $info):?>
        <td>
          <?=$info['AllParticipantsByRuvents']; $totalX += $info['AllParticipantsByRuvents'];?>
        </td>
        <?php endforeach;?>
        <td><?php echo $totalX;?></td>
      </tr>

      <tr>
        <td>Новых пользователей</td>
        <?php $totalX = 0;?>
        <?php foreach ($stat->New as $date => $info):?>
        <td>
          <?=$info['AllUsers']; $totalX += $info['AllUsers'];?>
        </td>
        <?php endforeach;?>
        <td><?php echo $totalX;?></td>
      </tr>

      <tr>
        <td>Новых пользователей через Ruvents</td>
        <?php $totalX = 0;?>
        <?php foreach ($stat->New as $date => $info):?>
        <td>
          <?=$info['AllUsersByRuvents']; $totalX += $info['AllUsersByRuvents'];?>
        </td>
        <?php endforeach;?>
        <td><?php echo $totalX;?></td>
      </tr>

      </tbody>
    </table>
  </div>
</div>



<?php if (isset($stat->RePrintBadges)):?>
<div class="row indent-bottom3">
  <div class="span8">
    <h2 class="indent-bottom2">Повторные печати бейджей</h2>
    <table class="table table-striped">
      <thead>
      <tr>
        <th>RUNET-ID</th>
        <th>ФИО</th>
        <th>Печатей</th>
      </tr>
      </thead>
      <tbody>
        <?php foreach ($stat->RePrintBadges as $item):?>
      <tr>
        <td><?php echo $item->User->RunetId;?></td>
        <td><?php echo $item->User->LastName;?> <?php echo $item->User->FirstName;?></td>
        <td><?php echo $item->Count;?></td>
      </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?php endif;?>