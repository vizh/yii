<?php

/**
 * @property int $ComissionUserId
 * @property int $ComissionId
 * @property int $UserId
 * @property int $RoleId
 * @property string $JoinTime
 * @property string $ExitTime
 *
 * @property User $User
 * @property ComissionRole $Role
 */
class ComissionUser extends CActiveRecord
{
  public static $TableName = 'Mod_ComissionUser';

  const RaecComissionId = 0;

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
    return 'ComissionUserId';
  }

  public function relations()
  {
    return array(
//      'Event' => array(self::BELONGS_TO, 'Event', 'EventId'),
//      'Author' => array(self::BELONGS_TO, 'User', 'UserId'),
//      'Companies' => array(self::MANY_MANY, 'Company', 'Mod_NewsLinkCompany(NewsPostId, CompanyId)'),
//      'Categories' => array(self::MANY_MANY, 'NewsCategories', 'Mod_NewsLinkCategory(NewsPostId, CategoryId)'),
//      'MainCategory' => array(self::BELONGS_TO, 'NewsCategories', 'NewsCategoryId')
      'User' => array(self::BELONGS_TO, 'User', 'UserId'),
      'Commission' => array(self::BELONGS_TO, 'Comission', 'ComissionId'),
      'Role' => array(self::BELONGS_TO, 'ComissionRole', 'RoleId')
    );
  }

  /**
   * @static
   * @param int $id
   * @return ComissionUser
   */
  public static function GetById($id)
  {
    return ComissionUser::model()->findByPk($id);
  }

  /**
   * @static
   * @param int $userId
   * @param int $comissionId
   * @return ComissionUser
   */
  public static function GetByUserComissionId($userId, $comissionId)
  {
    $cUser = ComissionUser::model();

    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId = :UserId AND t.ComissionId = :ComissionId';
    $criteria->params = array(':UserId' => $userId, ':ComissionId' => $comissionId);
    return $cUser->find($criteria);
  }

  /**
   * @static
   * @param int $comissionId
   * @param bool $returnCount
   * @return ComissionUser[]|int
   */
  public static function GetByComissionId($comissionId, $returnCount = false)
  {
    $cUser = ComissionUser::model()->with(array('User', 'Role'))->together();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.ComissionId = :ComissionId AND t.ExitTime IS NULL';
    $criteria->params = array(':ComissionId' => $comissionId);
    $criteria->order = 'Role.Priority DESC';
    if ($returnCount)
    {
      return $cUser->count($criteria);
    }
    return $cUser->findAll($criteria);
  }
}
