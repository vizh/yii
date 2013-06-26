<?php
namespace mail\models;

/**
 * @property int $Id
 * @property string $From
 * @property string $To
 * @property string $Subject
 * @property string $Time
 * @property string $Hash
 * @property string $Error
 *
 */
class Log extends \CActiveRecord
{

  /**
   * @param string $className
   *
   * @return Log
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'MailLog';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  /**
   * @param $orderId
   * @param bool $useAnd
   *
   * @return Log
   */
  public function byHash($hash, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Hash" = :Hash';
    $criteria->params = array('Hash' => $hash);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
