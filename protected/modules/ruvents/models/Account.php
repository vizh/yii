<?php
namespace ruvents\models;

/**
 * Class Account
 * @package ruvents\models
 *
 * @property int $Id
 * @property int $EventId
 * @property string $Hash
 *
 * @property \event\models\Event $Event
 */
class Account extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return Account
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'RuventsAccount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
        'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
    ];
  }

  /**
   * @param string $hash
   * @param bool $useAnd
   * @return Account
   */
  public function byHash($hash, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Hash" = :Hash';
    $criteria->params = ['Hash' => $hash];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}