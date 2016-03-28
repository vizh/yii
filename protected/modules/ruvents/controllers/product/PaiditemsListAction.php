<?php
namespace ruvents\controllers\product;


use pay\models\OrderItem;

class PaiditemsListAction extends \ruvents\components\Action
{
    public function run()
    {
        ini_set('memory_limit', '512M');

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Product',
            'Payer',
            'Owner',
            'ChangedOwner',
            'OrderLinks.Order'
        ];

        /** @var $paidItems OrderItem[] */
        $paidItems = OrderItem::model()
            ->byEventId($this->getEvent()->Id)->byPaid(true)
            ->findAll($criteria);

        $result = [];
        foreach ($paidItems as $item) {
            $this->getDataBuilder()->createOrderItem($item);
            $result[] = $this->getDataBuilder()->buildOrderItemOwners($item);
        }
        
        echo json_encode(['OrderItems' => $result]);
    }
}