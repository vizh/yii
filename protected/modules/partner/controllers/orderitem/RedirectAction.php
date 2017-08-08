<?php
namespace partner\controllers\orderitem;

use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\orderitem\Redirect;
use pay\models\OrderItem;
use Yii;

class RedirectAction extends Action
{
    public function run($id)
    {
        $orderItem = OrderItem::model()
            ->byEventId($this->getEvent()->Id)
            ->findByPk($id);

        if ($orderItem === null || !$orderItem->Paid) {
            throw new \CHttpException(404);
        }

        $form = new Redirect($orderItem);
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $form->fillFromPost();
            if ($form->updateActiveRecord() !== null) {
                Flash::setSuccess(Yii::t('app', 'Заказ успешно перенесен'));
                $this->getController()->refresh();
            }
        }

        $this->getController()->render('redirect', [
            'form' => $form
        ]);
    }
}
