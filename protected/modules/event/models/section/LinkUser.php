<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 * @property int $RoleId
 * @property int $ReportId
 * @property int $Order
 * @property int $CompanyId
 * @property string $CustomText
 * @property string $VideoUrl
 * @property string $UpdateTime
 * @property bool $Deleted
 *
 * @property Section $Section
 * @property \user\models\User $User
 * @property Role $Role
 * @property Report $Report
 * @property \company\models\Company $Company
 *
 * @method LinkUser find($condition='',$params=array())
 * @method LinkUser findByPk($pk,$condition='',$params=array())
 * @method LinkUser[] findAll($condition='',$params=array())
 */
class LinkUser extends \CActiveRecord
{
    /**
     * @param string $className
     *
     * @return LinkUser
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionLinkUser';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Section' => array(self::BELONGS_TO, '\event\models\section\Section', 'SectionId'),
            'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
            'Company' => array(self::BELONGS_TO, '\company\models\Company', 'CompanyId'),
            'Report' => array(self::BELONGS_TO, '\event\models\section\Report', 'ReportId'),
            'Role' => array(self::BELONGS_TO, '\event\models\section\Role', 'RoleId'),
        );
    }

    public function bySectionId($sectionId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."SectionId" = :SectionId';
        $criteria->params = array('SectionId' => $sectionId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = array('Section');
        $criteria->condition = '"Section"."EventId" = :EventId';
        $criteria->params = array('EventId' => $eventId);
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = array('UserId' => $userId);
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

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');
        return parent::beforeSave();
    }
}