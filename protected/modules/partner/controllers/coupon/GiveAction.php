<?php
namespace partner\controllers\coupon;

use application\helpers\Flash;
use partner\components\Action;
use partner\models\forms\coupon\Give;
use pay\models\Coupon;

class GiveAction extends Action
{
    public function run()
    {
        /** @var \CHttpRequest $request */
        $request = \Yii::app()->getRequest();
        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $request->getParam('Coupons'));

        $coupons = Coupon::model()->byEventId($this->getEvent()->Id)->byIsTicket(false)->findAll($criteria);
        if (empty($coupons)) {
            throw new \CHttpException(404);
        }

        $form = new Give($coupons);
        if ($request->getIsPostRequest()) {
            $form->fillFromPost();
            $result = $form->updateActiveRecord();
            if ($result !== null) {
                Flash::setSuccess(\Yii::t('app', 'Промо-коды выданы!'));
                $this->getController()->refresh();
            }
        }
        $this->getController()->render('give', [
            'form' => $form
        ]);
    }
}
