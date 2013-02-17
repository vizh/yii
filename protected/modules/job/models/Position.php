<?php
namespace job\models;

/**
 * @property int $Id
 * @property string $Title
 */
class Position extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Position
   */
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'JobPosition';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
}