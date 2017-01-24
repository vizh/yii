<?php

namespace connect\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;
use event\models\Event;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property string $Name
 * @property bool $Reservation
 * @property integer $ReservationTime
 * @property integer $ParentId
 * @property bool $reservationOnAcceptRequired
 *
 * @property Event $Event
 * @property Place $Parent
 * @property Place[] $Children
 * @property Meeting[] $Meetings
 *
 * Описание вспомогательных методов
 * @method Place   with($condition = '')
 * @method Place   find($condition = '', $params = [])
 * @method Place   findByPk($pk, $condition = '', $params = [])
 * @method Place   findByAttributes($attributes, $condition = '', $params = [])
 * @method Place[] findAll($condition = '', $params = [])
 * @method Place[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Place byId(int $id, bool $useAnd = true)
 * @method Place byEventId(int $id, bool $useAnd = true)
 * @method Place byReservation(int $reservation, bool $useAnd = true)
 * @method Place byParentId(int $id, bool $useAnd = true)
 */
class Place extends ActiveRecord
{
    /**
     * @param string $className
     * @return Place
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventMeetingPlace';
    }

    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'Parent' => [self::BELONGS_TO, '\connect\models\Place', 'ParentId'],
            'Children' => [self::HAS_MANY, '\connect\models\Place', 'ParentId'],
            'Meetings' => [self::HAS_MANY, '\connect\models\Meeting', 'PlaceId'],
        ];
    }

    public function getReservationOnAcceptRequired()
    {
        return $this->Reservation && !empty($this->Children);
    }

    public function getReservations($datetime)
    {
        $reservations = [];

        /** @var Meeting[] $meetings */
        $meetings = Meeting::model()
            ->byPlaceId(array_map(function ($room) {
                return $room->Id;
            }, $this->Children))
            ->findAll();

        foreach ($meetings as $meeting) {
            $link = ArrayHelper::getValue($meeting, 'UserLinks.0', null);
            if (!$link) {
                continue;
            }
            $overlapping = abs(strtotime($datetime) - strtotime($meeting->Date)) < $this->ReservationTime;
            $accepted = $link->Status == MeetingLinkUser::STATUS_ACCEPTED;
            $expired = strtotime(date('Y-m-d')) - strtotime($meeting->CreateTime) > 24 * 60 * 60;
            if ($overlapping && ($accepted || !$expired)) {
                $reservations[] = $meeting;
            }
        }

        return $reservations;
    }

    public function assignRoom($datetime)
    {
        $reservations = $this->getReservations($datetime);

        /** @var Place $room */
        foreach ($this->Children as $room) {
            $taken = false;
            /** @var Meeting $meeting */
            foreach ($reservations as $meeting) {
                if ($meeting->PlaceId == $room->Id) {
                    $taken = true;
                }
            }
            if (!$taken) {
                return $room;
            }
        }

        return null;
    }

    public function countReservations($datetime)
    {
        return count($this->getReservations($datetime));
    }

    public function hasAvailableReservation($datetime)
    {
        return $this->assignRoom($datetime) ? true : false;
    }
}