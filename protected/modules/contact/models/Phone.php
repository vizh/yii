<?php
namespace contact\models;

/**
 * @property int $PhoneId
 * @property string $Phone
 * @property int $Primary
 * @property string $Type
 */
class Phone extends \CActiveRecord
{
  const TypePersonal = 'personal';
  const TypeHome = 'home';
  const TypeMobile = 'mobile';
  const TypeSecretary = 'secretary';
  const TypeFax = 'fax';
  const TypeWork = 'work';

  const TableName = 'ContactPhone';

  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return self::TableName;
  }
  
  public function primaryKey()
  {
    return 'PhoneId';
  }
  
  public function relations()
  {
    return array(
      
    );
  }

  /**
   * @static
   * @param int $userId
   * @return void
   */
  public static function ResetAllUserPrimary($userId)
  {
//  todo: Need fix it
//    Yii::app()->db->createCommand()->update(self::TableName, array('Primary' => 0),
//                                            'UserId = :UserId', array(':UserId' => $userId));
  }

  public function ChangeUser($oldUserId, $newUserId)
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update('Link_User_ContactPhone', array('UserId'=>$newUserId), 'UserId=:OldUserId AND PhoneId=:PhoneId', array(':OldUserId'=>$oldUserId, ':PhoneId'=>$this->PhoneId));
  }
  
  public function ChangeCompany($oldCompanyId, $newCompanyId)
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update('Link_Company_ContactPhone', array('CompanyId'=>$newCompanyId), 'CompanyId=:OldCompanyId AND PhoneId=:PhoneId', array(':OldCompanyId'=>$oldCompanyId, ':PhoneId'=>$this->PhoneId));
  }
}
