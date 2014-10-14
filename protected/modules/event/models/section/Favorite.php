<?php
namespace event\models\section;

/**
 * Class Favorite
 * @package event\models\section
 *
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 * @property boolean $Deleted
 * @property string $UpdateTime
 *
 * @property Section $Section
 * @property \user\models\User $User
 *
 * @method Favorite find($condition='',$params=array())
 * @method Favorite findByPk($pk,$condition='',$params=array())
 * @method Favorite[] findAll($condition='',$params=array())
 */

class Favorite extends \CActiveRecord
{
    /**
     * @param string $className
     * @return Favorite
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'EventSectionFavorite';
    }

    public function primaryKey()
    {
        return 'Id';
    }

    public function relations()
    {
        return array(
            'Section' => [self::BELONGS_TO, '\event\models\section\Section', 'SectionId'],
            'User' => [self::BELONGS_TO, '\user\models\User', 'UserId'],
        );
    }

    /**
     * @param int $userId
     * @param bool $useAnd
     * @return $this
     */
    public function byUserId($userId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."UserId" = :UserId';
        $criteria->params = ['UserId' => $userId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param int $sectionId
     * @param bool $useAnd
     * @return $this
     */
    public function bySectionId($sectionId, $useAnd = true)
    {
        $criteria = new \CDbCriteria();
        $criteria->condition = '"t"."SectionId" = :SectionId';
        $criteria->params = ['SectionId' => $sectionId];
        $this->getDbCriteria()->mergeWith($criteria, $useAnd);
        return $this;
    }

    /**
     * @param bool $deleted
     * @param bool $useAnd
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