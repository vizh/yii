<?
/** @var $items OrderItem[] */
$newItems = $this->NewItems;
/** @var $paidItems OrderItem[] */
$paidItems = $this->PaidItems;
/** @var $orders Order[] */
$orders = $this->Orders;
?>

<style type="text/css">
  .pay-systems{
    margin-top: 20px;
  }

  .pay-systems a{

  }

  .pay-systems a i{
    display: inline-block;
    vertical-align: text-top;
  }
  .pay-systems a.payonline i{
    background: url('/images/payonline.png') no-repeat scroll 0 0 transparent;
    width: 96px;
    height: 20px;
    margin: 0 0 0 3px;
  }
  .pay-systems a.paypal i{
    background: url('/images/paypal.png') no-repeat scroll 0 0 transparent;
    width: 60px;
    height: 25px;
    margin: 2px 0 0 3px;
  }
  .pay-systems a.uniteller i{
    background: url('/images/uniteller.png') no-repeat scroll 0 0 transparent;
    width: 85px;
    height: 25px;
    margin: -5px 0 0 3px;
  }
  .pay-systems a.uniteller2 i{
    background: url('/images/uniteller2.png') no-repeat scroll 0 0 transparent;
    width: 132px;
    height: 25px;
    margin: -5px 0 0 3px;
  }

  .pay-system-list{
    width: 230px;
    display: inline-block;
    float: left;
  }
  .pay-system-list span{
    display: block;
    float: left;
    width: 52px;
    height: 35px;
    margin: 0 4px 4px 0;
  }
  .pay-system-list span.visa{
    background: url('/images/pay-icons/visa.gif') no-repeat scroll 0 0 transparent;
  }
  .pay-system-list span.mastercard{
    background: url('/images/pay-icons/mastercard.gif') no-repeat scroll 0 0 transparent;

  }
  .pay-system-list span.yandexmoney{
    background: url('/images/pay-icons/yandexmoney.gif') no-repeat scroll 0 0 transparent;

  }
  .pay-system-list span.webmoney{
    background: url('/images/pay-icons/webmoney.gif') no-repeat scroll 0 0 transparent;
    width: 88px;
    height: 31px;
  }
  .pay-system-list span.qiwi{
    background: url('/images/pay-icons/terminalsqiwi.gif') no-repeat scroll 0 0 transparent;

  }
</style>

