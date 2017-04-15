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
 * @property bool $ProcessedTime
 * @property bool $CreatedTime
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
 * @method DeviceSignal byDeviceNumber(int $uid, bool $useAnd = true)
 * @method DeviceSignal byBadgeUID(int $id, bool $useAnd = true)
 * @method DeviceSignal byProcessed(bool $processed, bool $useAnd = true)
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
            ['Processed', 'boolean']
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