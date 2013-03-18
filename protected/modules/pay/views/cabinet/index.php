<?php
/**
 * @var $paidItems \pay\models\OrderItem[]
 * @var $recentPaidItems \pay\models\OrderItem[]
 */
?>


  <style>.b-event-promo .side, .b-event-promo .all {display: none;}</style>






  <div class="event-register">
    <div class="container">

      <div class="tabs clearfix">
        <div class="tab pull-left">
          <span class="number img-circle">1</span>
          <?=\Yii::t('mblt2013', 'Регистрация');?>
        </div>
        <div class="tab current pull-left">
          <span class="number img-circle">2</span>
          <?=\Yii::t('mblt2013', 'Оплата');?>
        </div>
      </div>

      <?php if (!empty($order)):?>
        <table class="table thead-actual">
          <thead>
          <tr>
            <th><?=\Yii::t('mblt2013', 'Тип билета');?></th>
            <th class="col-width t-right"><?=\Yii::t('mblt2013', 'Цена');?></th>
            <th class="col-width t-right"><?=\Yii::t('mblt2013', 'Кол-во');?></th>
            <th class="col-width t-right last-child"><?=\Yii::t('mblt2013', 'Сумма');?></th>
          </tr>
          </thead>
        </table>
        <?php $total = 0;?>
        <?php foreach ($order as $product):?>
          <table class="table">
            <thead>
            <tr>
              <th colspan="2"><h4 class="title"><?=\Yii::t('mblt2013', $product->Product->Title);?> <i class="icon-chevron-up"></i></h4></th>
              <th class="col-width t-right"><span class="number"><?php echo $product->Product->GetPrice();?></span> Р</th>
              <th class="col-width t-right"><b class="number"><?php echo count($product->Items);?></b></th>
              <th class="col-width t-right last-child"><b class="number"><?php echo $product->Product->GetPrice() * count($product->Items);?></b> Р</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($product->Items as $item):?>
              <?php $total += $item->OrderItem->PriceDiscount();?>
              <tr>
                <td style="padding-left: 10px; width: 15px;">
                  <a href="<?php echo $this->createUrl('/runetid2/pay/orderitems', array('action' => 'deleteOrderItem', 'orderItemId' => $item->OrderItem->OrderItemId, 'eventId' => $event->Id));?>"><i class="icon-trash"></i></a>
                </td>
                <td>
                  <?php echo $item->OrderItem->Owner->GetFullName();?>
                  <?php if($item->OrderItem->ProductId== 731):
                    $secondOwner = user\models\User::model()->findByPk($item->OrderItem->GetParam('SecondUserId')->Value);
                    echo ' + '.$secondOwner->GetFullName();
                  endif;?>
                </td>
                <td colspan="3" class="t-right muted last-child">
                  <?php if ($item->Coupon !== null && $item->Coupon->Discount > 0):?>
                    <?=\Yii::t('mblt2013', 'Промо-код');?> <?php echo $item->Coupon->Code;?>: <b class="number">-<?php echo $product->Product->GetPrice() * $item->Coupon->Discount;?></b> Р
                  <?php endif;?>
                </td>
              </tr>
            <?php endforeach;?>
            </tbody>
          </table>
        <?php endforeach;?>

        <div class="total">
          <span><?=\Yii::t('mblt2013', 'Итого');?>:</span> <b class="number"><?php echo \Yii::app()->numberFormatter->format('#,##0.00', $total);?></b> Р
        </div>

        <div style="width: 500px; margin: 0 auto; margin-bottom: 40px;">
          <label class="checkbox">
            <input type="checkbox" name="agreeOffer" value="1"/><?=\Yii::t('mblt2013', 'Я согласен с условиями <a href="{url}">договора-оферты</a> и готов перейти к оплате', array('{url}' => $this->createUrl('/runetid2/pay/offer', array('eventId' => $event->Id))));?>
          </label>
        </div>
        <div class="actions clearfix">
          <a href="<?php echo $this->createUrl('/runetid2/pay/owners', array('eventId' => $event->Id));?>" class="btn btn-large">
            <i class="icon-circle-arrow-left"></i>
            <?=\Yii::t('mblt2013', 'Назад');?>
          </a>
          <a href="http://pay.rocid.ru/main/pay/<?php echo $event->Id;?>/uniteller/" class="btn btn-large btn-primary"><?=\Yii::t('mblt2013', 'Оплатить картой или эл. деньгами');?></a>
          <a href="http://pay.rocid.ru/main/pay/<?php echo $event->Id;?>/paypal/" class="btn btn-large btn-primary paypal"><?=\Yii::t('mblt2013', 'Оплатить через');?> <img src="/modules<?php echo $this->layout;?>/images/logo-paypal.png" alt=""></a>
          <a href="<?php echo $this->createUrl('/runetid2/pay/juridical/', array('eventId' => $event->Id));?>" class="btn btn-large"><?=\Yii::t('mblt2013', 'Выставить счет');?> <span class="muted"><?=\Yii::t('mblt2013', '(для юр. лиц)');?></span></a>
        </div>
      <?php else:?>
        <style type="text/css">
          .event-register .alert {
            margin: 0 40px 40px;
          }
        </style>
        <?if (empty($recentPaidItems)):?>
          <div class="alert alert-error"><?=\Yii::t('mblt2013', 'У вас нет товаров для оплаты.');?></div>
        <?else:?>
          <div class="alert alert-success"><?=\Yii::t('mblt2013', 'Вы недавно оплатили участие или активировали промо-код. Список оплаченых товаров можно посмотреть ниже.');?></div>
        <?endif;?>

        <div class="actions">
          <a href="<?php echo $this->createUrl('/runetid2/pay/owners', array('eventId' => $event->Id));?>" class="btn btn-large">
            <i class="icon-circle-arrow-left"></i>
            Назад
          </a>
        </div>
      <?php endif;?>
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