<div class="content pay">
  <?if (!empty($newItems)):?>
  <table>
    <tr>
      <th class="product">Наименование услуги</th>
      <th class="user">Получатель</th>
      <th class="price">Цена</th>
      <th class="delete"></th>
    </tr>
    <?foreach ($newItems as $item):
    if ($item->Paid == 1) { continue; }
    ?>
    <tr>
      <td class="product"><?=$item->Product->ProductManager()->GetTitle($item);?><br>
        <?if ($item->Booked != null):?>
          <span class="warning">Внимание! Окончание брони этой услуги <?=date('d.m.Y', strtotime($item->Booked));?> в <?=date('H:i', strtotime($item->Booked));?>. Необходимо оплатить до этого срока.</span>
          <?endif;?>
      </td>
      <td class="user"><?=$item->Owner->FirstName;?> <?=$item->Owner->LastName;?> (rocID: <?=$item->Owner->RocId;?>)</td>
      <td class="price"><?=number_format($item->PriceDiscount(), 0, '.', ' ');?> <?='руб.';?></td>
      <td class="delete"><a onclick="return confirm('Удалить услугу?');" href="<?=RouteRegistry::GetUrl('main', '', 'delete', array('ItemId' => $item->OrderItemId));?>">Удалить</a></td>
    </tr>
    <?endforeach;?>

    <tr class="last">
      <td colspan="2"></td>
      <td class="price">Итого:<br><strong><?=number_format($this->Total, 0, '.', ' ');?> <?='руб.';?></strong></td>
      <td class="delete"></td>
    </tr>
  </table>

  <div class="response pay-systems">

    <?if ($this->EventId == 215):?>
    <a class="uniteller" href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId,  'type' => 'uniteller'));?>">Оплатить через <i></i></a>

    <div class="pay-system-list">
      <span class="visa"></span>
      <span class="mastercard"></span>
      <span class="yandexmoney"></span>
      <div class="clear"></div>
      <span class="webmoney"></span>
      <span class="qiwi"></span>
      <div class="clear"></div>
    </div>
    <?else:?>
    <a class="payonline" href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId));?>">Оплатить через <i></i></a>

    <div class="pay-system-list">
      <span class="visa"></span>
      <span class="mastercard"></span>
      <div class="clear"></div>
      <span class="webmoney"></span>
      <!--<span class="qiwi"></span>-->
      <div class="clear"></div>
    </div>
    <?endif;?>


    <a class="paypal" href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId, 'type' => 'paypal'));?>">Оплатить через <i></i></a>

    <div class="hLine"></div>

  <?if ($this->EventId == 215):?>
    <a class="payonline" href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId));?>">Оплатить через <i></i></a>

    <div class="pay-system-list">
      <span class="visa"></span>
      <span class="mastercard"></span>
      <div class="clear"></div>
      <span class="webmoney"></span>
      <!--<span class="qiwi"></span>-->
      <div class="clear"></div>
    </div>
  <?endif;?>

    <?if ($this->EventId != 106 && $this->EventId != 252 && $this->EventId != 236 && $this->EventId != 245 && $this->EventId != 258 && $this->EventId != 363 && $this->EventId != 364):?>
    <a href="<?=RouteRegistry::GetUrl('main', '', 'juridical', array('eventId' => $this->EventId));?>">Выставить счет (для юр. лиц)</a>
    <?endif;?>


  </div>

    <div class="clear"></div>

  <?else:?>
  <h3>У вас нет товаров для оплаты.</h3>
  <?endif;?>

  <div class="hLine"></div>
  <?if (! empty($this->Orders)):?>
  <h3>Выставленные счета.</h3>
  <table>
    <tr>
      <th class="product">Данные счета</th>
      <th class="user"></th>
      <th class="price">Сумма счета</th>
      <th class="delete"></th>
    </tr>
    <?foreach ($orders as $order):
    $total = 0;
    $min = '9999-01-01 00:00:00';
    $booked = false;
    $deleted = false;
    foreach ($order->Items as $item)
    {
      if ($item->Deleted != 0)
      {
        $deleted = true;
        continue;
      }

      $total += $item->PriceDiscount($order->CreationTime);
      if ($item->Booked != null)
      {
        $min = $min < $item->Booked ? $min : $item->Booked;
        $booked = true;
      }
    }
    ?>
    <tr>
      <td class="product">Счет № <?=$order->OrderId;?> от  <?=date('d.m.Y', strtotime($order->CreationTime));?><br>
        <?if ($booked):?>
          <span class="warning">Внимание! В счет включена услуга с окончанием брони <?=date('d.m.Y', strtotime($min));?> в <?=date('H:i', strtotime($min));?>. Необходимо оплатить до этого срока.</span>
          <?endif;?>
        <?if ($deleted):?>
          <span class="warning">Внимание! Из счета удалены услуги с истекшим сроком бронирования. Если вы еще не оплатили счет, распечатайте его повторно..</span>
          <?endif;?>
      </td>
      <td class="user"><a target="_blank" href="<?=RouteRegistry::GetUrl('main', 'juridical', 'order', array('orderId' => $order->OrderId));?>">Просмотреть счет</a></td>
      <td class="price"><?=number_format($total, 0, '.', ' ');?> <?='руб.';?></td>
      <td class="delete"><a onclick="return confirm('Вы действительно хотите удалить счет № <?=$order->OrderId;?>?');" href="<?=RouteRegistry::GetUrl('main', 'juridical', 'delete', array('orderId' => $order->OrderId));?>">Удалить</a></td>
    </tr>
    <?endforeach;?>
    <tr>
      <td colspan="3"></td>
      <td class="delete"></td>
    </tr>
  </table>

  <div class="hLine"></div>
  <?endif;?>

  <?if (!empty($paidItems)):?>
  <h3>Оплачено ранее</h3>
  <table>
    <tr>
      <th class="product">Наименование услуги</th>
      <th class="user">Получатель</th>
      <th class="price">Цена</th>
      <th class="delete"></th>
    </tr>
    <?foreach ($paidItems as $item):
    if ($item->Paid == 0) { continue; }
    ?>
    <tr>
      <td class="product"><?=$item->Product->ProductManager()->GetTitle($item);?></td>
      <td class="user"><?=$item->Owner->FirstName;?> <?=$item->Owner->LastName;?> (rocID: <?=$item->Owner->RocId;?>)</td>
      <td class="price"><?=number_format($item->PriceDiscount(), 0, '.', ' ');?> <?='руб.';?></td>
      <td class="delete"></td>
    </tr>
    <?endforeach;?>
    <tr>
      <td colspan="3"></td>
      <td class="delete"></td>
    </tr>
  </table>

  <?endif;?>
</div>