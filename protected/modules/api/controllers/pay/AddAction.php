<?php
namespace api\controllers\pay;

use api\components\Action;
use api\components\Exception;
use pay\components\CodeException;
use pay\components\MessageException;
use pay\components\OrderItemCollection;
use pay\models\Coupon;
use pay\models\Product;
use user\models\User;

/**
 * Class AddAction
 */
class AddAction extends Action
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
        $productId = $request->getParam('ProductId');

        $payerRunetId = $request->getParam('PayerRunetId', null);
        if ($payerRunetId === null) {
            $payerRunetId = $request->getParam('PayerRocId', null);
        }

        $ownerRunetId = $request->getParam('OwnerRunetId', null);
        if ($ownerRunetId === null) {
            $ownerRunetId = $request->getParam('OwnerRocId', null);
        }

        /** @var Product $product */
        $product = Product::model()
            ->byEventId($this->getEvent()->Id)
            ->findByPk($productId);

        $payer = User::model()->byRunetId($payerRunetId)->find();
        $owner = User::model()->byRunetId($ownerRunetId)->find();

        if (!$product) {
            throw new Exception(401, [$productId]);
        } elseif ($payer == null) {
            throw new Exception(202, [$payerRunetId]);
        } elseif ($owner == null) {
            throw new Exception(202, [$ownerRunetId]);
        } elseif ($this->getEvent()->Id != $product->EventId) {
            throw new Exception(402);
        }

        $attributes = $request->getParam('Attributes', []);

        try {
            $orderItem = $product->getManager()->createOrderItem($payer, $owner, null, $attributes);
            if ($orderItem->getPrice() == 0) {
                $orderItem->activate();
            }
        } catch (Exception $e) {
            throw new Exception(408, [$e->getCode(), $e->getMessage()], $e);
        }

        # TODO: delete after edcrunch16
        if ($product->Event->IdName === 'edcrunch16'
            && $request->getParam('Paid', false)
            && $request->getParam('PaidHash') === md5($productId.$payerRunetId.$ownerRunetId)
        ) {
            $coupon = new Coupon();
            $coupon->EventId = $this->getEvent()->Id;
            $coupon->Discount = 100;
            $coupon->Code = $coupon->generateCode();
            $coupon->EndTime = '2016-09-14 23:59:59';
            $coupon->save();
            $coupon->addProductLinks([$product]);
            $coupon->activate($payer, $owner, $product);
        }

        $collection = OrderItemCollection::createByOrderItems([$orderItem]);
        $result = null;
        foreach ($collection as $item) {
            $result = $this->getAccount()->getDataBuilder()->createOrderItem($item);
            break;
        }

        $this->setResult($result);
    }
}
