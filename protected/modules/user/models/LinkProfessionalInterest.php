<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ProfessionalInterestId
 *
 * @property User $User
 * @property \application\models\ProfessionalInterest $ProfessionalInterest
 */
class LinkProfessionalInterest extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkProfessionalInterest
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkProfessionalInterest';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'ProfessionalInterest' => array(self::BELONGS_TO, '\application\models\ProfessionalInterest', 'ProfessionalInterestId'),
    );
  }
  
  public function byProfessionalInterestId($professionalInterestId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."ProfessionalInterestId" = :ProfessionalInterestId';
    $criteria->params = array(':ProfessionalInterestId' => $professionalInterestId);
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
