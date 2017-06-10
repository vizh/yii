<?php
namespace pay\controllers\admin\booking;

use pay\models\FoodPartnerOrder;
use pay\models\RoomPartnerBooking;
use pay\models\RoomPartnerOrder;

class PartnerAction extends \CAction
{
    private $owner;

    public function run($owner)
    {
        $this->owner = $owner;
        $foodOrders = $this->getFoodOrders();

        $action = \Yii::app()->getRequest()->getParam('actionRoomOrder');
        if ($action !== null) {
            $this->processActionRoomOrder($action);
        }

        $action = \Yii::app()->getRequest()->getParam('actionFoodOrder');
        if ($action !== null) {
            $this->processActionFoodOrder($action);
        }

        $this->getController()->render('partner', [
            'owner' => $owner,
            'bookings' => $this->getBookingsWithoutOrder(),
            'orders' => $this->getRoomOrders(),
            'foodOrders' => $foodOrders
        ]);
    }

    /**
     * @param string $action
     * @throws \CHttpException
     */
    private function processActionRoomOrder($action)
    {
        $order = RoomPartnerOrder::model()->byDeleted(false)->byPaid(false)->findByPk(\Yii::app()->getRequest()->getParam('id'));
        if ($order === null) {
            throw new \CHttpException(404);
        }

        switch ($action) {
            case 'activate':
                $order->activate();
                break;

            case 'delete':
                $order->delete();
                break;
        }

        $this->getController()->redirect(['partner', 'owner' => $this->owner]);
    }

    /**
     * @param string $action
     * @throws \CHttpException
     */
    private function processActionFoodOrder($action)
    {
        $order = FoodPartnerOrder::model()->byDeleted(false)->byPaid(false)->findByPk(\Yii::app()->getRequest()->getParam('id'));
        if ($order === null) {
            throw new \CHttpException(404);
        }

        switch ($action) {
            case 'activate':
                $order->activate();
                break;

            case 'delete':
                $order->delete();
                break;
        }

        $this->getController()->redirect(['partner', 'owner' => $this->owner]);
    }

    private $bookings;

    /**
     * Список всех бронирований номеров
     * @return \pay\models\RoomPartnerBooking[]
     */
    private function getBookings()
    {
        if ($this->bookings === null) {
            $criteria = new \CDbCriteria();
            $criteria->addCondition('"Product"."EventId" = :EventId');
            $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];

            $this->bookings = RoomPartnerBooking::model()->byOwner($this->owner)->byDeleted(false)->orderBy('"t"."Id"')->with(['Order', 'Product.Attributes'])->findAll($criteria);
        }
        return $this->bookings;
    }

    /**
     * Список бронирований не добавленных в счет
     * @return RoomPartnerBooking[]
     */
    private function getBookingsWithoutOrder()
    {
        $bookings = [];
        foreach ($this->getBookings() as $booking) {
            if (empty($booking->OrderId)) {
                $bookings[] = $booking;
            }
        }
        return $bookings;
    }

    /**
     * Список счетов на бронирование номеров
     * @return \pay\models\RoomPartnerBooking[]
     */
    private function getRoomOrders()
    {
        $list = [];
        foreach ($this->getBookings() as $booking) {
            if ($booking->OrderId !== null) {
                if (!in_array($booking->OrderId, $list)) {
                    $list[] = $booking->OrderId;
                }
            }
        }

        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Id" ASC';
        $criteria->addInCondition('"t"."Id"', $list);
        return RoomPartnerOrder::model()->byDeleted(false)->findAll($criteria);
    }

    /**
     * Список счетов на питание
     * @return \pay\models\RoomPartnerBooking[]
     */
    private function getFoodOrders()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];
        $foodOrders = FoodPartnerOrder::model()->byOwner($this->owner)->byDeleted(false)->orderBy('"t"."Id"')->with(['Items.Product'])->findAll($criteria);
        return $foodOrders;
    }
}