<?php

namespace connect\models;

use application\components\ActiveRecord;

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
        ];
    }
}