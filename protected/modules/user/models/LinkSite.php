<?php
namespace user\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $SiteId
 *
 * @property User $User
 * @property \contact\models\Site $Site
 */
class LinkSite extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkSite
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkSite';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),
      'Site' => array(self::BELONGS_TO, '\contact\models\Site', 'SiteId'),
    );
  }
}