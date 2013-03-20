<?php
namespace job\models;

/**
 * @property int $Id
 * @property string $Title
 * @property string $Text
 * @property string $Url
 * @property int $SalaryFrom
 * @property int $SalaryTo
 * @property int $CompanyId
 * @property int $CategoryId
 * @property int $PositionId
 * @property string $CreationTime
 * @property bool $Visible
 *
 * @property Company $Company
 * @property Category $Category
 * @property Position $Position
 */
class Job extends \CActiveRecord
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
		return 'Job';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations()
  {
    return array(
      'Company'  => array(self::BELONGS_TO, '\job\models\Company', 'CompanyId'),
      'Category' => array(self::BELONGS_TO, '\job\models\Category', 'CategoryId'),
      'Position' => array(self::BELONGS_TO, '\job\models\Position', 'PositionId'),
    );
  }
  
  public function byVisible($visible = true, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = ($visible ? '' : 'NOT ') . '"t"."Visible"';
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }

}