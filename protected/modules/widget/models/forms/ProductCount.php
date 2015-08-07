<?php

namespace widget\models\forms;

use application\components\form\EventItemCreateUpdateForm;
use pay\models\Product;

class ProductCount extends EventItemCreateUpdateForm
{
    public $Count;

    /**
     * Список доступных для покупки продуктов
     * @return Product[]
     */
    public function getProducts()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ManagerName" != \'Ticket\'');

        $products = Product::model()
            ->byEventId($this->event->Id)
            ->byPublic(true)
            ->orderBy(['"t"."Priority"' => SORT_DESC, '"t"."Id"' => SORT_ASC])
            ->findAll();

        return $products;
    }
}