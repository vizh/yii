<?php
AutoLoader::Import('library.rocid.user.*');
/**
 * @property int $UserInrerestPersonId
 * @property int $UserId
 * @property int $InterestUserId
 */
class UserInterestPerson extends CActiveRecord
{
  public static $TableName = 'UserInterestPerson';

  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::$TableName;
  }
  
  public function primaryKey()
  {
    return 'UserInterestPersonId';
  }
  
  public function relations()
  {
    return array(       
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'InterestPerson' => array(self::BELONGS_TO, 'User', 'InterestPersonId'),
    );
  }

  /**
   * @static
   * @param int $userId
   * @param int $interestUserId
   * @return UserInterestPerson
   */
  public static function GetUserInterestPerson($userId, $interestUserId)
  {
    $interest = UserInterestPerson::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.InterestUserId = :InterestUserId';
    $criteria->params = array(':UserId' => $userId, ':InterestUserId' => $interestUserId);
    return $interest->find($criteria);
  }

  /**
   * @static
   * @param int $userId
   * @return UserInterestPerson[]
   */
  public static function GetInterestPersons($userId)
  {
    $interest = UserInterestPerson::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId';
    $criteria->params = array(':UserId' => $userId);
    return $interest->findAll($criteria);
  }
}