<?php
namespace pay\components\collection;

interface ICoupon
{
  /**
   * @param \pay\components\OrderItemCollection $collection
   *
   * @return float
   */
  public function getDiscount(\pay\components\OrderItemCollection $collection);
}