<?php
namespace api\models;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Ip
 */
class Ip extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'ApiIP';
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