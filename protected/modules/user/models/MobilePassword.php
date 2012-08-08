<?php
namespace user\models;

/**
 * @property int $UserMobilePasswordId
 * @property int $UserId
 * @property string $Password
 * @property int $ExpireTime
 */
class MobilePassword extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {    
    return parent::model($className);
  }
  
  public function tableName()
  {
    return 'UserMobilePassword';
  }
  
  public function primaryKey()
  {
    return 'UserMobilePasswordId';
  }
  
  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
    );
  }
}