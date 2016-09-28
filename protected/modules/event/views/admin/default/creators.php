<?php
/**
 * @var \event\models\Event[] $events
 */
$month = null;
$duplicates = [];
?>

<div class="row-fluid">
  <div class="well">
    <table class="table">
      <thead>
      <tr>
        <th>ФИО</th>
        <th>Email</th>
        <th>Телефон</th>
        <th>RUNET-ID</th>
        <th>Мероприятие</th>
        <th>Дата создания</th>
      </tr>
      </thead>
      <tbody>
      <?foreach($events as $event):?>
        <?
        $startDate = $event->getTimeStampStartDate();
        $endDate = $event->getTimeStampEndDate();
        if (!isset($event->ContactPerson))
          continue;

        $contact = unserialize($event->ContactPerson);
        if (empty($contact['RunetId']) || in_array($contact['RunetId'], $duplicates))
          continue;

        $duplicates[] = $contact['RunetId'];

        $curMonth = Yii::app()->getLocale()->getDateFormatter()->format('LLLL yyyy', $startDate);
       ?>
        <?if($curMonth != $month):
          $month = $curMonth;
         ?>
          <tr>
            <td colspan="6" style="padding-top: 30px;"><span style="font-size: 18px;"><?=$curMonth?></span></td>
          </tr>
        <?endif?>
        <tr>
          <td><?=$contact['Name']?></td>
          <td><?=$contact['Email']?></td>
          <td><?=$contact['Phone']?></td>
          <td><?=$contact['RunetId']?></td>
          <td><?=$event->Title?></td>
          <td>
            <?if($startDate == $endDate):?>
              <?=date('d.m', $startDate)?>
            <?else:?>
              <?=date('d.m', $startDate)?>&nbsp;&mdash;&nbsp;<?=date('d.m', $endDate)?>
            <?endif?>
          </td>
        </tr>
      <?endforeach?>
      </tbody>
    </table>
  </div>
</div>