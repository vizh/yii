<?php

namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use nastradamus39\slate\annotations\Action\Param;
use nastradamus39\slate\annotations\Action\Request;
use nastradamus39\slate\annotations\Action\Response;
use nastradamus39\slate\annotations\ApiAction;
use pay\components\OrderItemCollection;
use pay\models\Product;
use Yii;

class FilterBookAction extends Action
{
    /**
     * @ApiAction(
     *     controller="Pay",
     *     title="Купон",
     *     description="Покупки",
     *     request=@Request(
     *          method="GET",
     *          url="/pay/filterbook",
     *          params={
     *              @Param(title="Manager", description="Идентификатор менеджера.", mandatory="Y"),
     *              @Param(title="Params", description="Параметры поиска.", mandatory="Y"),
     *              @Param(title="BookTime", description="Время зааказа.", mandatory="N")
     *          },
     *          response=@Response( body="" )
     *     )
     * )
     */
    public function run()
    {
        $request = Yii::app()->getRequest();
        $manager = $request->getParam('Manager');
        $params = $request->getParam('Params', []);
        $bookTime = $request->getParam('BookTime', null);

        /** @var Product $product */
        $product = Product::model()
            ->byManagerName($manager)
            ->byEventId($this->getEvent()->Id)
            ->find();

        if ($product) {
            $product = $product->getManager()->getFilterProduct($params);
        }

        if (!$product) {
            throw new Exception(420);
        }

        if ($product->EventId !== $this->getEvent()->Id) {
            throw new Exception(402);
        }

        if (!$product->getManager()->checkProduct($this->getRequestedOwner())) {
            throw new Exception(403);
        }

        $orderItem = $product->getManager()->createOrderItem(
            $this->getRequestedPayer(),
            $this->getRequestedOwner(),
            $bookTime,
            $params
        );

        $collection = OrderItemCollection::createByOrderItems([$orderItem]);
        $result = null;
        foreach ($collection as $item) {
            $result = $this->getAccount()->getDataBuilder()->createOrderItem($item);
            break;
        }

        $this->setResult($result);
    }
}
