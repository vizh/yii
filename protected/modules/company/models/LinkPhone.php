<?php
namespace company\models;

/**
 * @property int $Id
 * @property int $CompanyId
 * @property int $PhoneId
 *
 * @property Company $User
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
    return 'CompanyLinkPhone';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Company' => array(self::BELONGS_TO, '\company\models\Company', 'CompanyId'),
      'Phone' => array(self::BELONGS_TO, '\contact\models\Phone', 'PhoneId'),
    );
  }
  
  public function byCompanyId($companyId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."CompanyId" = :CompanyId';
    $criteria->params = array(':CompanyId' => $companyId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byPhoneId($phoneId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."PhoneId" = :PhoneId';
    $criteria->params = array(':PhoneId' => $phoneId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}

