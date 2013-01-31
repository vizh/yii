<?php
namespace event\models;

/**
 * @property int $Id
 * @property int TagId
 * @property int $EventId
 *
 * @property \tag\models\Tag $Tag
 */
class LinkTag extends \CActiveRecord
{
  /**
   * @param string $className
   * @return LinkTag
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventLinkTag';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Tag' => array(self::BELONGS_TO, '\tag\models\Tag', 'TagId'),
    );
  }
}