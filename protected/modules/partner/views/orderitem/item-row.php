<?php
/**
 * @var $orderItem \pay\models\OrderItem
 * @var $this \partner\components\Controller
 */
?>
<tr>
  <td><?=$orderItem->Id;?></td>
  <td><small><?=$orderItem->CreationTime?></small></td>
  <td><?=$orderItem->Product->Title;?></td>
  <td>
    <?=$orderItem->getPriceDiscount();?>&nbsp;руб.<br/>
    <?if ($orderItem->Paid):?>
      <span class="label label-success">Оплачен</span>
    <?else:?>
      <span class="label">Не оплачен</span>
    <?endif;?>

    <?if ($orderItem->Deleted):?>
      <span class="label label-warning">Удален</span>
    <?endif;?>
  </td>
  <td>
    <?$system = $orderItem->getPaidSystem();?>
    <?if ($system !== null):?>
      <?if ($system == 'Juridical'):?>
        <span class="text-info">Юр. счет</span>
      <?elseif (strpos($system, 'pay\components\systems\\') !== false):?>
        <span class="text-warning"><?=str_replace('pay\components\systems\\', '', $system);?></span>
      <?else:?>
        <span class="muted">Не задан</span>
      <?endif;?>
    <?else:?>
      <span class="muted">Не задан</span>
    <?endif;?>
  </td>
  <td>
    <?=$orderItem->Payer->RunetId;?>, <strong><?=$orderItem->Payer->getFullName();?></strong>
    <p><em><?=$orderItem->Payer->Email;?></em></p>
  </td>
  <td>
    <?=$orderItem->Owner->RunetId;?>, <strong><?=$orderItem->Owner->getFullName();?></strong>
    <p><em><?=$orderItem->Owner->Email;?></em></p>

    <?if ($orderItem->ChangedOwner !== null):?>
      <p class="text-success"><strong>Перенесено на пользователя</strong></p>
      <?=$orderItem->ChangedOwner->RunetId;?>, <strong><?=$orderItem->ChangedOwner->getFullName();?></strong>
      <p><em><?=$orderItem->ChangedOwner->Email; ?></em></p>
    <?endif;?>
  </td>
  <td>
    <?if ($orderItem->Paid):?>
      <a href="<?=Yii::app()->createUrl('/partner/orderitem/redirect', array('orderItemId' => $orderItem->Id));?>" class="btn btn-mini">Перенести</a>
    <?endif;?>
  </td>
</tr>