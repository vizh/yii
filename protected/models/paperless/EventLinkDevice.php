<?php

namespace application\models\paperless;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $DeviceId
 *
 * @property Event $Event
 * @property Device $Device
 *
 * Описание вспомогательных методов
 * @method EventLinkDevice   with($condition = '')
 * @method EventLinkDevice   find($condition = '', $params = [])
 * @method EventLinkDevice   findByPk($pk, $condition = '', $params = [])
 * @method EventLinkDevice   findByAttributes($attributes, $condition = '', $params = [])
 * @method EventLinkDevice[] findAll($condition = '', $params = [])
 * @method EventLinkDevice[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method EventLinkDevice byEventId(int $id, bool $useAnd = true)
 * @method EventLinkDevice byDeviceId(int $id, bool $useAnd = true)
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