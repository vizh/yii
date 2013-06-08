<?php
namespace partner\models;

/**
 * Class Import
 * @package partner\models
 *
 * @property int $Id
 * @property int $EventId
 * @property string $Settings
 * @property string $CreationTime
 *
 * @method \partner\models\Import findByPk()
 */
class Import extends \CActiveRecord
{
  /**
   * @static
   * @param string $className
   * @return Import
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'PartnerImport';
  }

  public function primaryKey()
  {
    return 'Id';
  }


}