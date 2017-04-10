<?php

namespace paperless\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property string $Name
 * @property string $Type
 * @property string $Comment
 * @property boolean $Active
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
            ['EventId, Id, Name, Type, Active', 'required'],
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
    public static function types()
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
        return \CHtml::value(self::types(), $this->Type, null);
    }
}