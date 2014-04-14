<?php
namespace event\models\section;

/**
 * Class Favorite
 * @package event\models\section
 *
 * @property int $Id
 * @property int $SectionId
 * @property int $UserId
 *
 * @property Section $Section
 * @property \user\models\User $User
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
      'Section' => array(self::BELONGS_TO, '\event\models\section\Section', 'SectionId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
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
} 