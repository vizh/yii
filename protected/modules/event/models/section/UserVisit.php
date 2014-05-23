<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $HallId
 * @property int $UserId
 * @property string VisitTime
 * @property string CreationTime
 */
class UserVisit extends \CActiveRecord
{
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionUserVisit';
  }

  public function primaryKey()
  {
    return 'Id';
  }
}