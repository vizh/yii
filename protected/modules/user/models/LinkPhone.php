<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $PhoneId
 *
 * @property User $User
 * @property \contact\models\Phone $Phone
 */
class LinkPhone extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkPhone
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkPhone';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Phone' => array(self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'),
    );
  }
}
