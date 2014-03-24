<?php
namespace event\models;

/**
 * Class PurposeLinkPurpose
 * @package event\models
 * @property int $Id
 * @property int $FirstPurposeId
 * @property int $SecondPurposeId
 */
class Purpose extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventPurposeLink';
  }

  public function primaryKey()
  {
    return 'Id';
  }
} 