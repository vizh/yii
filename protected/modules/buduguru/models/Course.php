<?php
namespace buduguru\models;

/**
 * @property int $Id
 * @property string $Name
 * @property string $Announce
 * @property string $Url
 * @property string $DateStart
 */
class Course extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Course
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'BuduGuruCourse';
    }

    public function primaryKey()
    {
        return 'Id';
    }

/*
    public function byVisible($visible = true, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = ($visible ? '' : 'NOT ') . '"t"."Visible"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byUrl($url, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."Url" = :Url';
        $criteria->params['Url'] = $url;
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }
*/
}