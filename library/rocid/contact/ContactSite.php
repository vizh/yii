<?php
/**
 * @property int $SiteId
 * @property string $Url
 * @property int $CreationTime
 */
class ContactSite extends CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactSite';
  }
  
  public function primaryKey()
  {
    return 'SiteId';
  }
  
  public function relations()
  {
    return array(
      
    );
  }

  public function ChangeUser($oldUserId, $newUserId)
  {
    $db = Registry::GetDb();
    $db->createCommand()->update('Link_User_ContactSite', array('UserId'=>$newUserId), 'UserId=:OldUserId AND SiteId=:SiteId', array(':OldUserId'=>$oldUserId, ':SiteId'=>$this->SiteId));
  }
  
  public function ChangeCompany($oldCompanyId, $newCompanyId)
  {
    $db = Registry::GetDb();
    $db->createCommand()->update('Link_Company_ContactSite', array('CompanyId'=>$newCompanyId), 'CompanyId=:OldCompanyId AND SiteId=:SiteId', array(':OldCompanyId'=>$oldCompanyId, ':SiteId'=>$this->SiteId));
  }
}
