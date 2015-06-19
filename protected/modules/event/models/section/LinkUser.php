<?php
namespace event\models\section;
use application\components\ActiveRecord;

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
 * @property string $DeletionTime
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
 *
 * @method LinkUser byUserId(int $userId)
 * @method LinkUser bySectionId(int $sectionId)
 * @method LinkUser byDeleted(bool $deleted)
 */
class LinkUser extends ActiveRecord
{
    protected $useSoftDelete = true;

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
     * @param int $eventId
     * @param bool $useAnd
     * @return $this
     */
    public function byEventId($eventId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Section'];
        $criteria->condition = '"Section"."EventId" = :EventId';
        $criteria->params = ['EventId' => $eventId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    protected function beforeSave()
    {
        $this->UpdateTime = date('Y-m-d H:i:s');
        return parent::beforeSave();
    }
}