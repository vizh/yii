<?php
/**
 * @var $products \pay\models\Product[]
 * @var $unpaidItems \pay\models\OrderItem[]
 * @var $paidItems \pay\models\OrderItem[]
 * @var $recentPaidItems \pay\models\OrderItem[]
 *
 * @var $this \pay\components\Controller
 */
?>


<style>.b-event-promo .side, .b-event-promo .all {display: none;}</style>



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

    <?$this->renderPartial('index/unpaidItems', array(/*'products' => $products, */'unpaidItems' => $unpaidItems, 'hasRecentPaidItems' => (sizeof($recentPaidItems) > 0)));?>





    <?php if (!empty($juridicalOrders)):?>
      <table class="table">
        <thead>
        <tr>
          <th colspan="3"><h4 class="title"><?=\Yii::t('mblt2013', 'Выставленные счета');?></h4></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($juridicalOrders as $order):?>
          <tr>
            <td style="padding-left: 10px; width: 15px;">
              <a href="<?php echo $this->createUrl('/runetid2/pay/orderitems', array('action' => 'deleteOrderJuridical', 'orderId' => $order->OrderId, 'eventId' => $event->Id));?>"><i class="icon-trash"></i></a>
            </td>
            <td><?=\Yii::t('mblt2013', 'Счет');?> № <?=$order->OrderId;?> <?=\Yii::t('mblt2013', 'от');?> <?php echo \Yii::app()->dateFormatter->format('d MMMM yyyy', $order->CreationTime);?></td>
            <td><a target="_blank" href="http://pay.rocid.ru/main/juridical/order/<?php echo $order->OrderId;?>"><?=\Yii::t('mblt2013', 'Просмотреть счет');?></a></td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
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
