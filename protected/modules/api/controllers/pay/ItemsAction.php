<?php
namespace api\controllers\pay;

use pay\components\OrderItemCollection;
use pay\models\OrderItem;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;

class ItemsAction extends \api\components\Action
{

    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Список оплаченных заказов",
     *     description="Список оплаченных за пользователя заказов. Возвращает массив с купленными пользователем заказами.",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/items",
     *          body="",
     *          params={
     *              @Param(title="OwnerRunetId", description="Идентификатор.")
     *          }
     *     )
     * )
     */
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
