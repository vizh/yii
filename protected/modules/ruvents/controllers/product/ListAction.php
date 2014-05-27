<?php
namespace ruvents\controllers\product;

class ListAction extends \ruvents\components\Action
{
    public function run()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('t."ManagerName" = :ManagerName');
        $criteria->params = ['ManagerName' => 'FoodProductManager'];
        $products = \pay\models\Product::model()
            ->byEventId($this->getEvent()->Id)->findAll($criteria);
        $result = [];
        foreach ($products as $product)
        {
            $result[] = $this->getDataBuilder()->createProduct($product);
        }
        $this->renderJson($result);
    }
}