<?php
namespace ruvents\controllers\product;

class PaiditemsAction extends \ruvents\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $runetId = $request->getParam('RunetId', null);
        $needCustomFormat = $request->getParam('CustomFormat', false) == '1';

        $event = $this->getEvent();
        $user = \user\models\User::model()->byRunetId($runetId)->find();
        if ($user === null) {
            throw new \ruvents\components\Exception(202, [$runetId]);
        }

        $criteria = new \CDbCriteria();
        $criteria->with = [
            'Product',
            'Payer',
            'Owner',
            'ChangedOwner',
            'OrderLinks.Order'
        ];

        /** @var $paidItems \pay\models\OrderItem[] */
        $paidItems = \pay\models\OrderItem::model()
            ->byOwnerId($user->Id)->byChangedOwnerId($user->Id, false)
            ->byEventId($event->Id)->byPaid(true)->findAll($criteria);

        $result = [];
        foreach ($paidItems as $item) {
            $order = $this->getDataBuilder()->createOrderItem($item);

            if ($needCustomFormat) {
                $customOrder = (object)[
                    'OrderItemId' => $item->Id,
                    'ProductId' => $order->Product->ProductId,
                    'ProductTitle' => $order->Product->Title,
                    'Price' => $order->Product->Price
                ];

                if ($order->PromoCode) {
                    $customOrder->PromoCode = $order->PromoCode;
                }
                if ($order->PayType) {
                    $customOrder->PayType = $order->PayType;
                }
                if ($order->Product->Manager) {
                    $customOrder->ProductManager = $order->Product->Manager;
                }
                if ($item->Product->ManagerName == 'RoomProductManager') {
                    $customOrder->Lives = $item->Product->getManager()->Hotel;
                }

                $order = $customOrder;
            }

            $result[] = $order;
        }

        echo json_encode(['OrderItems' => $result]);
    }
}
