<?php
namespace partner\controllers\special\rif13;

class FixchangesAction extends \partner\components\Action
{
    public function run()
    {
        $products = \pay\models\Product::model()->byManagerName('EventProductManager')
            ->byEventId($this->getEvent()->Id)->findAll();
        $idList = [];
        foreach ($products as $product) {
            $idList[] = $product->Id;
        }

        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ChangedOwnerId" IS NOT NULL');
        $criteria->addInCondition('"t"."ProductId"', $idList);

        $orderItems = \pay\models\OrderItem::model()->byPaid(true)->findAll($criteria);

        foreach ($orderItems as $item) {
            $lostItems = \pay\models\OrderItem::model()->byPaid(true)
                ->byOwnerId($item->OwnerId)->byChangedOwnerId(null)
                ->byEventId($this->getEvent()->Id)->exists();

            if ($lostItems) {
                echo $item->Owner->RunetId.'<br>';
            }
        }
    }
}