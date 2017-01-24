<?php
namespace event\models\section;
use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property int $EventId
 * @property string $Title
 * @property string $UpdateTime
 * @property int $Order
 * @property bool $Deleted
 * @property bool $DeletionTIme
 *
 * @method Hall find($condition='',$params=array())
 * @method Hall findByPk($pk,$condition='',$params=array())
 * @method Hall[] findAll($condition='',$params=array())
 * @method Hall byDeleted(boolean $deleted)
 * @method Hall byEventId(integer $eventId)
 */
class Hall extends ActiveRecord
{
    protected $useSoftDelete = true;

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