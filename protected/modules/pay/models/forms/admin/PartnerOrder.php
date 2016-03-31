<?php
namespace pay\models\forms\admin;

use application\helpers\Flash;
use pay\models\RoomPartnerBooking;
use pay\models\RoomPartnerOrder;

/**
 * Class PartnerOrder Форма редактировния заказа брони партнера
 */
class PartnerOrder extends BasePartnerOrder
{
    public $BookingIdList = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            ['BookingIdList', 'bookingValidate']
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @return \CActiveRecord|null
     * @throws \application\components\Exception
     */
    public function createActiveRecord()
    {
        $eventId = \Yii::app()->params['AdminBookingEventId'];
        $number = RoomPartnerOrder::model()->byEventId($eventId)->count() + 1;

        $order = new RoomPartnerOrder();
        $order->Number  = ('RIF16/' . str_pad($number, 3, '0', STR_PAD_LEFT));
        $order->EventId = $eventId;
        $this->model = $order;

        return $this->updateActiveRecord();
    }


    /**
     * @return \CActiveRecord|null
     * @throws \CDbException
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            $this->model->save();
            foreach ($this->BookingIdList as $id) {
                $booking = RoomPartnerBooking::model()->findByPk($id);
                $booking->OrderId = $this->model->Id;
                $booking->save();
            }
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function bookingValidate($attribute)
    {
        $value = $this->$attribute;
        $valid = true;
        if (!is_array($value)) {
            $valid = false;
        }
        else {
            foreach ($value as $id) {
                $booking = RoomPartnerBooking::model()->byOwner($this->owner)->byDeleted(false)->findByPk($id);
                if ($booking == null) {
                    $valid = false;
                }
            }
        }

        if (!$valid) {
            $this->addError($attribute, \Yii::t('app', 'Ошибка при добавление брони в счет'));
            return false;
        }
        return true;
    }
} 
