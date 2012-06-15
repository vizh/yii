<?php

class OrderItemParam extends CActiveRecord
{
  public static $TableName = 'Mod_PayOrderItemParam';

    public static function model($className=__CLASS__)
    {
      return parent::model($className);
    }

    public function tableName()
    {
      return self::$TableName;
    }

    public function primaryKey()
    {
      return 'OrderItemParamId';
    }

    public function relations()
    {
      return array();
    }
}