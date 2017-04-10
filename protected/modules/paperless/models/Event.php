<?php

namespace paperless\models;

use application\components\ActiveRecord;

/**
 * @property integer $Id
 * @property integer $EventId
 * @property string $Subject
 * @property string $Text
 * @property string $FromName
 * @property string $FromAddress
 * @property string $File
 * @property boolean $SendOnce
 * @property boolean $ConditionLike
 * @property string $ConditionLikeString
 * @property boolean $ConditionNotLike
 * @property boolean $ConditionNotLikeString
 * @property boolean $Active
 *
 * @property \event\models\Event $Event
 * @property EventLinkDevice[] $DeviceLinks
 * @property EventLinkRole[] $RoleLinks
 */
class Event extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return 'PaperlessEvent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['EventId, Subject, Text, FromName, FromAddress', 'required'],
            ['SendOnce, ConditionLike, ConditionNotLike, Active', 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Subject' => 'Тема письма',
            'Text' => 'Текст письма',
            'FromName' => 'Наимаенование отправителя',
            'FromAddress' => 'Email отправителя',
            'File' => 'Файл',
            'SendOnce' => 'Отправлять письмо участнику только один раз',
            'ConditionLike' => 'Ответ устрояяства содержит строку',
            'ConditionLikeString' => '',
            'ConditionNotLike' => 'Ответ устройства не содержит строку',
            'ConditionNotLikeString' => '',
            'Active' => 'Событие активно',
            'activeLabel' => 'Событие активно',
            'Devices' => 'Устройства',
            'Roles' => 'Статусы',
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, \event\models\Event::className(), ['EventId']],
            'DeviceLinks' => [self::HAS_MANY, EventLinkDevice::className(), ['EventId']],
            'RoleLinks' => [self::HAS_MANY, EventLinkRole::className(), ['EventId']],
        ];
    }

    /**
     * Текстовое представление флага активности
     * @return string
     */
    public function getActiveLabel()
    {
        return $this->Active ? 'Активен' : 'Неактивен';
    }

    /**
     * Путь для сохранения файлов
     * @return string
     */
    public function getFilePath()
    {
        return \Yii::getPathOfAlias('webroot.paperless.event');
    }
}