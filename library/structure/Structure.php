<?php

/**
 * @property int $StructureId
 * @property int $ParentId
 * @property string $Name
 * @property string $Module
 * @property string $Section
 * @property string $Command
 * @property string $SectionDir
 * @property string $Title
 * @property string $ShowInMenu
 */
class Structure extends CActiveRecord
{
  const TypeModule = 'module';
  const TypeSection = 'section';
  const TypeCommand = 'command';

  public static $TableName = 'Core_Structure';

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
    return 'StructureId';
  }

  public function relations()
  {
    return array();
  }

  /**
   * @var int
   */
  public $FirstChildId = null;

  /**
   * @static
   * @param int $structureId
   * @return Structure
   */
  public static function GetById($structureId)
  {
    return Structure::model()->findByPk($structureId);
  }

  /**
   * @static
   * @return Structure[]|null
   */
  public static function GetAll()
  {
    $criteria = new CDbCriteria();
    $criteria->order = 'ShowInMenu ASC';
    return Structure::model()->findAll($criteria);
  }

  /**
   * @static
   * @param string $name
   * @param array $route
   * @param int|null $parentId
   * @return Structure
   */
  public static function GetOrCreate($name, $route, $parentId)
  {
    $structure = Structure::model();
    $criteria = new CDbCriteria();
    $criteria->condition = 'Module = :Module AND SectionDir = :SectionDir
      AND Section = :Section AND Command = :Command';
    $criteria->params = array(':Module' => $route['Module'], ':SectionDir' => $route['SectionDir'],
      ':Section' => $route['Section'], ':Command' => $route['Command']);
    if ($parentId == null)
    {
      $criteria->condition .= ' AND ParentId IS NULL';
    }
    else
    {
      $criteria->condition .= ' AND ParentId = :ParentId ';
      $criteria->params[':ParentId'] = $parentId;
    }

    $structure = $structure->find($criteria);

    if ($structure == null)
    {
      $structure = new Structure();
      $structure->Name = $name;
      $structure->ParentId = $parentId;
      $structure->Module = $route['Module'];
      $structure->SectionDir = $route['SectionDir'];
      $structure->Section = $route['Section'];
      $structure->Command = $route['Command'];
      $structure->save();
    }

    return $structure;    
  }
}
