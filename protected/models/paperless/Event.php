<?php

namespace application\models\paperless;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;
use application\components\mail\MailBuilder;
use CLogger;
use Yii;

/**
 * @property int $Id
 * @property int $EventId
 * @property bool $Active
 * @property string $Subject
 * @property string $Text
 * @property string $File
 * @property bool $SendOnce
 * @property bool $ConditionLike
 * @property string $ConditionLikeString
 * @property bool $ConditionNotLike
 * @property bool $ConditionNotLikeString
 *
 * @property \event\models\Event $Event
 * @property EventLinkDevice[] $DeviceLinks
 * @property EventLinkRole[] $RoleLinks
 *
 * Описание вспомогательных методов
 * @method Event   with($condition = '')
 * @method Event   find($condition = '', $params = [])
 * @method Event   findByPk($pk, $condition = '', $params = [])
 * @method Event   findByAttributes($attributes, $condition = '', $params = [])
 * @method Event[] findAll($condition = '', $params = [])
 * @method Event[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Event byId(int $id, bool $useAnd = true)
 * @method Event byEventId(int $id, bool $useAnd = true)
 * @method Event bySubject(string $subject, bool $useAnd = true)
 * @method Event bySendOnce(bool $once, bool $useAnd = true)
 * @method Event byConditionLike(bool $like, bool $useAnd = true)
 * @method Event byConditionNotLike(bool $notLike, bool $useAnd = true)
 * @method Event byActive(bool $active = true, bool $useAnd = true)
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
            ['EventId, Subject, Text', 'required'],
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
            'Text' => 'Содержание письма',
            'File' => 'Файл',
            'SendOnce' => 'Отправлять письмо участнику только один раз',
            'ConditionLike' => 'Отправлять только для перечисленных RunetId если удовлетворены все остальные условия (через запятую)',
            'ConditionLikeString' => '',
            'ConditionNotLike' => 'Игнорировать перечисленные RunetId (через запятую)',
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
        return Yii::getPathOfAlias('webroot.files.paperless.event');
    }

    /**
     * Обработка сигнала. Возвращает true в случае уже обработанного или
     * успешно обработанного сигнала. В случае ошибки возвращает false.
     *
     * @param DeviceSignal $signal
     * @return bool
     */
    public function process(DeviceSignal $signal)
    {
        // Фильтр ограничения по устройствам
        if ($signal->Processed || false === in_array($signal->DeviceNumber, ArrayHelper::getColumn($this->DeviceLinks, 'DeviceId'))) {
            return true;
        }

        // Фильтр повторных отправок
        if ($this->SendOnce) {
            $isProcessed = DeviceSignal::model()
                ->byEventId($signal->EventId)
                ->byDeviceNumber(ArrayHelper::getColumn($this->DeviceLinks, 'DeviceId'))
                ->byBadgeUID($signal->BadgeUID)
                ->byProcessed()
                ->exists();

            if ($isProcessed) {
                Yii::log(sprintf('Аналогичный сигнал с устройства %d о прикладывании бейджа %d из-за ограничения на повторную отправку.', $signal->DeviceNumber, $signal->BadgeUID), CLogger::LEVEL_INFO, 'paperless');
                return true;
            }
        }

        $user = $signal
            ->Participant
            ->User;

        // Фильтр ограничения по статусам участия
        if ($this->RoleLinks && !in_array($signal->Participant->RoleId, ArrayHelper::getColumn($this->RoleLinks, 'RoleId'))) {
            Yii::log(sprintf('Отсеиваем сигнал с устройства %d о прикладывании бейджа %d из-за ограничения по статусам участия.', $signal->DeviceNumber, $signal->BadgeUID), CLogger::LEVEL_INFO, 'paperless');
            return true;
        }

        // Фильтр ограничения по RunetId
        if ($this->ConditionLikeString && !in_array($user->RunetId, ArrayHelper::str2nums($this->ConditionLikeString))) {
            Yii::log(sprintf('Отсеиваем сигнал с устройства %d о прикладывании бейджа %d из-за ограничения по RunetId.', $signal->DeviceNumber, $signal->BadgeUID), CLogger::LEVEL_INFO, 'paperless');
            return true;
        }

        // Фильтр исключения по RunetId
        if ($this->ConditionNotLike && in_array($user->RunetId, ArrayHelper::str2nums($this->ConditionNotLikeString))) {
            Yii::log(sprintf('Отсеиваем сигнал с устройства %d о прикладывании бейджа %d из-за исключения по RunetId.', $signal->DeviceNumber, $signal->BadgeUID), CLogger::LEVEL_INFO, 'paperless');
            return true;
        }

        MailBuilder::create()
            ->setTo($user)
            ->setFrom('users@runet-id.com', 'RUNET-ID/Paperless')
            ->setSubject($this->Subject)
            ->setBody($this->Text)
            ->addAttachment($this->getFilePath().'/'.$this->File)
            ->send();

        $signal->Processed = true;
        $signal->ProcessedTime = date(RUNETID_TIME_FORMAT);

        return $signal->save(true);
    }
}