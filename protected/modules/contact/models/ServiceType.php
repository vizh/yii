<?php
namespace contact\models;

/**
 * @property int $ServiceTypeId
 * @property string $Title
 * @property string $AccountUrlMask
 * @property string $Protocol
 * @property int $IsMessenger
 */
class ServiceType extends \CActiveRecord
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
   * @return ServiceType[]
   */
  public static function GetAll()
  {
    $contactType = ServiceType::model();
    return $contactType->findAll();
  }
}