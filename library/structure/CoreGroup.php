<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nikitin
 * Date: 15.06.11
 * Time: 19:29
 * To change this template use File | Settings | File Templates.
 */

/**
 * @property int $GroupId
 * @property int $ParentId
 * @property string $Title
 * @property string $Type
 *
 * @property CoreMask[] $Masks
 */
class CoreGroup extends CActiveRecord
{
  const TypeSystem = 'system';
  const TypePersonal = 'personal';

  const GuestGroupId = 3;
  const UserGroupId = 2;
  const AdminAccessGroupId = 6;

  public static $TableName = 'Core_Group';

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
    return 'GroupId';
  }

  public function relations()
  {
    return array(
      'Masks' => array(self::MANY_MANY, 'CoreMask', 'Core_Link_GroupMask(GroupId, MaskId)'),
    );
  }

  /**
   * @static
   * @param int $groupId
   * @return CoreGroup
   */
  public static function GetById($groupId)
  {
    return CoreGroup::model()->with('Masks')->findByPk($groupId);
  }

  public function CheckAccess()
  {
    foreach ($this->Masks as $mask)
    {
      $rReg = RouteRegistry::GetInstance();
      if ($mask->CheckAccess($rReg->GetModule(), $rReg->GetSection(), $rReg->GetCommand(), $rReg->SectionsDir))
      {
        return true;
      }
    }

    return false;
  }
}