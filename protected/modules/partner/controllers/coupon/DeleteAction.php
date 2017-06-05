<?php
namespace partner\controllers\coupon;

use partner\components\Action;
use pay\models\Coupon;

class DeleteAction extends Action
{
    public function run($id)
    {
        $coupon = Coupon::model()->byEventId($this->getEvent()->Id)->findByPk($id);
        if ($coupon === null || $coupon->IsTicket || !empty($coupon->Activations)) {
            throw new \CHttpException(404);
        }

        $coupon->delete();
    }
}