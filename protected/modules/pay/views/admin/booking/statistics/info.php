<?php
/**
 * @var \pay\models\OrderItem $orderItem
 * @var array $usersFullData
 * @var array $usersTogether
 */
$days = (strtotime($orderItem->getItemAttribute('DateOut')) - strtotime($orderItem->getItemAttribute('DateIn'))) / (24*60*60);
$info = $usersFullData[$orderItem->Owner->RunetId];
$together = isset($usersTogether[$orderItem->Owner->RunetId]) ? $usersTogether[$orderItem->Owner->RunetId] : [];
?>
<td rowspan="<?=intval($days);?>">
  <?if ($orderItem->Paid):?>
    <span class="label label-success">оплачен</span>
  <?else:?>
    <span class="label label-warning">забронирован</span>
  <?endif;?>
</td>
<td rowspan="<?=intval($days);?>">
  <?=$info['lastName'];?> <?=$info['firstName'];?> <?=$info['fatherName'];?>, <?=$info['birthDate'];?><br>
  <?=$info['series'];?> <?=$info['number'];?>, <?=$info['issuedBy'];?> <?=$info['issueDate'];?><br>
  <?=$info['registrationAddress'];?>

  <?if (!empty($together)):?>
  <br>
  <?foreach ($together as $name):?>
      <br><?=$name;?>
  <?endforeach;?>
  <?endif;?>

</td>