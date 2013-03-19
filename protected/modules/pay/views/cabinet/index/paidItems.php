<?php
/**
 * @var $this \pay\components\Controller
 * @var $paidItems \pay\models\OrderItem[]
 */
?>
<div class="container" style="margin-top: 30px;">
  <table class="table">
    <thead>
    <tr>
      <th colspan="4"><h4 class="title"><?=\Yii::t('pay', 'Оплаченные товары');?></h4></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($paidItems as $item):?>
      <tr>
        <td>
          <?=$item->Owner->getFullName();?>
        </td>
        <td><?=\Yii::t('pay', $item->Product->Title);?></td>
        <td><?=\Yii::app()->getLocale()->getDateFormatter()->format('d MMMM yyyy г., H:mm', $item->PaidTime)?></td>
        <td><?=$item->getPriceDiscount() == 0 ? \Yii::t('pay', 'Бесплатно') : $item->getPriceDiscount() . ' '.\Yii::t('pay', 'руб').'.';?> </td>
      </tr>
    <?php endforeach;?>
    </tbody>
  </table>
</div>
