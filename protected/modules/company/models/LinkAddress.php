<?php
namespace company\models;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $SiteId
 *
 * @property Company $Company
 * @property \contact\models\Address $Address
 */
class LinkAddress extends \CActiveRecord
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
    return 'CompanyLinkAddress';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Company' => array(self::BELONGS_TO, '\company\models\Company', 'CompanyId'),
      'Address' => array(self::BELONGS_TO, '\contact\models\Address', 'AddressId'),
    );
  }
}