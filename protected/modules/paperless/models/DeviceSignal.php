<?php

namespace paperless\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property int $DeviceId
 * @property int $BadgeId
 * @property bool $Processed
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
 * @method DeviceSignal byDeviceId(int $id, bool $useAnd = true)
 * @method DeviceSignal byBadgeId(int $id, bool $useAnd = true)
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
            ['EventId,DeviceId,BadgeId', 'required'],
            ['EventId,DeviceId,BadgeId', 'numerical'],
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
            'DeviceId' => 'Идентификатор устройства',
            'BadgeId' => 'Идентификатор бейджа',
            'Processed' => 'Флаг обработки сигнала',
        ];
    }
}