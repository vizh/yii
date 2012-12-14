<?php
namespace contact\models;

/**
 * @property int $Id
 * @property string $Email
 * @property bool $Verified
 */
class Email extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'ContactEmail';
  }
  
  public function primaryKey()
  {
    return 'Id';
  }
  
  public function relations()
  {
    return array();
  }

}