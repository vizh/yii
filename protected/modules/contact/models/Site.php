<?php
namespace contact\models;

/**
 * @property int $SiteId
 * @property string $Url
 * @property int $CreationTime
 */
class Site extends \CActiveRecord
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
    $db = \Yii::app()->getDb();
    $db->createCommand()->update('Link_User_ContactSite', array('UserId'=>$newUserId), 'UserId=:OldUserId AND SiteId=:SiteId', array(':OldUserId'=>$oldUserId, ':SiteId'=>$this->SiteId));
  }
  
  public function ChangeCompany($oldCompanyId, $newCompanyId)
  {
    $db = \Yii::app()->getDb();
    $db->createCommand()->update('Link_Company_ContactSite', array('CompanyId'=>$newCompanyId), 'CompanyId=:OldCompanyId AND SiteId=:SiteId', array(':OldCompanyId'=>$oldCompanyId, ':SiteId'=>$this->SiteId));
  }
}
