<?php
namespace commission\models;
/**
 * @property int $Id
 * @property int $CommissionId
 * @property string $Title
 * @property string $Description
 * @property bool $Visible
 *
 * @property ProjectUser[] $Users
 */
class Project extends \CActiveRecord
{
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}

	public function tableName()
	{
		return 'CommissionProject';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations() 
  {
    return array(
      'Users' => array(self::HAS_MANY, '\commission\models\ProjectUser', 'CommissionId'),  
    );
  }
}
