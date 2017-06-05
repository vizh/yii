<?php
namespace partner\controllers\special\rif13;

class BookchangesAction extends \partner\components\Action
{
    public function run()
    {
        $products = \pay\models\Product::model()
            ->byEventId($this->getEvent()->Id)->byManagerName('RoomProductManager')->findAll();

        $idList = [];
        foreach ($products as $product) {
            $idList[] = $product->Id;
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $idList);
        $criteria->order = '"t"."PaidTime" DESC';
        $criteria->limit = 100;

        $orderItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);

        $this->getController()->render('rif13/bookchanges', ['orderItems' => $orderItems]);
    }
}