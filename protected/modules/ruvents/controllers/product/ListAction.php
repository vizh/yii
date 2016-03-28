<?php
namespace ruvents\controllers\product;

use pay\models\Product;

class ListAction extends \ruvents\components\Action
{
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('t."ManagerName" = :ManagerName');
        $criteria->params = ['ManagerName' => 'FoodProductManager'];

        $products = Product::model()
            ->byEventId($this->getEvent()->Id)
            ->findAll($criteria);

        $result = [];
        foreach ($products as $product)
            $result[] = $this->getDataBuilder()->createProduct($product);

        $this->renderJson($result);
    }
}