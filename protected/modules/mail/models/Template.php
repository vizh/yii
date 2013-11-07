<?php
namespace mail\models;

/**
 * Class Template
 * @package mail\models
 *
 * @property int $Id
 * @property string $Type
 * @property int $EventId
 * @property string $Filter
 * @property string $Title
 * @property string $Path
 *
 */
class Template extends \CActiveRecord
{

  /**
   * @param string $className
   *
   * @return Template
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'MailTemplate';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  protected $typeComponent = null;

  public function getTypeComponent()
  {
    return null;//new $class($this);
  }

  public function send($count)
  {

  }
}