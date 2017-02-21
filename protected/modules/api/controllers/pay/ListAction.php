<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use pay\components\collection\Finder;
use pay\components\OrderItemCollection;
use user\models\User;

use nastradamus39\slate\annotations\ApiAction;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Response;

/**
 * Class ListAction Returns list of products
 */
class ListAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Заказы",
     *     description="Список заказов.",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/list",
     *          params={ @Param(title="PayerRunetId", description="Идентификатор плательщика.") },
     *          response=@Response(body="{ 'Items': ['{$ITEM}'], 'Orders': ['{$ORDER}'] }")
     *     )
     * )
     */
    public function run()
    {
        $result = new \stdClass();

        $finder = Finder::create($this->getEvent()->Id, $this->getRequestedPayer()->Id);
        $collections = array_merge(
            [$finder->getUnpaidFreeCollection()],
            $finder->getPaidOrderCollections(),
            $finder->getPaidFreeCollections()
        );

        $result->Items = [];
        foreach ($collections as $collection) {
            foreach ($collection as $item) {
                $result->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($item);
            }
        }

        usort($result->Items, function ($item1, $item2) {
            $result = strcasecmp($item1->Owner->LastName, $item2->Owner->LastName);
            if (!$result) {
                $result = strcasecmp($item1->Owner->FirstName, $item2->Owner->FirstName);
            }

            return $result;
        });

        /** @var $collections OrderItemCollection[] */
        $collections = array_merge($finder->getUnpaidOrderCollections(), $finder->getPaidOrderCollections());

        $result->Orders = [];
        foreach ($collections as $collection) {
            if (is_null($collection->getOrder())) {
                continue;
            }

            $orderObj = new \stdClass();
            $orderObj->OrderId = $collection->getOrder()->Id;
            $orderObj->CreationTime = $collection->getOrder()->CreationTime;
            $orderObj->Number = $collection->getOrder()->Number;
            $orderObj->Paid = $collection->getOrder()->Paid;
            $orderObj->Url = $collection->getOrder()->getUrl();
            $orderObj->Items = [];
            foreach ($collection as $item) {
                $orderObj->Items[] = $this->getAccount()->getDataBuilder()->createOrderItem($item);
            }

            $result->Orders[] = $orderObj;
        }

        $this->setResult($result);
    }
}
