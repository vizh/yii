<?php
/**
 * @property int $EmailId
 * @property string $Email
 * @property string $Primary
 */
class ContactEmail extends CActiveRecord
{
  public static $TableName = 'ContactEmail';
  
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
    return 'EmailId';
  }
  
  public function relations()
  {
    return array(
      
    );
  }
  
  public static function GetCountEmails($email)
  {
    $criteria = new CDbCriteria();
    $criteria->condition = 't.Email LIKE :Email';
    $criteria->params = array(':Email' => Lib::PrepareSqlStringForLike($email));
    
    $contactEmail = ContactEmail::model();
    return $contactEmail->count($criteria);
  }

  public function ChangeUser($oldUserId, $newUserId)
  {
    $db = Registry::GetDb();
    $db->createCommand()->update('Link_User_ContactEmail', array('UserId'=>$newUserId), 'UserId=:OldUserId AND EmailId=:EmailId', array(':OldUserId'=>$oldUserId, ':EmailId'=>$this->EmailId));
  }

  public function ChangeCompany($oldCompanyId, $newCompanyId)
  {
    $db = Registry::GetDb();
    $db->createCommand()->update('Link_Company_ContactEmail', array('CompanyId'=>$newCompanyId), 'CompanyId=:OldCompanyId AND EmailId=:EmailId', array(':OldCompanyId'=>$oldCompanyId, ':EmailId'=>$this->EmailId));
  }
}