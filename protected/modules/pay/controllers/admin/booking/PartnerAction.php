<?php
namespace pay\controllers\admin\booking;

use pay\models\RoomPartnerBooking;
use pay\models\RoomPartnerOrder;

class PartnerAction extends \CAction
{
    private $owner;

    public function run($owner)
    {
        $this->owner = $owner;
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];

        $bookings = RoomPartnerBooking::model()->byOwner($this->owner)->byDeleted(false)->orderBy('"t"."Id"')->with(['Order', 'Product.Attributes'])->findAll($criteria);
        if (empty($bookings))
            throw new \CHttpException(404);

        $action = \Yii::app()->getRequest()->getParam('action');
        if ($action !== null)
        {
            $this->processAction();
        }

        $bookingsWithoutOrder = [];
        $orderIdList = [];
        foreach ($bookings as $booking)
        {
            if ($booking->OrderId !== null)
            {
                if (!in_array($booking->OrderId, $orderIdList))
                {
                    $orderIdList[] = $booking->OrderId;
                }
            }
            else
            {
                $bookingsWithoutOrder[] = $booking;
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" ASC';
        $criteria->addInCondition('"t"."Id"', $orderIdList);
        $orders = RoomPartnerOrder::model()->byDeleted(false)->findAll($criteria);
        $this->getController()->setPageTitle(\Yii::t('app', 'Бронирования партнера'));
        $this->getController()->render('partner', ['owner' => $owner, 'bookings' => $bookingsWithoutOrder, 'orders' => $orders]);
    }

    private function processAction()
    {
        $request = \Yii::app()->getRequest();
        $order = RoomPartnerOrder::model()->byDeleted(false)->byPaid(false)->findByPk($request->getParam('orderId'));
        if ($order == null)
            throw new \CHttpException(404);

        switch ($request->getParam('action'))
        {
            case 'activate':
                $order->activate();
                break;

            case 'delete':
                $order->delete();
                break;
        }

        $this->getController()->redirect(
            $this->getController()->createUrl('/pay/admin/booking/partner', ['owner' => $this->owner])
        );
    }
} 