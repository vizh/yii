<?php
namespace partner\controllers\special\rif13;

class BookinfoAction extends \partner\components\Action
{
    public function run()
    {
        $simple = \Yii::app()->getRequest()->getParam('simple');
        if ($simple !== null) {
            $this->runetIdList();
        }

        $products = \pay\models\Product::model()
            ->byEventId($this->getEvent()->Id)->byManagerName('RoomProductManager')->findAll();
        $idList = [];

        foreach ($products as $product) {
            $idList[] = $product->Id;
        }

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $idList);
        $criteria->addCondition('"t"."Booked" IS NOT NULL AND "t"."Booked" > :Booked');
        $criteria->params['Booked'] = '2013-04-11 00:00:00';
        $criteria->order = '"t"."Booked"';

        $orderItems = \pay\models\OrderItem::model()
            ->byPaid(false)->byDeleted(false)->findAll($criteria);

        $this->getController()->render('rif13/bookinfo', ['orderItems' => $orderItems]);
    }

    private function runetIdList()
    {
        $products = \pay\models\Product::model()
            ->byEventId($this->getEvent()->Id)->byManagerName('RoomProductManager')->findAll();
        $idList = [];

        foreach ($products as $product) {
            $idList[] = $product->Id;
        }
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."ProductId"', $idList);

        $orderItems = \pay\models\OrderItem::model()
            ->byPaid(true)->findAll($criteria);

        $runetIdList = [];
        foreach ($orderItems as $item) {
            $runetIdList[] = $item->ChangedOwnerId !== null ? $item->ChangedOwner->RunetId : $item->Owner->RunetId;
        }

        echo 'count:'.sizeof($runetIdList).'<br><br>';
        echo implode(',', $runetIdList);
        \Yii::app()->end();
    }
}