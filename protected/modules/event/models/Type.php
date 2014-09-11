<?php
namespace event\models;
use application\models\translation\ActiveRecord;

/**
 * @property int $Id
 * @property string $Code
 * @property string $Title
 * @property string $CssClass
 * @property int $Priority
 *
 */
class Type extends ActiveRecord
{
  /**
   * @param string $className
   * @return Type
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventType';
  }

  public function primaryKey()
  {
    return 'Id';
  }

    /**
     * @return string[]
     */
    public function getTranslationFields()
    {
        return ['Title'];
    }
}