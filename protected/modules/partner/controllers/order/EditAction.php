<?php
namespace partner\controllers\order;

use partner\components\Action;
use pay\components\CodeException;
use pay\models\forms\Juridical;
use pay\models\Order;
use user\models\User;

/**
 * Class EditAction
 *
 * Действие для редактирования счетов
 *
 * @package partner\controllers\order
 */
class EditAction extends Action
{
    /**
     * @param int|null $id
     * @param int|null $payer
     * @throws CodeException
     */
    public function run($id = null, $payer = null)
    {
        \Yii::app()->getClientScript()->registerPackage('angular');

        $order = null;
        if ($id !== null) {
            $order = Order::model()->byEventId($this->getEvent()->Id)->byPaid(false)->byDeleted(false)->findByPk($id);
            if ($order == null || !$order->getIsBankTransfer()) {
                throw new CodeException(CodeException::NO_EXISTS_ORDER, [$id]);
            }
        }

        if ($order === null) {
            $payer = User::model()->byRunetId($payer)->find();
            if ($payer === null) {
                $this->getController()->render('payer');
                return;
            }
        } else {
            $payer = $order->Payer;
        }

        $form = new Juridical($this->getEvent(), $payer, $order);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            $result = $form->isUpdateMode() ? $form->updateActiveRecord() : $form->createActiveRecord();
            if ($result !== null) {
                $this->getController()->redirect(['view', 'id' => $result->OrderId]);
            }
        }
        $this->getController()->render('edit', ['form' => $form]);
    }
}