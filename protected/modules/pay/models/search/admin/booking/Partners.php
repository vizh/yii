<?php
namespace pay\models\search\admin\booking;

use application\components\form\SearchFormModel;
use application\components\web\ArrayDataProvider;
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
        /** @var PartnerData[] $result */
        $result = [];

        $criteria = new \CDbCriteria();
        $criteria->with = ['Product'];
        $criteria->addCondition('"Product"."EventId" = :EventId');
        $criteria->params['EventId'] = \Yii::app()->params['AdminBookingEventId'];

        if ($this->validate()) {
            if (!empty($this->Partner)) {
                $criteria->addCondition('"t"."Owner" ILIKE :Owner');
                $criteria->params['Owner'] = '%' . $this->Partner . '%';
            }
        }

        $bookings = RoomPartnerBooking::model()->byDeleted(false)->orderBy(['"t"."Owner"'])->findAll($criteria);
        foreach ($bookings as $booking) {
            $k = $booking->Owner;
            if (!isset($result[$k])) {
                $result[$k] = new PartnerData();
                $result[$k]->Id = $booking->Owner;
                $result[$k]->Partner = $booking->Owner;
                $result[$k]->Paid = 0;
                $result[$k]->Ordered = 0;
            }

            $result[$k]->Ordered++;
            if ($booking->Paid) {
                $result[$k]->Paid++;
            }
        }
        return new ArrayDataProvider(array_values($result));
    }
}

class PartnerData
{
    public $Id;
    public $Partner;
    public $Paid;
    public $Ordered;
}