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
  
  public function byAccountId($accountId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."AccountId" = :AccountId';
    $criteria->params = array('AccountId' => $accountId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byDomain($domain, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Domain" = :Domain';
    $criteria->params = array('Domain' => $domain);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}