<?php
/**
 * @var $unpaidItems \pay\models\OrderItem[]
 * @var $paidItems \pay\models\OrderItem[]
 * @var $recentPaidItems \pay\models\OrderItem[]
 * @var $orders \pay\models\Order[]
 *
 * @var $this \pay\components\Controller
 */
?>


<div class="event-register" data-event-idname="<?=$this->getEvent()->IdName;?>">
  <div class="container">

    <div class="tabs clearfix">
      <div class="tab pull-left">
        <span class="number img-circle">1</span>
        <?=\Yii::t('pay', 'Регистрация');?>
      </div>
      <div class="tab current pull-left">
        <span class="number img-circle">2</span>
        <?=\Yii::t('pay', 'Оплата');?>
      </div>
    </div>

    <?$this->renderPartial('index/unpaidItems', array('unpaidItems' => $unpaidItems, 'hasRecentPaidItems' => (sizeof($recentPaidItems) > 0)));?>

    <?php if (sizeof($orders) > 0):?>
      <?$this->renderPartial('index/orders', array('orders' => $orders));?>
    <?php endif;?>
  </div>

  <div class="container" style="margin-top: 30px;">
    <?if (!empty($recentPaidItems) || !empty($paidItems)):
      $paidItems = array_merge($recentPaidItems, $paidItems);
      ?>
      <table class="table">
        <thead>
        <tr>
          <th colspan="4"><h4 class="title"><?=\Yii::t('mblt2013', 'Оплаченные товары');?></h4></th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($paidItems as $item):?>
          <tr>
            <td>
              <?=$item->Owner->GetFullName();?>
              <?php if($item->ProductId == 731):
                $secondOwner = user\models\User::model()->findByPk($item->GetParam('SecondUserId')->Value);
                echo ' + '.$secondOwner->GetFullName();
              endif;?>
            </td>
            <td><?=\Yii::t('mblt2013', $item->Product->Title);?></td>
            <td><?=\Yii::app()->getLocale()->getDateFormatter()->format('d MMMM yyyy г., H:mm', $item->PaidTime)?></td>
            <td><?=$item->PriceDiscount() == 0 ? \Yii::t('mblt2013', 'Бесплатно') : $item->PriceDiscount() . ' '.\Yii::t('mblt2013', 'руб').'.';?> </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
    <?endif;?>
  </div>
</div>
