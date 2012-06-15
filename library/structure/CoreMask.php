<?php

/**
 * @property int $MaskId
 * @property string $Title
 * @property string $Data
 * @property string $Type
 */
class CoreMask extends CActiveRecord
{
  const TypeSystem = 'system';
  const TypePersonal = 'personal';

  const AdminMaskId = 1;

  public static $TableName = 'Core_Mask';

  private $dataClear = null;

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
    return 'MaskId';
  }

  public function relations()
  {
    return array();
  }

  protected function beforeDelete()
  {
    $command = Registry::GetDb()->createCommand();
    $command->delete('Core_Link_GroupMask', 'MaskId = :MaskId', array(':MaskId' => $this->MaskId));

    return parent::beforeDelete();
  }

  /**
   * @static
   * @param int $structureId
   * @return CoreMask
   */
  public static function GetById($maskId)
  {
    return CoreMask::model()->findByPk($maskId);
  }

  /**
   * @static
   * @return CoreMask[]|null
   */
  public static function GetAll()
  {
    $criteria = new CDbCriteria();
    $criteria->order = 't.MaskId ASC';
    return CoreMask::model()->findAll($criteria);
  }

  /**
   * @return array|null
   */
  public function GetData()
  {
    if ($this->Data != null)
    {
      if ($this->dataClear == null)
      {
        $this->dataClear = unserialize($this->Data);
      }
      return $this->dataClear;
    }
    return null;
  }

  /**
   * @param array|null $data
   * @return void
   */
  public function SetData($data)
  {
    if (! empty($data))
    {
      $this->Data = serialize($data);
      $this->dataClear = null;
    }
    else
    {
      $this->Data = null;
    }
  }

  /**
   * @param string $module
   * @param string $section
   * @param string $command
   * @param string $dirSection
   * @return bool
   */
  public function CheckAccess($module, $section, $command, $dirSection = RouteRegistry::SectionDirPublic)
  {
    $rules = $this->GetData();
    $rules = $rules[$dirSection];
    if ($rules == '*')
    {
      return true;
    }
    if (isset($rules[$module]) && $rules[$module] == '*')
    {
      return true;
    }
    elseif (! isset($rules[$module]))
    {
      return false;
    }
    $rules = $rules[$module];
    if (empty($section))
    {
      return in_array($command, $rules['commands']);
    }
    else
    {
      $rules = $rules['sections'];
      if (! isset($rules[$section]))
      {
        return false;
      }
      if ($rules[$section] == '*')
      {
        return true;
      }
      else
      {
        return in_array($command, $rules[$section]);
      }
    }
  }

  public function CheckAccessAdmin($module, $section, $command)
  {
    return $this->CheckAccess($module, $section, $command, RouteRegistry::SectionDirAdmin);
  }
}