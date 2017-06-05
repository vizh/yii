<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 31.08.2015
 * Time: 11:31
 */

namespace partner\controllers\order;

use partner\components\Action;
use pay\models\Order;

class DeleteAction extends Action
{
    /**
     * Удаление счета
     * @param int $id
     * @throws \CHttpException
     */
    public function run($id)
    {
        $order = Order::model()->byEventId($this->getEvent()->Id)->byPaid(false)->findByPk($id);
        if ($order === null) {
            throw new \CHttpException(404);
        }

        $order->delete();
        $this->getController()->redirect(['view', 'id' => $id]);
    }
}