<?php
AutoLoader::Import('library.rocid.activity.userchanges.*');
/**
 * @property int $UserChangesId
 * @property int $UserId
 * @property string $Action
 * @property int $CreationTime
 *
 * @property User $User
 */
class UserChanges extends CActiveRecord
{
  public static $TableName = 'UserChanges';

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
    return 'UserChangesId';
  }

  public function relations()
  {
    return array(
      'User' => array(self::BELONGS_TO, 'User', 'UserId')
    );
  }

  /**
   * @static
   * @param int[] $ids
   * @param int $count
   * @return UserChanges[]
   */
  public static function GetLastChanges($ids, $count)
  {
    $changes = UserChanges::model()->with('User')->together();
    $criteria = new CDbCriteria();
    $criteria->condition = 't.UserId IN (:UsersId)';
    $criteria->params = array(':UsersId' => implode(',', $ids));
    $criteria->limit = $count;
    $criteria->order = 't.CreationTime DESC';
    return $changes->findAll($criteria);
  }

  /**
   * @param UserBaseChange $action
   * @return void
   */
  public function SetAction($action)
  {
    $action = serialize($action);
    $action = base64_encode($action);
    $this->Action = $action;
  }

  /**
   * @return UserBaseChange
   */
  public function GetAction()
  {
    $action = base64_decode($this->Action);
    $action = unserialize($action);
    return $action;
  }
}