<?php
/**
 * @var \pay\models\Product $product
 * @var \pay\models\OrderItem[] $orderItems
 * @var array $usersFullData
 * @var array $usersTogether
 * @var \pay\models\RoomPartnerBooking[] $partnerBookings
 */

/** @var \pay\components\managers\RoomProductManager $manager */
$manager = $product->getManager();
$usedItems = [];
$usedBookings = [];

$dates = [
  ['dateIn' => '2014-04-22', 'dateOut' => '2014-04-23'],
  ['dateIn' => '2014-04-23', 'dateOut' => '2014-04-24'],
  ['dateIn' => '2014-04-24', 'dateOut' => '2014-04-25'],
];


if (!function_exists('getOrderItemByDate'))
{
  /**
   * @param \pay\models\OrderItem[] $orderItems
   * @param string $dateIn
   * @return null|\pay\models\OrderItem
   */
  function getOrderItemByDate($orderItems, $dateIn)
  {
    foreach ($orderItems as $item)
    {
      if ($item->getItemAttribute('DateIn') <= $dateIn && $dateIn < $item->getItemAttribute('DateOut'))
      {
        return $item;
      }
    }
    return null;
  }
}

if (!function_exists('getPartnerBookingByDate')) {
  /**
   * @param \pay\models\RoomPartnerBooking[] $partnerBookings
   * @param string $dateIn
   * @return null|\pay\models\RoomPartnerBooking
   */
  function getPartnerBookingByDate($partnerBookings, $dateIn)
  {
    foreach ($partnerBookings as $booking)
    {
      if ($booking->DateIn <= $dateIn && $dateIn < $booking->DateOut)
      {
        return $booking;
      }
    }
    return null;
  }
}

$first = true;
?>
<?foreach ($dates as $date):?>
  <tr>
    <?if ($first): $first = false;?>
      <td rowspan="3">
        <strong>Номер: <?=$manager->Number;?></strong> <span class="muted">(Id: <?=$product->Id;?>)</span><br>
        <?=$manager->Housing;?>, <?=$manager->Category;?><br>
        Всего мест: <?=$manager->PlaceTotal;?> (основных - <?=$manager->PlaceBasic;?>, доп. - <?=$manager->PlaceMore;?>)<br>
        <em><?=$manager->DescriptionBasic;?>, <?=$manager->DescriptionMore;?></em>
      </td>
    <?endif;?>

    <td><?=date('d.m', strtotime($date['dateIn']));?> - <?=date('d.m', strtotime($date['dateOut']));?></td>

    <?
    $orderItem = getOrderItemByDate($orderItems, $date['dateIn']);
    $partnerBooking = getPartnerBookingByDate($partnerBookings, $date['dateIn']);
    ?>
    <?if ($orderItem == null && $partnerBooking == null):?>
      <td><span class="label">свободен</span></td>
      <td>&nbsp;</td>
    <?elseif ($orderItem != null && !in_array($orderItem->Id, $usedItems)): $usedItems[] = $orderItem->Id;?>
      <?$this->renderPartial('statistics/info', [
        'orderItem' => $orderItem,
        'usersFullData' => $usersFullData,
        'usersTogether' => $usersTogether
      ]);?>
    <?elseif ($partnerBooking != null && !in_array($partnerBooking->Id, $usedBookings)): $usedBookings[] = $partnerBooking->Id;?>
      <?$this->renderPartial('statistics/infoBooking', [
        'partnerBooking' => $partnerBooking
      ]);?>
    <?endif;?>
  </tr>
<?endforeach;?>