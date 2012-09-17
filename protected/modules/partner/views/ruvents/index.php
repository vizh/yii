<?php
  $dateEnd   = new DateTime($event->DateEnd);
?>
<div class="row indent-bottom3">
  <div class="span12">
    <h2 class="indent-bottom2">Общая информация</h2>
    <div class="row">
      <div class="span5">
        <?php if (!empty($event->Days)):?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>День</th>
                <th>Участников</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($stat->Participants as $participants):?>
                <tr>
                  <td><?php echo $participants->DayTitle;?></td>
                  <td><?php echo $participants->Count;?></td>
                </tr>
              <?php endforeach;?>
            </tbody>
          </table>
        <?php else:?>
          Количество участников: <span class="label large"><?php echo $stat->Participants->Count;?></span>
        <?php endif;?>
      </div>
      <div class="span6 offset1">
        Количество регистраторов: <span class="label large"><?php echo count($operators);?></span>
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
          <?php for ($dateI = new DateTime($event->DateStart); $dateI <= $dateEnd; $dateI->modify('+1 day')):?>
            <th><?php echo $dateI->format('d.m.Y');?></th>
          <?php endfor;?>
          <?php if ($event->DateStart != $event->DateEnd):?>
            <th>Всего</th>
          <?php endif;?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($operators as $opId => $opLogin):?>
          <?php $total = 0;?>
          <tr>
            <td><?php echo $opLogin;?></td>
            <?php for ($dateI = new DateTime($event->DateStart); $dateI <= $dateEnd; $dateI->modify('+1 day')):?>
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
            <?php if ($event->DateStart != $event->DateEnd):?>
              <td><?php echo $total;?></td>
            <?php endif;?>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?php endif;?>

<?php if (isset($stat->RePrintBadges)):?>
<div class="row indent-bottom3">
  <div class="span8">
    <h2 class="indent-bottom2">Повторные печати бейджей</h2>
    <table class="table table-striped">
      <thead>
        <th>RocId</th>
        <th>ФИО</th>
        <th>Печатей</th>
      </thead>
      <tbody>
        <?php foreach ($stat->RePrintBadges as $item):?>
          <tr>
            <td><?php echo $item->User->RocId;?></td>
            <td><?php echo $item->User->LastName;?> <?php echo $item->User->FirstName;?></td>
            <td><?php echo $item->Count;?></td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>
</div>
<?php endif;?>