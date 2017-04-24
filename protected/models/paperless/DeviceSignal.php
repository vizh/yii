<?php

namespace application\models\paperless;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $DeviceNumber
 * @property int $BadgeUID
 * @property int $BadgeTime
 * @property bool $Processed
 * @property string $ProcessedTime
 * @property bool $CreatedTime
 *
 * @property \event\models\Participant $Participant
 *
 * Описание вспомогательных методов
 * @method DeviceSignal   with($condition = '')
 * @method DeviceSignal   find($condition = '', $params = [])
 * @method DeviceSignal   findByPk($pk, $condition = '', $params = [])
 * @method DeviceSignal   findByAttributes($attributes, $condition = '', $params = [])
 * @method DeviceSignal[] findAll($condition = '', $params = [])
 * @method DeviceSignal[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method DeviceSignal byId(int $id, bool $useAnd = true)
 * @method DeviceSignal byEventId(int $id, bool $useAnd = true)
 * @method DeviceSignal byDeviceNumber(int|int[] $uid, bool $useAnd = true)
 * @method DeviceSignal byBadgeUID(int $id, bool $useAnd = true)
 * @method DeviceSignal byProcessed(bool $processed = true, bool $useAnd = true)
 */
class DeviceSignal extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessDeviceSignal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Id', 'required', 'on' => 'update'],
            ['EventId,DeviceNumber,BadgeUID,BadgeTime', 'required'],
            ['EventId,DeviceNumber,BadgeUID', 'numerical'],
            ['Processed', 'boolean'],
            ['ProcessedTime', 'date', 'format' => 'yyyy-MM-dd HH:mm:ss']
        ];
    }

    public function relations()
    {
        return [
            'Participant' => [self::HAS_ONE, '\event\models\Participant', ['BadgeUID' => 'BadgeUID'], 'with' => 'User']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'Идентификатор сигнала',
            'EventId' => 'Идентификатор мероприятия',
            'DeviceNumber' => 'Номер устройства',
            'BadgeUID' => 'Уникальный идентификатор бейджа',
            'BadgeTime' => 'Время прикладывания бейджа',
            'Processed' => 'Флаг обработки сигнала',
        ];
    }
}