<?php

/**
 * @property int $RoleId
 * @property string $Type
 * @property string $Name
 * @property int $Priority
 */
class ComissionRole extends CActiveRecord
{
  public static $TableName = 'Mod_ComissionRole';

  /**
  * @param string $className
  * @return NewsPost
  */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  public function tableName()
  {
    return self::$TableName;
  }

  public function primaryKey()
  {
    return 'RoleId';
  }

  public function relations()
  {
    return array(
//      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
//      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
//      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
//      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
//      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
    );
  }

  /**
   * @static
   * @return ComissionRole[]
   */
  public static function GetAll()
  {
    $criteria = new CDbCriteria();
    $criteria->order = 't.Priority DESC';
    return ComissionRole::model()->findAll($criteria);
  }
}
