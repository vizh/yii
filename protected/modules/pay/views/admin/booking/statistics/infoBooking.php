<?php
/**
 * @var \pay\models\RoomPartnerBooking $partnerBooking
 */
$dateOut = $partnerBooking->DateOut > '2014-04-25' ? '2014-04-25' : $partnerBooking->DateOut;
$dateIn = $partnerBooking->DateIn < '2014-04-22' ? '2014-04-22' : $partnerBooking->DateIn;
$days = (strtotime($dateOut) - strtotime($dateIn)) / (24*60*60);
$together = !empty($partnerBooking->People) ? json_decode($partnerBooking->People) : [];
?>
<td rowspan="<?=intval($days);?>">
  <?if ($partnerBooking->Paid):?>
    <span class="label label-success">оплачен</span>
  <?else:?>
    <span class="label label-warning">забронирован</span>
  <?endif;?>
  <?if ($partnerBooking->AdditionalCount != 0):?>
    <br><strong>Доп. мест: <?=$partnerBooking->AdditionalCount;?></strong>
  <?endif;?>
</td>
<td rowspan="<?=intval($days);?>">
  <?if (!empty($together)):?>
    <?foreach ($together as $name):?>
      <?=$name;?><br>
    <?endforeach;?>
  <?else:?>
  <?endif;?>

</td>