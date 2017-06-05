<?php
namespace partner\controllers\orderitem;

use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\orderitem\Refund;
use pay\models\OrderItem;

class RefundAction extends Action
{
    public function run($id)
    {
        /** @var OrderItem $orderItem */
        $orderItem = OrderItem::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($orderItem === null || (!$orderItem->Paid && !$orderItem->Refund)) {
            throw new \CHttpException(404);
        }
        $form = new Refund($orderItem);
        if (\Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->updateActiveRecord() !== null) {
                Flash::setSuccess(\Yii::t('app', 'Заказ успешно отменен'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('refund', [
            'form' => $form
        ]);
    }
}