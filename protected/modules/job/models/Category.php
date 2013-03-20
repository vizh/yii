<?php
namespace job\models;

/**
 * @property int $Id
 * @property string $Title
 */
class Category extends \CActiveRecord
{
  /**
   * @param string $className
   * @return Company
   */
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'JobCategory';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations()
  {
    return array();
  }
}