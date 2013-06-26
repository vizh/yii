<?php
namespace company\models;

/**
 * @property int $Id
 * @property int $UserId
 * @property int $EmailId
 *
 * @property Company $User
 * @property \contact\models\Email $Email
 */
class LinkEmail extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkEmail
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'CompanyLinkEmail';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Company' => array(self::BELONGS_TO, '\company\models\Company', 'CompanyId'),
      'Email' => array(self::BELONGS_TO, '\contact\models\Email', 'EmailId'),
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
  
  public function byEmailId($emailId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EmailId" = :EmailId';
    $criteria->params = array(':EmailId' => $emailId);
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
