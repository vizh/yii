<?php

namespace partner\models;

use application\components\ActiveRecord;
use event\models\Event;
use event\models\Part;
use event\models\Role;
use partner\models\forms\user\Export as ExportForm;
use user\models\User;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property string $Config
 * @property int $TotalRow
 * @property int $ExportedRow
 * @property bool $Success
 * @property string $SuccessTime
 * @property string $CreationTime
 * @property string $FilePath
 *
 * @property Event $Event
 * @property User $User
 *
 * Описание вспомогательных методов
 * @method Export   with($condition = '')
 * @method Export   find($condition = '', $params = [])
 * @method Export   findByPk($pk, $condition = '', $params = [])
 * @method Export   findByAttributes($attributes, $condition = '', $params = [])
 * @method Export[] findAll($condition = '', $params = [])
 * @method Export[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method Export byId(int $id, bool $useAnd = true)
 * @method Export byUserId(int $id, bool $useAnd = true)
 * @method Export byEventId(int $id, bool $useAnd = true)
 * @method Export byTotalRow(int $success, bool $useAnd = true)
 * @method Export bySuccess(bool $success, bool $useAnd = true)
 */
class Export extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'PartnerExport';
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        ];
    }

    /**
     * Процент выполнения экспорта
     *
     * @return float|int
     */
    public function getExportedPercent()
    {
        if ($this->TotalRow == 0) {
            return 0;
        }

        return round($this->ExportedRow / $this->TotalRow * 100);
    }

    public function getDescription()
    {
        $config = json_decode($this->Config);
        $description = \Yii::t('app', 'Язык выгрузки').': '.ExportForm::getLanguageData()[$config->Language].'<br/>';
        if (!empty($config->Roles)) {
            $roles = Role::model()->findAllByPk($config->Roles);
            $description .= \Yii::t('app', 'Роли').': '.implode(', ', \CHtml::listData($roles, 'Id', 'Title')).'<br/>';
        }

        if (!empty($config->PartId)) {
            $part = Part::model()->findByPk($config->PartId);
            $description .= \Yii::t('app', 'Чать меропрития').': '.$part->Title.'<br/>';
        }

        if (!empty($config->Document)) {
            $description .= \Yii::t('app', 'Добавлены паспортные данные').'<br/>';
        }

        return $description;
    }
}