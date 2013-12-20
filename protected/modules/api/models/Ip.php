<?php
namespace api\models;

/**
 * @property int $Id
 * @property int $AccountId
 * @property string $Ip
 */
class Ip extends \CActiveRecord
{

  /**
   * @param string $className
   * @return Ip
   */
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
  
  public function byAccountId($accountId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."AccountId" = :AccountId';
    $criteria->params = array('AccountId' => $accountId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byIp($ip, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Ip" = :Ip';
    $criteria->params = array('Ip' => $ip);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}