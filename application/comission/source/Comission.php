<?php

/**
 * @property int $ComissionId
 * @property string $Title
 * @property string $Description
 * @property string $Url
 * @property int $CreationTime
 *
 * @property ComissionUser[] $ComissionUsers
 */
class Comission extends CActiveRecord
{
  public static $TableName = 'Mod_Comission';

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
    return 'ComissionId';
  }

  public function relations()
  {
    return array(
//      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
//      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
//      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
//      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
//      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
      'ComissionUsers' => array(self::HAS_MANY, 'ComissionUser', 'ComissionId'),
    );
  }

  /**
   * @static
   * @param int $id
   * @return Comission
   */
  public static function GetById($id)
  {
    $comission = Comission::model();
    return $comission->findByPk($id);
  }

  /**
   * @static
   * @return Comission[]
   */
  public static function GetAll($withDeleted = false)
  {
    $comission = Comission::model()->with('ComissionUsers');
    $criteria = new CDbCriteria();
    if (! $withDeleted)
    {
      $criteria->condition = 't.Deleted = 0';
    }
    return $comission->findAll($criteria);
  }
}
