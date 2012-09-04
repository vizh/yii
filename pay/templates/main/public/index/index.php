<?
/** @var $items OrderItem[] */
$newItems = $this->NewItems;
/** @var $paidItems OrderItem[] */
$paidItems = $this->PaidItems;
/** @var $orders Order[] */
$orders = $this->Orders;
?>

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

  <div class="response">
    <a href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId));?>">Оплатить картой или эл. деньгами</a>

    <a href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId, 'type' => 'paypal'));?>">
      Оплатить через <i
      style="
        background: url('/images/paypal.png') no-repeat scroll 0 0 transparent;
        display: inline-block;
        width: 60px;
        height: 25px;
        vertical-align: text-top;
        margin: 2px 0 0 3px;
        "></i>
    </a>

    <?if ($this->EventId != 106 && $this->EventId != 252 && $this->EventId != 236 && $this->EventId != 245 && $this->EventId != 258):?>
    <a href="<?=RouteRegistry::GetUrl('main', '', 'juridical', array('eventId' => $this->EventId));?>">Выставить счет (для юр. лиц)</a>
    <?endif;?>
    <div class="clear"></div>

    <?if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1')://'82.142.129.35'):?>
    <a style="width: 400px;" href="<?=RouteRegistry::GetUrl('main', '', 'pay', array('eventId' => $this->EventId,  'type' => 'uniteller'));?>">Оплатить картой или эл. деньгами через Uniteller</a>
    <div class="clear"></div>
    <?endif;?>

  </div>

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