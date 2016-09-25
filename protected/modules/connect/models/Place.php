<?php

namespace connect\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property string $Name
 * @property boolean $Reservation
 * @property integer $ReservationTime
 * @property integer $ReservationLimit
 *
 * @property Meeting[] $Meetings
 */
class Place extends ActiveRecord
{
    public function tableName()
    {
        return 'EventMeetingPlace';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Meetings' => [self::HAS_MANY, '\connect\models\Meeting', 'PlaceId'],
        ];
    }

    public function getReservations($date)
    {
        $reservations = [];
        /** @var Meeting $meeting */
        foreach ($this->Meetings as $meeting) {
            $link = ArrayHelper::getValue($meeting, 'UserLinks.0', null);
            if (!$link){
                continue;
            }
            $overlapping = abs(strtotime($date) - strtotime($meeting->Date)) < $this->ReservationTime;
            $accepted = $link->Status == MeetingLinkUser::STATUS_ACCEPTED;
            $expired = $link->Status == MeetingLinkUser::STATUS_SENT && strtotime(date('Y-m-d')) - strtotime($meeting->CreateTime) > 24*60*60;
            if ($overlapping && ($accepted || !$expired)){
                $reservations[] = $meeting;
            }
        }
        return $reservations;
    }

    public function assignReservation($date)
    {
        for ($i=1; $i<=$this->ReservationLimit; $i++){
            $taken = false;
            /** @var Meeting $meeting */
            foreach ($this->getReservations($date) as $meeting) {
                if ($meeting->ReservationNumber == $i){
                    $taken = true;
                }
            }
            if (!$taken){
                return $i;
            }
        }
        return null;
    }

    public function countReservations($date)
    {
        return count($this->getReservations($date));
    }

    public function hasAvailableReservation($date)
    {
        if (!$this->Reservation || !$this->ReservationTime) {
            return true;
        }

        if ($this->countReservations($date) >= $this->ReservationLimit){
            return false;
        }

        return true;
    }
}