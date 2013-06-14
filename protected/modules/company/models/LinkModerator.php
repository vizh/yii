<?php
namespace company\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $CompanyId
 *
 * @property \user\models\User $User
 */
class LinkModerator extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkModerator
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompanyLinkModerator';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\User\models\User', 'UserId')
    );
  }
  
  public function byCompanyId($companyId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."CompanyId" = :CompanyId';
    $criteria->params = array(':CompanyId' => $companyId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array(':UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
