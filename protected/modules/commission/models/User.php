<?php
namespace commission\models;
/**
 * @property int $Id
 * @property int $CommissionId
 * @property int $UserId
 * @property int $RoleId
 * @property string $JoinTime
 * @property string $ExitTime
 */
class User extends \CActiveRecord
{
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'CommissionUser';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations() 
  {
    return array(
      'Commission' => array(self::BELONGS_TO, '\commission\models\Commission', 'CommissionId'),  
      'Role' => array(self::BELONGS_TO, '\commission\models\Role', 'RoleId'),
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId')
    );
  }
  
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params['UserId'] = $userId;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
