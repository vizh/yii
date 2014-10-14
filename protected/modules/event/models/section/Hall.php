<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $UpdateTime
 * @property int $Order
 * @property bool $Deleted
 *
 * @method Hall find($condition='',$params=array())
 * @method Hall findByPk($pk,$condition='',$params=array())
 * @method Hall[] findAll($condition='',$params=array())
 */
class Hall extends \application\models\translation\ActiveRecord
{
    /**
     * @param string $className
     *
     * @return Hall
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionHall';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array();
    }

    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."EventId" = :EventId';
        $criteria->params = array('EventId' => $eventId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param boolean $deleted
     * @param boolean $useAnd
     * @return $this
     */
    public function byDeleted($deleted, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = (!$deleted ? 'NOT ' : '') . 't."Deleted"';
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param string $updateTime
     * @param bool $useAnd
     * @return $this
     */
    public function byUpdateTime($updateTime, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UpdateTime" > :UpdateTime';
        $criteria->params = ['UpdateTime' => $updateTime];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @return \string[]
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');
        return parent::beforeSave();
    }
}