<?php

namespace partner\models;

use event\models\Event;
use event\models\Part;
use event\models\Role;
use user\models\User;
use application\components\ActiveRecord;
use partner\models\forms\user\Export as ExportForm;

/**
 * This is the model class for table "PartnerExport".
 *
 * The followings are the available columns in table 'PartnerExport':
 * @property integer $Id
 * @property integer $EventId
 * @property string $Config
 * @property integer $UserId
 * @property integer $TotalRow
 * @property integer $ExportedRow
 * @property bool $Success
 * @property string $SuccessTime
 * @property string $CreationTime
 * @property string $FilePath
 *
 * The followings are the available model relations:
 * @property Event $Event
 * @property User $User
 *
 * @method Export bySuccess(boolean $success)
 * @method Export[] findAll()
 * @method Export byEventId(int $id)
 * @method Export findByPk(int $id)
 * @method Export byTotalRow(int $total)
 */
class Export extends ActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Export the static model class
     */
    public static function model($className = __CLASS__)
    {
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
     * @return float|int
     */
    public function getExportedPercent()
    {
        if ($this->TotalRow == 0) {
            return 0;
        }
        return round($this->ExportedRow / $this->TotalRow * 100) ;
    }

    public function getDescription() {
        $config = json_decode($this->Config);
        $description = \Yii::t('app', 'Язык выгрузки') . ': ' . ExportForm::getLanguageData()[$config->Language] . '<br/>';
        if (!empty($config->Roles)) {
            $roles = Role::model()->findAllByPk($config->Roles);
            $description .= \Yii::t('app', 'Роли') . ': ' . implode(', ', \CHtml::listData($roles, 'Id', 'Title')) . '<br/>';
        }

        if (!empty($config->PartId)) {
            $part = Part::model()->findByPk($config->PartId);
            $description .= \Yii::t('app', 'Чать меропрития') . ': ' . $part->Title . '<br/>';
        }

        if (!empty($config->Document)) {
            $description .= \Yii::t('app', 'Добавлены паспортные данные') . '<br/>';
        }

        return $description;
    }
}