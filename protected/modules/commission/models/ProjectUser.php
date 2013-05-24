<?php
namespace commission\models;
/**
 * @property int $Id
 * @property int $ProjectId
 * @property int $UserId
 *
 * @property \user\models\User $User
 */
class ProjectUser extends \CActiveRecord
{
  /**
   * @param string $className
   *
   * @return ProjectUser
   */
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}

	public function tableName()
	{
		return 'CommissionProjectUser';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations() 
  {
    return array(
      'User' => array(self::BELONGS_TO, '\user\models\User', 'UserId'),  
    );
  }

  /**
   * @param int $userId
   * @param bool $useAnd
   *
   * @return User
   */
  public function byUserId($userId, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params['UserId'] = $userId;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}
