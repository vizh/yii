<?php
/**
 * @var $this CabinetController
 * @var $orders \pay\models\Order[]
 */
?>
<table class="table">
  <thead>
  <tr>
    <th colspan="3"><h4 class="title"><?=\Yii::t('pay', 'Выставленные счета');?></h4></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($orders as $order):?>
    <tr>
      <td style="padding-left: 10px; width: 15px;">
        <a href="<?=$this->createUrl('/pay/juridical/delete', array('orderId' => $order->Id));?>"><i class="icon-trash"></i></a>
      </td>
      <td><?=\Yii::t('pay', 'Счет');?> № <?=$order->Id;?> <?=\Yii::t('pay', 'от');?> <?=\Yii::app()->dateFormatter->format('d MMMM yyyy', $order->CreationTime);?></td>
      <td><a target="_blank" href="<?=\Yii::app()->createUrl('/pay/juridical/order', array('orderId' => $order->Id));?>"><?=\Yii::t('pay', 'Просмотреть счет');?></a></td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>