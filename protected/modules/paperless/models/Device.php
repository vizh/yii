<?php

namespace paperless\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $DeviceId
 * @property int $EventId
 * @property bool $Active
 * @property string $Name
 * @property string $Type
 * @property string $Comment
 *
 * Описание вспомогательных методов
 * @method Device   with($condition = '')
 * @method Device   find($condition = '', $params = [])
 * @method Device   findByPk($pk, $condition = '', $params = [])
 * @method Device   findByAttributes($attributes, $condition = '', $params = [])
 * @method Device[] findAll($condition = '', $params = [])
 * @method Device[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Device byId(int $id, bool $useAnd = true)
 * @method Device byDeviceId(int $id, bool $useAnd = true)
 * @method Device byEventId(int $id, bool $useAnd = true)
 * @method Device byActive(bool $active, bool $useAnd = true)
 * @method Device byName(string $name, bool $useAnd = true)
 * @method Device byType(string $type, bool $useAnd = true)
 */
class Device extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessDevice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['Id', 'required', 'on' => 'update'],
            ['EventId,DeviceId,Name,Type', 'required'],
            ['EventId,DeviceId', 'numerical'],
            ['Active', 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID точки',
            'DeviceId' => 'Номер устройства',
            'Name' => 'Название',
            'Type' => 'Тип',
            'Comment' => 'Комментарий',
            'Active' => 'Устройство активно',
            'activeLabel' => 'Устройство активно',
        ];
    }

    /**
     * Список доступных типов устройства
     * @return array
     */
    public static function getTypeLabels()
    {
        return [
            1 => 'Голосование',
            2 => 'Сбор статистики',
            3 => 'Стенд',
            4 => 'Проверка доступа',
        ];
    }

    /**
     * Текстовое представление флага активности
     * @return string
     */
    public function getActiveLabel()
    {
        return $this->Active ? 'Активна' : 'Неактивна';
    }

    /**
     * Текстовое представление типа устройства
     * @return string|null
     */
    public function getTypeLabel()
    {
        return \CHtml::value(self::getTypeLabels(), $this->Type, null);
    }
}