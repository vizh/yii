<?php

/**
 * @property int $MenuId
 * @property int $ParentId
 * @property int $StructureId
 * @property string $Title
 * @property int $Position
 */
class Menu extends CActiveRecord
{
  public static $TableName = 'Core_Menu';

  /**
   * @param string $className
   * @return Structure
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
    return 'MenuId';
  }

  public function relations()
  {
    return array(
      'Structure' => array(self::HAS_ONE, 'Structure', 'StructureId'),
      'Childs' => array(self::HAS_MANY, 'Menu', 'ParentId')
    );
  }

  public static function GetById($menuId)
  {
    return Menu::model()->findByPk($menuId);
  }

  /**
   * @static
   * @param int|null $parentId
   * @return Menu[]
   */
  public static function GetByParent($parentId)
  {
    $menu = Menu::model();

    $criteria = new CDbCriteria();
    if ($parentId == null)
    {
      $menu = $menu->with(array('Structure', 'Childs' => array('order'=>'Childs.Position ASC')));
      $criteria->condition = 't.ParentId IS NULL';
    }
    else
    {
      $criteria->condition = 'ParentId = :ParentId';
      $criteria->params[':ParentId'] = $parentId;
    }

    return $menu->findAll($criteria);
  }
}