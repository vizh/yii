<div class="btn-toolbar"></div>
<div class="well">
  <h2>Партнер: <?=$owner;?></h2>
  <?if (!empty($orders)):?>
    <h3><?=\Yii::t('app', 'Счета');?></h3>
    <table class="table">
      <thead>
        <th><?=\Yii::t('app', 'Кол-во номеров');?></th>
        <th><?=\Yii::t('app', 'Сумма');?></th>
        <th><?=\Yii::t('app', 'Статус');?></th>
        <th></th>
      </thead>
      <tbody>
        <?foreach ($orders as $order):?>
          <tr>
            <td><?=\Yii::t('app', '{n} номер|{n} номера|{n} номеров|{n} номеров', sizeof($order->Bookings));?></td>
            <td><?=$order->getTotalPrice();?> <?=\Yii::t('app', 'руб');?>.</td>
            <td>
              <?if ($order->Paid):?>
                <span class="text-success"><?=\Yii::t('app', 'Оплачен');?></span>
              <?else:?>
                <span class="muted"><?=\Yii::t('app', 'Не оплачен');?></span>
              <?endif;?>
            </td>
            <td style="text-align: right;">
              <div class="btn-group">
                <a href="<?=$this->createUrl('/pay/admin/booking/order', ['owner' => $owner, 'orderId' => $order->Id]);?>" class="btn"><?=\Yii::t('app', !$order->Paid ? 'Редактировать' : 'Просмотреть');?></a>
                <a href="<?=$this->createUrl('/pay/admin/booking/order', ['owner' => $owner, 'orderId' => $order->Id, 'print' => 1]);?>" target="_blank" class="btn">Счет для печати</a>
                <?if (!$order->Paid):?>
                  <a href="<?=$this->createUrl('/pay/admin/booking/partner/', ['owner' => $owner, 'action' => 'activate', 'orderId' => $order->Id]);?>" class="btn"><?=\Yii::t('app', 'Отметить оплаченным');?></a>
                  <a href="<?=$this->createUrl('/pay/admin/booking/partner/', ['owner' => $owner, 'action' => 'delete', 'orderId' => $order->Id]);?>" class="btn btn-danger"><?=\Yii::t('app', 'Удалить');?></a>
                <?endif;?>
              </div>
            </td>
          </tr>
        <?endforeach;?>
      </tbody>
    </table>
  <?endif;?>

  <?if (!empty($bookings)):?>
    <h3><?=\Yii::t('app', 'Номера без счета');?></h3>
    <form method="GET" class="bookings" action="<?=$this->createUrl('/pay/admin/booking/order');?>">
      <?=\CHtml::hiddenField('owner', $owner);?>
      <table class="table">
        <thead>
          <th><?=\Yii::t('app', 'Заказ');?></th>
          <th></th>
        </thead>
        <?foreach ($bookings as $booking):?>
          <?$manager = $booking->Product->getManager();
          $price = $manager->Price * $booking->getStayDay();
          ?>
          <tr>
            <td style="width: 1px;"><?=\CHtml::checkBox('bookingIdList[]', false, ['value' => $booking->Id]);?></td>
            <td><?=$manager->Hotel;?>, <?=$manager->Housing;?>, №<?=$manager->Number;?></td>
            <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $booking->DateIn);?></td>
            <td><?=\Yii::app()->getDateFormatter()->format('dd MMMM yyyy', $booking->DateOut);?></td>
            <td><span class="label"><?=$price;?> <?=\Yii::t('app', 'руб');?></span></td>
          </tr>
        <?endforeach;?>
      </table>
      <?=\CHtml::submitButton(\Yii::t('app', 'Выставить счет'), ['class' => 'btn btn-success hide']);?>
    </form>
  <?endif;?>
</div>