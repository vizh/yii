<?php
namespace pay\models\search\admin\booking;

use application\components\form\SearchFormModel;
use application\components\web\ArrayDataProvider;
use pay\models\FoodPartnerOrder;
use pay\models\RoomPartnerBooking;

class Partners extends SearchFormModel
{
    public $Partner;

    public function rules()
    {
        return [
            ['Partner', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'Partner' => 'Партнер',
            'Ordered' => 'Всего',
            'Paid' => 'Оплачено'
        ];
    }

    /**
     * @return ArrayDataProvider
     */
    public function getDataProvider()
    {
        $this->fillRoomResult();
        $this->fillFoodResult();
        return new ArrayDataProvider(array_values($this->result));
    }

    /** @var PartnerData[] */
    private $result = [];

    /**
     * @return PartnerData[]
     */
    private function fillRoomResult()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Product'];
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];
        if (!empty($this->Partner)) {
            $criteria->addCondition('"t"."Owner" ILIKE :Owner');
            $criteria->params['Owner'] = '%'.$this->Partner.'%';
        }

        $bookings = RoomPartnerBooking::model()->byDeleted(false)->findAll($criteria);
        foreach ($bookings as $booking) {
            $k = $booking->Owner;
            if (!isset($this->result[$k])) {
                $this->result[$k] = new PartnerData();
                $this->result[$k]->Id = $booking->Owner;
                $this->result[$k]->Partner = $booking->Owner;
            }
            $this->result[$k]->Ordered++;
            if ($booking->Paid) {
                $this->result[$k]->Paid++;
            }
        }
    }

    /**
     * @return PartnerData[]
     */
    private function fillFoodResult()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Items.Product'];
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];
        if (!empty($this->Partner)) {
            $criteria->addCondition('"t"."Owner" ILIKE :Owner');
            $criteria->params['Owner'] = '%'.$this->Partner.'%';
        }

        $orders = FoodPartnerOrder::model()->byDeleted(false)->findAll($criteria);
        foreach ($orders as $order) {
            $k = $order->Owner;
            if (!isset($this->result[$k])) {
                $this->result[$k] = new PartnerData();
                $this->result[$k]->Id = $order->Owner;
                $this->result[$k]->Partner = $order->Owner;
            }
            $this->result[$k]->Food++;
        }
    }
}

class PartnerData
{
    public $Id;
    public $Partner;
    public $Paid = 0;
    public $Ordered = 0;
    public $Food = 0;
}