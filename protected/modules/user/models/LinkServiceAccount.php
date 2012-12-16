<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $ServiceAccountId
 *
 * @property User $User
 * @property \contact\models\ServiceAccount $ServiceAccount
 */
class LinkServiceAccount extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkServiceAccount
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkServiceAccount';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'ServiceAccount' => array(self::BELONGS_TO, '\contact\models\ServiceAccount', 'ServiceAccountId'),
    );
  }
}