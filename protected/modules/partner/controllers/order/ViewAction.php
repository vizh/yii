<?php
namespace partner\controllers\order;

use application\helpers\Flash;
use partner\components\Action;
use pay\models\Order;

class ViewAction extends Action
{
    public function run($id)
    {
        $order = Order::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($order === null) {
            throw new \CHttpException(404);
        }

        $action = \Yii::app()->getRequest()->getParam('action');
        if (!empty($action)) {
            $this->processAction($order, $action);
            $this->getController()->redirect(['view', 'id' => $order->Id]);
        }

        $this->getController()->render('view', ['order' => $order]);
    }

    /**
     * @param Order $order
     * @param $action
     */
    private function processAction(Order $order, $action)
    {
        if ($action === 'setPaid') {
            $result = $order->activate();
            if (!empty($result['ErrorItems'])) {
                Flash::setError('Повторно активированы некоторые заказы. Список идентификаторов: ' . implode(', ', $result['ErrorItems']));
            } else {
                Flash::setSuccess('Счет успешно активирован, платежи проставлены! Сумма счета: <strong>' . $result['Total'] . '</strong> руб.');
            }
        } elseif ($action === 'setDeleted') {
            $order->delete();
        }
    }
}
