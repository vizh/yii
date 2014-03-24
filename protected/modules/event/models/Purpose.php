<?php
namespace event\models;

/**
 * Class Purpose
 * @package event\models
 * @property int $Id
 * @property string $Title
 */
class Purpose extends \CFormModel
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventPurpose';
  }

  public function primaryKey()
  {
    return 'Id';
  }
} 