<?php
namespace api\controllers\pay;

use api\components\Exception;
use pay\components\CodeException;
use pay\components\MessageException;
use pay\components\OrderItemCollection;
use pay\models\Product;
use user\models\User;

/**
 * Class FilterBookAction
 */
class FilterBookAction extends \api\components\Action
{
    /**
     * @inheritdoc
     * @throws Exception
     * @throws CodeException
     * @throws MessageException
     */
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $manager = $request->getParam('Manager');
        $params = $request->getParam('Params', []);
        $bookTime = $request->getParam('BookTime', null);
        $payerRunetId = intval($request->getParam('PayerRunetId', 0));
        $ownerRunetId = intval($request->getParam('OwnerRunetId', 0));

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

        /** @var User $payer */
        $payer = User::model()->byRunetId($payerRunetId)->find();
        /** @var User $owner */
        $owner = User::model()->byRunetId($ownerRunetId)->find();

        if (!$payer) {
            throw new Exception(202, [$payerRunetId]);
        }

        if ($owner === null) {
            throw new Exception(202, [$ownerRunetId]);
        }

        if ($product->EventId != $this->getEvent()->Id) {
            throw new Exception(402);
        }

        if (!$product->getManager()->checkProduct($owner)) {
            throw new Exception(403);
        }

        $orderItem = $product->getManager()->createOrderItem($payer, $owner, $bookTime, $params);
        $collection = OrderItemCollection::createByOrderItems([$orderItem]);
        $result = null;
        foreach ($collection as $item) {
            $result = $this->getAccount()->getDataBuilder()->createOrderItem($item);
            break;
        }

        $this->getController()->setResult($result);
    }
}
