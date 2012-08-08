<?php
namespace contact\models;

/**
 * @property int $ServiceId
 * @property int $ServiceTypeId
 * @property string $Account
 * @property int $Visibility
 */
class ServiceAccount extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactServiceAccount';
  }
  
  public function primaryKey()
  {
    return 'ServiceId';
  }
  
  public function relations()
  {
    return array(
      'ServiceType' => array(self::BELONGS_TO, 'ContactServiceType', 'ServiceTypeId'),
    );
  }

  public function ChangeUser($oldUserId, $newUserId)
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update('Link_User_ContactServiceAccount', array('UserId'=>$newUserId), 'UserId=:OldUserId AND ServiceId=:ServiceId', array(':OldUserId'=>$oldUserId, ':ServiceId'=>$this->ServiceId));
  }

  public function ChangeCompany($oldCompanyId, $newCompanyId)
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update('Link_Company_ContactServiceAccount', array('CompanyId'=>$newCompanyId), 'CompanyId=:OldCompanyId AND ServiceId=:ServiceId', array(':OldCompanyId'=>$oldCompanyId, ':ServiceId'=>$this->ServiceId));
  }
}
