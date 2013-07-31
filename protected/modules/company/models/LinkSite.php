<?php
namespace company\models;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $SiteId
 *
 * @property Company $Company
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
    return 'CompanyLinkSite';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Company' => array(self::BELONGS_TO, '\company\models\Company', 'CompanyId'),
      'Site' => array(self::BELONGS_TO, '\contact\models\Site', 'SiteId'),
    );
  }
}