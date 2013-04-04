<?php
namespace pay\models;

/**
 * @property int $Id
 * @property string $Message
 * @property int $Code
 * @property string $Info
 * @property string $PaySystem
 * @property bool $Error
 * @property string $OrderId
 * @property int $Total
 * @property string $CreationTime
 *
 * @property Order $Order
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
    return 'PayLog';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Order' => array(self::BELONGS_TO, '\pay\models\Order', 'OrderId'),
    );
  }

  /**
   * @param $orderId
   * @param bool $useAnd
   *
   * @return Log
   */
  public function byOrderId($orderId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."OrderId" = :OrderId';
    $criteria->params = array('OrderId' => $orderId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
