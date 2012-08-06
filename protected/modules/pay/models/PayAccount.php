<?php
namespace pay\models;

/**
 * @property int $AccountId
 * @property int $EventId
 * @property string $Login
 * @property string $Password
 * @property string $System
 * @property string $SystemParams
 * @property string $JuridicalParams
 */
class PayAccount extends \CActiveRecord
{
  public static $TableName = 'Mod_PayAccount';

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
    return 'AccountId';
  }

  /**
   * @static
   * @param $eventId
   * @return PayAccount
   */
  public static function GetByEventId($eventId)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params = array(':EventId' => $eventId);
    return PayAccount::model()->find($criteria);
  }

  /**
   * @param array $params
   */
  public function SetSystemParams($params)
  {
    $this->SystemParams = base64_encode(serialize($params));
  }
  /**
   * @return array
   */
  public function GetSystemParams()
  {
    return unserialize(base64_decode($this->SystemParams));
  }

  /**
   * @param array $params
   */
//  public function SetJuridicalParams($params)
//  {
//    $this->JuridicalParams = base64_encode(serialize($params));
//  }
  /**
   * @return array
   */
//  public function GetJuridicalParams()
//  {
//    return unserialize(base64_decode($this->JuridicalParams));
//  }
}