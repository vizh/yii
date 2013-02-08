<?php
namespace job\models;

/**
 * @property int $Id
 * @property string $Position
 * @property string $Text
 * @property int $SalaryFrom
 * @property int $SalaryTo
 * @property int $CompanyId
 * @property int $PositionId
 * @property string $CrateTime 
 * @property bool $Visible
 */
class JobUp extends \CActiveRecord
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
		return 'JobUp';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function relations()
  {
    return array(
      'Job'  => array(self::BELONGS_TO, '\job\models\Job', 'JobId'),
    );
  }
  
  public function byActual($useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."StartTime" >= :Date';
    $criteria->params['Date'] = date('Y-m-d');
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
}