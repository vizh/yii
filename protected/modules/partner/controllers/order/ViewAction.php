<?php
namespace partner\controllers\order;

use partner\components\Action;
use pay\models\Order;

class ViewAction extends Action
{
    public function run($id)
    {
        $order = Order::model()
            ->byEventId($this->getEvent()->Id)
            ->findByPk($id);

        if ($order === null) {
            throw new \CHttpException(404);
        }

        $this->getController()->render('view', [
            'order' => $order
        ]);
    }
}
