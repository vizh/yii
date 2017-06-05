<?php
namespace pay\controllers\juridical;

class DeleteAction extends \pay\components\Action
{
    public function run($orderId, $eventIdName)
    {
        /** @var $order \pay\models\Order */
        $order = \pay\models\Order::model()->findByPk($orderId);
        if ($order->EventId == $this->getEvent()->Id && $order->PayerId == $this->getUser()->Id) {
            $order->delete();
        }
        $this->getController()->redirect($this->getController()->createUrl('/pay/cabinet/index'));
    }
}
