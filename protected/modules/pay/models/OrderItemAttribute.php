<?php
namespace pay\models;

/**
 * @property int $Id
 * @property int $OrderItemId
 * @property string $Name
 * @property string $Value
 */
class OrderItemAttribute extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PayOrderItemAttribute';
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