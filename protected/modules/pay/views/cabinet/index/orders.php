<?php
/**
 * @var $this CabinetController
 * @var $orders \pay\models\Order[]
 */
?>
<table class="table">
  <thead>
  <tr>
    <th colspan="4"><h4 class="title"><?=\Yii::t('app', 'Выставленные счета');?></h4></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($orders as $order):?>
    <tr>
      <td style="padding-left: 10px; width: 15px;">
        <?if (!$order->Paid):?>
        <a href="<?=$this->createUrl('/pay/juridical/delete', array('orderId' => $order->Id));?>"><i class="icon-trash"></i></a>
        <?endif;?>
      </td>
      <td><?=\Yii::t('app', 'Счет');?> № <?=$order->Id;?> <?=\Yii::t('app', 'от');?> <?=\Yii::app()->dateFormatter->format('d MMMM yyyy', $order->CreationTime);?>


      </td>

      <td>
        <?if ($order->Paid):?>
          <span class="label label-success"><?=Yii::t('app', 'Оплачен');?></span>
        <?endif;?>
      </td>

      <td><a target="_blank" href="<?=\Yii::app()->createUrl('/pay/order/index', array('orderId' => $order->Id, 'hash' => $order->getHash()));?>"><?=\Yii::t('app', 'Просмотреть счет');?></a></td>
    </tr>
  <?php endforeach;?>
  </tbody>
</table>