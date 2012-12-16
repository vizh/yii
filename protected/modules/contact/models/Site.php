<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $Url
 * @property bool $Secure
 */
class Site extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Site
   */
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
    return array();
  }
}
