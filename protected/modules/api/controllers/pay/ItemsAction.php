<?php
namespace api\controllers\pay;

use pay\components\OrderItemCollection;
use pay\models\OrderItem;

class ItemsAction extends \api\components\Action
{
    public function run()
    {
        $owner = $this->getRequestedOwner();

        $orderItems = OrderItem::model()
            ->byOwnerId($owner->Id)
            ->byChangedOwnerId($owner->Id, false)
            ->byEventId($this->getEvent()->Id)
            ->byPaid(true)
            ->findAll();

        $collection = OrderItemCollection::createByOrderItems($orderItems);

        $result = new \stdClass();
        $result->Items = [];
        foreach ($collection as $item) {
            $result->Items[] = $this
                ->getAccount()
                ->getDataBuilder()
                ->createOrderItem($item);
        }

        $this->setResult($result);
    }
}
