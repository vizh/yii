<?php
namespace pay\controllers\ajax;

use pay\models\Product;

class CouponActivateAction extends \pay\components\Action
{
    public function run($code, $eventIdName, $ownerRunetId, $productId)
    {
        $owner = \user\models\User::model()->byRunetId($ownerRunetId)->find();
        if ($owner == null)
            throw new \CHttpException(404);

        $product = Product::model()->findByPk($productId);

        $result = new \stdClass();
        $result->success = false;

        $coupon = \pay\models\Coupon::model()->byCode($code)->byEventId($this->getEvent()->Id)->find();
        if ($coupon == null) {
            $result->error = \Yii::t('app', 'Указан неверный промо код');
        } elseif (!$coupon->getIsForProduct($productId) && $coupon->Discount != 1) {
            $result->error = \Yii::t('app', 'Указанный промо код не может быть активирован для этого товара');
        } else {
            try {
                $coupon->activate($this->getUser(), $owner, $product);
                $result->success = true;
            } catch(\pay\components\Exception $e) {
                $result->error = $e->getMessage();
            }

            if ($result->success) {
                if ($coupon->Discount == 1) {
                    $criteria = new \CDbCriteria();
                    $criteria->with = ['Role' => ['together' => true]];
                    $criteria->order = '"Role"."Priority" DESC';
                    $participant = \event\models\Participant::model()
                        ->byEventId($this->getEvent()->Id)->byUserId($owner->Id)->find($criteria);
                    $result->message = \Yii::t('app', 'Регистрация на мероприятие прошла успешно! Промо-код на скидку 100% активирован. Статус: "{RoleTitle}".', ['{RoleTitle}' => $participant->Role->Title]);
                } else {
                    $result->message = \Yii::t('app', 'Купон на скидку {discount}% успешно активирован!', array('{discount}' => $coupon->Discount*100));
                }

                $result->coupon = new \stdClass();
                $result->coupon->Code = $code;
                $result->coupon->Discount = $coupon->Discount;
            }
        }

        echo json_encode($result);
    }
}
