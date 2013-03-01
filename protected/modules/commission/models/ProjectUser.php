<?php
namespace commission\models;
/**
 * @property int $Id
 * @property int $ProjectId
 * @property int $UserId
 */
class ProjectUser extends \CActiveRecord
{
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
}
