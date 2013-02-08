<?php
namespace job\models;

/**
 * @property int $Id
 * @property string $Title
 */
class CategoryLinkPosition extends \CActiveRecord
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
		return 'JobCategoryLinkPosition';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations()
  {
    return array(
      'Position'  => array(self::BELONGS_TO, '\job\models\Position', 'PositionId'),
    );
  }
}
