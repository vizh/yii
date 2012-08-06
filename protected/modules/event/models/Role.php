<?php
namespace event\models;

/**
 * @property int $RoleId
 * @property string $Type
 * @property string $Name
 * @property int $Priority
 */
class Role extends \CActiveRecord
{
  public static $TableName = 'EventRoles';
  
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
      );
  }


  /**
   * @static
   * @param int $id
   * @return Role
   */
  public static function GetById($id)
  {
    return Role::model()->findByPk($id);
  }

  private static $roles = null;
  /**
   * @static
   * @return Role[]
   */
  public static function GetAll()
  {
    if (self::$roles === null)
    {
      $model = Role::model();
      $criteria = new \CDbCriteria();
      $criteria->order = 't.RoleId';
      self::$roles = $model->findAll($criteria);
    }

    return self::$roles;
  }

  /**
  * Геттеры и сеттеры для полей
  */
  public function GetRoleId()
  {
    return $this->RoleId;
  }
  
  //Type
  public function GetType()
  {
    return $this->Type;
  }
  
  public function SetType($value)
  {
    $this->Type = $value;
  }
  
  //Name
  public function GetName()
  {
    return $this->Name;
  }
  
  public function SetName($value)
  {
    $this->Name = $value;
  }
}