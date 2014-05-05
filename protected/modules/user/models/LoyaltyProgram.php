<?php
namespace user\models;

/**
 * Class LoyaltyProgram
 * @package user\models
 *
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property string $CreationTime
 *
 * @property \event\models\Event $Event
 * @property User $User
 */
class LoyaltyProgram extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LoyaltyProgram
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLoyaltyProgram';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return [
      'Event' => [self::BELONGS_TO, '\event\models\Event', 'EventId'],
      'User' => [self::BELONGS_TO, '\user\models\User', 'UserId']
    ];
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   * @return LoyaltyProgram
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = ['UserId' => $userId];
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}