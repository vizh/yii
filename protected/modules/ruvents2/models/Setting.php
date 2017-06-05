<?php
namespace ruvents2\models;

use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Attributes
 *
 * @method Setting find()
 * @method Setting byEventId(int $eventId)
 */
class Setting extends ActiveRecord
{
    /**
     * @param string $className
     *
     * @return Setting
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RuventsSetting';
    }

    public function primaryKey()
    {
        return 'Id';
    }
}