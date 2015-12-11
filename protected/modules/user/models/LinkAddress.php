<?php
namespace user\models;
use application\components\ActiveRecord;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $AddressId
 *
 * @property User $User
 * @property \contact\models\Address $Address
 */
class LinkAddress extends ActiveRecord
{
  /**
   * @param string $className
   * @return LinkAddress
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkAddress';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Address' => array(self::BELONGS_TO, '\contact\models\Address', 'AddressId'),
    );
  }
}
