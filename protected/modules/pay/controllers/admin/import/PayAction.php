<?php
namespace pay\controllers\admin\import;


class PayAction extends \CAction
{
    public $error = false;
    public $result = false;

    public function run($orderId)
    {
        /** @var $order \pay\models\ImportOrder */
        $order = \pay\models\ImportOrder::model()->findByPk($orderId);
        if (!$order || !$order->order)
        {
            throw new \CHttpException(404, 'Не найден счет с номером: ' . $orderId);
        }

        $request = \Yii::app()->getRequest();

        if ($order->order->getIsBankTransfer() && $request->getIsPostRequest())
        {
            $order->order->activate();
            $order->Approved = true;
            $order->save();
            $this->getController()->renderPartial('row', ['order' => $order]);
        }
    }
}