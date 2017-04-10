<?php

namespace paperless\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property integer $DeviceId
 *
 * @property Event $Event
 * @property Device $Device
 */
class EventLinkDevice extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessEventLinkDevice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['EventId, DeviceId', 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, Event::className(), ['EventId']],
            'Device' => [self::BELONGS_TO, Device::className(), ['DeviceId']],
        ];
    }
}