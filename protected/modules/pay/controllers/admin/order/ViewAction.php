<?php
namespace pay\controllers\admin\order;

class ViewAction extends \CAction
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
            $paid = $request->getParam('SetPaid', false);
            if ($paid !== false) {
                $payResult = $order->activate();

                if (!empty($payResult['ErrorItems'])) {
                    $this->error = 'Повторно активированы некоторые заказы. Список идентификаторов: '.implode(', ', $payResult['ErrorItems']);
                } else {
                    $this->result = 'Счет успешно активирован, платежи проставлены! Сумма счета: <strong>'.$payResult['Total'].'</strong> руб.';
                }
            } else {
                $order->delete();
            }
        }

        $this->getController()->render('view',
            [
                'order' => $order
            ]
        );
    }
}