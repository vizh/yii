<?php
namespace raec\models;

/**
 * Class BriefUserRole
 * @property int $Id
 * @property string $Title
 * @package raec\models
 */
class BriefUserRole extends \CActiveRecord
{
    /**
     * @param string $className
     * @return BriefUserRole
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'RaecBriefUserRole';
    }

    public function primaryKey()
    {
        return 'Id';
    }
} 