<?php
namespace api\controllers\pay;

class DeleteAction extends \api\components\Action
{
    public function run()
    {
        $request = \Yii::app()->getRequest();
        $orderItemId = $request->getParam('OrderItemId');
        $payerRunetId = $request->getParam('PayerRunetId', null);
        if ($payerRunetId === null) {
            $payerRunetId = $request->getParam('PayerRocId', null);
        }

        /** @var $orderItem \pay\models\OrderItem */
        $orderItem = \pay\models\OrderItem::model()->findByPk($orderItemId);
        $payer = \user\models\User::model()->byRunetId($payerRunetId)->find();

        if ($orderItem == null) {
            throw new \api\components\Exception(409);
        } else {
            if ($payer == null) {
                throw new \api\components\Exception(202, [$payerRunetId]);
            } else {
                if ($orderItem->PayerId != $payer->Id) {
                    throw new \api\components\Exception(410);
                } else {
                    if ($orderItem->Product->EventId != $this->getEvent()->Id) {
                        throw new \api\components\Exception(402);
                    } else {
                        if ($orderItem->Paid) {
                            throw new \api\components\Exception(411);
                        }
                    }
                }
            }
        }

        if (!$orderItem->delete()) {
            throw new \api\components\Exception(412);
        }
        $this->getController()->setResult(['Success' => true]);
    }
}
