<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $PhoneId
 *
 * @property User $User
 * @property \contact\models\Phone $Phone
 */
class LinkPhone extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkPhone
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkPhone';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Phone' => array(self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'),
    );
  }
  
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array(':UserId' => $userId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byPhoneId($phoneId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."PhoneId" = :PhoneId';
    $criteria->params = array(':PhoneId' => $phoneId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
