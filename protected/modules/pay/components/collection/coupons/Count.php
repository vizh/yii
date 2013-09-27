<?php
namespace pay\components\collection\coupons;

/**
 * Class Count
 * @package pay\components\collection\coupons
 *
 * @property int $Minimum
 * @property string $Products
 */
class Count extends Base
{

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  protected function getCouponAttributeNames()
  {
    return ['Minimum', 'Products'];
  }

  /**
   * @param \pay\components\OrderItemCollection|\pay\components\OrderItemCollectable[] $collection
   *
   * @return float
   */
  public function getDiscount(\pay\components\OrderItemCollection $collection)
  {
    $userIdList = [];
    $products = preg_split('/[ ,]/', $this->Products, -1, PREG_SPLIT_NO_EMPTY);
    array_walk($products, function(&$product) {
      $product = intval($product);
    });
    foreach ($collection as $item)
    {
      if (in_array($item->getOrderItem()->ProductId, $products))
      {
        $userIdList[] = $item->getOrderItem()->OwnerId;
      }
    }
    $userIdList = array_unique($userIdList);
    $count = sizeof($userIdList);
    return $count >= $this->Minimum ? $this->coupon->Discount : 0;
  }
}