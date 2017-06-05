<?php
namespace pay\controllers\admin\booking;

class DeleteAction extends \CAction
{
    public function run($type, $id)
    {
        $productId = null;
        if ($type == 'partner') {
            /** @var \pay\models\RoomPartnerBooking $partnerBooking */
            $partnerBooking = \pay\models\RoomPartnerBooking::model()->findByPk($id);
            if ($partnerBooking != null) {
                $productId = $partnerBooking->ProductId;
                $partnerBooking->deleteHard();
            } else {
                throw new \CHttpException(404);
            }
        } elseif ($type == 'user') {
            $orderItem = \pay\models\OrderItem::model()->findByPk($id);
            if ($orderItem != null) {
                $productId = $orderItem->ProductId;
                $orderItem->deleteHard();
            } else {
                throw new \CHttpException(404);
            }
        } else {
            throw new \CHttpException(404);
        }

        $this->getController()->redirect(\Yii::app()->createUrl('/pay/admin/booking/edit', ['productId' => $productId]));
    }
} 