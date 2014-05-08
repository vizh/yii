<?php
/**
 * @var $this \pay\components\Controller
 * @var $paidCollections \pay\components\OrderItemCollection[]
 */
?>
<table class="table">
  <thead>
  <tr>
    <th colspan="4"><h4 class="title"><?=\Yii::t('app', 'Оплаченные товары');?></h4></th>
  </tr>
  </thead>
  <tbody>

  <?foreach ($paidCollections as $collection):?>
    <?foreach ($collection as $item):?>
      <?/** @var $item \pay\components\OrderItemCollectable */?>
      <tr>
        <td>
          <?=$item->getOrderItem()->Owner->getFullName();?> (<?=$item->getOrderItem()->Id;?>)
        </td>
        <td><?=\Yii::t('app', $item->getOrderItem()->Product->Title);?></td>
        <td><?=\Yii::app()->getLocale()->getDateFormatter()->format('d MMMM yyyy г., H:mm', $item->getOrderItem()->PaidTime)?></td>
        <td><?=$item->getPriceDiscount() == 0 ? \Yii::t('app', 'Бесплатно') : $item->getPriceDiscount() . ' '.\Yii::t('app', 'руб').'.';?> </td>
      </tr>
    <?endforeach;?>
  <?endforeach;?>
  </tbody>
</table>
