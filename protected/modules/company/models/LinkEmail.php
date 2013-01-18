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
}
