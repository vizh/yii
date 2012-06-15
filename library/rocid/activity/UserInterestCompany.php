<?php
AutoLoader::Import('library.rocid.user.*');
AutoLoader::Import('library.rocid.company.*');

/**
 * @property int $UserInrerestCompanyId
 * @property int $UserId
 * @property int $CompanyId
 */
class UserInterestCompany extends CActiveRecord
{
  public static $TableName = 'UserInterestCompany';

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
    return 'UserInterestCompanyId';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Company' => array(self::BELONGS_TO, 'Company', 'CompanyId')
    );
  }

  /**
   * @static
   * @param int $userId
   * @param int $companyId
   * @return UserInterestCompany
   */
  public static function GetUserInterestCompany($userId, $companyId)
  {
    $interest = UserInterestCompany::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.CompanyId = :CompanyId';
    $criteria->params = array(':UserId' => $userId, ':CompanyId' => $companyId);
    return $interest->find($criteria);
  }
}