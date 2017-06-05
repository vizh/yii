<?php
namespace pay\components\coupon\collection\managers;

use pay\components\OrderItemCollection;

/**
 * Class Count
 * @package pay\components\collection\coupons
 *
 * @property int $Minimum
 * @property string $Products
 */
class CountFix extends Count
{
    /**
     * @inheritdoc
     */
    public function getDiscount(OrderItemCollection $collection)
    {
        $count = count($this->getUniqueOwnerIdList($collection));
        if ($count >= $this->Minimum) {
            return $this->coupon->Discount;
        }

        return 0;
    }
}
