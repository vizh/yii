<?php
namespace partner\models;

/**
 * Class ImportUser
 * @package partner\models
 *
 * @property int $Id
 * @property int $ImportId
 * @property string $LastName
 * @property string $FirstName
 * @property string $FatherName
 * @property string $Email
 * @property string $Phone
 * @property string $Company
 * @property string $Position
 * @property string $Role
 *
 * @property string $Error
 * @property bool $Imported
 *
 */
class ImportUser extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return ImportUser
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PartnerImportUser';
  }

  public function primaryKey()
  {
    return 'Id';
  }
}