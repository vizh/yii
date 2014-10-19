<?php
namespace pay\components;

class OrderItemCollectable
{
  /**
   * @var \pay\models\OrderItem
   */
  private $orderItem;

  /**
   * @var OrderItemCollection
   */
  private $collection;

  function __construct(\pay\models\OrderItem $orderItem, OrderItemCollection $collection)
  {
    $this->orderItem = $orderItem;
    $this->collection = $collection;
  }

  public function getOrderItem()
  {
    return $this->orderItem;
  }

  /**
   * Итоговое значение цены товара, с учетом скидки, если она есть
   * @throws MessageException
   * @return int|null
   */
  public function getPriceDiscount()
  {
    $price = $this->orderItem->getPrice();
    if ($price === null) {
        throw new MessageException('Не удалось определить цену продукта!');
    }

    $price = $price * (1 - $this->getDiscount());
    return (int)round($price);
  }

  private $discount = null;

  public function getDiscount()
  {
    if ($this->discount === null)
    {
      if ($this->orderItem->Product->EnableCoupon || $this->orderItem->Owner->hasLoyaltyDiscount())
      {
        $activation = $this->orderItem->getCouponActivation();
        if ($activation !== null)
        {
          $this->discount = $activation->Coupon->Discount;
        }

        $loyaltyDiscount = $this->orderItem->getLoyaltyDiscount();
        if ($loyaltyDiscount && $loyaltyDiscount->Discount > $this->discount)
        {
          $this->discount = $loyaltyDiscount->Discount;
        }

        if ($this->collection->getDiscount() > $this->discount)
        {
          $this->discount = $this->collection->getDiscount();
        }
      }
      else
      {
        $this->discount = 0;
      }
    }
    return $this->discount;
  }

  private $isGroupDiscount = null;

  public function getIsGroupDiscount()
  {
    if ($this->isGroupDiscount === null)
    {
      if ($this->orderItem->Product->EnableCoupon && $this->collection->getDiscount() > 0)
      {
        $activation = $this->orderItem->getCouponActivation();
        $this->isGroupDiscount = $activation == null || !($activation->Coupon->Discount > $this->collection->getDiscount());
      }
      else
      {
        $this->isGroupDiscount = false;
      }
    }

    return $this->isGroupDiscount;
  }
}