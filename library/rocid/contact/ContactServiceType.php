<?php

/**
 * @property int $ServiceTypeId
 * @property string $Title
 * @property string $AccountUrlMask
 * @property string $Protocol
 * @property int $IsMessenger
 */
class ContactServiceType extends CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactServiceType';
  }
  
  public function primaryKey()
  {
    return 'ServiceTypeId';
  }
  
  public function relations()
  {
    return array(
      
    );
  }

  /**
   * @static
   * @return ContactServiceType[]
   */
  public static function GetAll()
  {
    $contactType = ContactServiceType::model();
    return $contactType->findAll();
  }
}