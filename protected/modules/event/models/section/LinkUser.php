<?php
namespace event\models\section;

use application\models\translation\ActiveRecord;
use company\models\Company;
use user\models\User;

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
 * @property User $User
 * @property Role $Role
 * @property Report $Report
 * @property Company $Company
 *
 * Описание вспомогательных методов
 * @method LinkUser   with($condition = '')
 * @method LinkUser   find($condition = '', $params = [])
 * @method LinkUser   findByPk($pk, $condition = '', $params = [])
 * @method LinkUser   findByAttributes($attributes, $condition = '', $params = [])
 * @method LinkUser[] findAll($condition = '', $params = [])
 * @method LinkUser[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method LinkUser byId(int $id, bool $useAnd = true)
 * @method LinkUser bySectionId(int $id, bool $useAnd = true)
 * @method LinkUser byUserId(int $id, bool $useAnd = true)
 * @method LinkUser byRoleId(int $id, bool $useAnd = true)
 * @method LinkUser byReportId(int $id, bool $useAnd = true)
 * @method LinkUser byCompanyId(int $id, bool $useAnd = true)
 * @method LinkUser byDeleted(bool $deleted, bool $useAnd = true)
 */
class LinkUser extends ActiveRecord
{
    protected $useSoftDelete = true;

    /**
     * @param string $className
     * @return LinkUser
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionLinkUser';
    }

    public function relations()
    {
        return [
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
            'Company' => [self::BELONGS_TO, '\company\models\Company', 'CompanyId'],
            'Report' => [self::BELONGS_TO, '\event\models\section\Report', 'ReportId'],
            'Role' => [self::BELONGS_TO, '\event\models\section\Role', 'RoleId'],
        ];
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

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['CustomText'];
    }
}