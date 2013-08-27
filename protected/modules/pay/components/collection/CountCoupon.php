<?php
namespace pay\components\collection;


class CountCoupon implements ICoupon
{

  /**
   * @param \pay\components\OrderItemCollection|\pay\components\OrderItemCollectable[] $collection
   *
   * @return float
   */
  public function getDiscount(\pay\components\OrderItemCollection $collection)
  {
    $userIdList = [];
    $products = [1370, 1371, 1372, 1373, 1379, 1380];
    foreach ($collection as $item)
    {
      if (in_array($item->getOrderItem()->ProductId, $products))
      {
        $userIdList[] = $item->getOrderItem()->OwnerId;
      }
    }
    $userIdList = array_unique($userIdList);
    $count = sizeof($userIdList);
    if ($count > 9)
    {
      return 0.15;
    }
    elseif ($count >= 2)
    {
      return 0.1;
    }
    else
    {
      return 0;
    }
  }
}