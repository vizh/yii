<?php
namespace event\models;

/**
 * Class LinkPurpose
 * @package event\models
 * @property int $Id
 * @property int $EventId
 * @property int $PurposeId
 */
class LinkPurpose
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkPurpose';
  }

  public function primaryKey()
  {
    return 'Id';
  }
} 