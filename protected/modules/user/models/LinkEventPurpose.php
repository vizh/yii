<?php
namespace user\models;

/**
 * Class LinkEventPurpose
 * @package user\models
 * @property int $Id
 * @property int $UserId
 * @property int $EventId
 * @property int $PurposeId
 */
class LinkEventPurpose
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'UserLinkEventPurpose';
  }

  public function primaryKey()
  {
    return 'Id';
  }
} 