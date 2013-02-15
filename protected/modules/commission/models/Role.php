<?php
namespace commission\models;
/**
 * @property int $Id
 * @property string $Title
 * @property int $Priority
 */
class Role extends \CActiveRecord
{
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'CommissionRole';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
}
