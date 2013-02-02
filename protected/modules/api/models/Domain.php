<?php
namespace api\models;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Domain
 */
class Domain extends \CActiveRecord
{

  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'ApiDomain';
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