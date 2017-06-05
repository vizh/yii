<?php
namespace application\models\admin;

/**
 * @property int $Id
 * @property int $GroupId
 * @property string $Code
 * @property string $Title
 */
class GroupRole extends \CActiveRecord
{
    /**
     * @param string $className
     * @return GroupRole
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AdminGroupRole';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return [];
    }
}
