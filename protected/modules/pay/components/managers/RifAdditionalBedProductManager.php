<?php
/**
 * Created by PhpStorm.
 * User: fgorsky
 * Date: 30.03.17
 * Time: 15:35
 */

namespace pay\components\managers;

use pay\models\Product;

class RifAdditionalBedProductManager extends RoomProductManager
{

    public function __construct(Product $product)
    {
        parent::__construct($product);
        $this->isUniqueOrderItem = false;
    }
}