<?php
namespace event\models\section;

/**
 * @property int $Id
 * @property int $SectionId
 * @property int $ThemeId
 *
 * @property Section $Section
 * @property Theme $Theme
 */
class LinkTheme extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return LinkTheme
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return 'EventSectionLinkTheme';
  }

  public function primaryKey()
  {
    return 'Id';
  }

  public function relations()
  {
    return array(
      'Section' => array(self::BELONGS_TO, '\event\models\section\Section', 'SectionId'),
      'Theme' => array(self::BELONGS_TO, '\event\models\section\Theme', 'ThemeId'),
    );
  }

}
