<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 31.08.2015
 * Time: 11:27
 */
namespace partner\controllers\order;

use application\helpers\Flash;
use partner\components\Action;
use pay\models\Order;

class ActivateAction extends Action
{
    /**
     * Активация / проставление оплаты счета
     * @param int $id
     * @throws \CHttpException
     */
    public function run($id)
    {
        $order = Order::model()
            ->byEventId($this->getEvent()->Id)
            ->byPaid(false)
            ->findByPk($id);

        if ($order === null) {
            throw new \CHttpException(404);
        }

        $result = $order->activate();

        if (!empty($result['ErrorItems'])) {
            Flash::setError('Повторно активированы некоторые заказы. Список идентификаторов: '.implode(', ', $result['ErrorItems']));
        } else {
            Flash::setSuccess('Счет успешно активирован, платежи проставлены! Сумма счета: <strong>'.$result['Total'].'</strong> руб.');
        }
        $this->getController()->redirect(['view', 'id' => $id]);
    }
}