<?php
namespace pay\components\collection;

interface ICoupon
{
    /**
     * @param \pay\components\OrderItemCollection|\pay\components\OrderItemCollectable[] $collection
     *
     * @return float
     */
    public function getDiscount(\pay\components\OrderItemCollection $collection);
}