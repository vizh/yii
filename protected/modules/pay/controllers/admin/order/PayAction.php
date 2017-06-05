<?php
namespace pay\controllers\admin\order;

class PayAction extends \CAction
{
    public $error = false;
    public $result = false;

    public function run($orderId)
    {
        /** @var $order \pay\models\Order */
        $order = \pay\models\Order::model()->findByPk($orderId);
        if ($order === null) {
            throw new \CHttpException(404, 'Не найден счет с номером: '.$orderId);
        }

        $this->getController()->setPageTitle('Управление счетом (заказом) № '.$order->Number);

        $request = \Yii::app()->getRequest();
        if ($order->getIsBankTransfer() && $request->getIsPostRequest()) {
            $payResult = $order->activate();
            $this->getController()->renderPartial('row', ['order' => $order]);
        }
    }
}