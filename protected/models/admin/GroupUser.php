<?php
namespace application\models\admin;

class GroupUser extends \CActiveRecord
{
    /**
     * @param string $className
     * @return GroupUser
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'AdminGroupUser';
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
