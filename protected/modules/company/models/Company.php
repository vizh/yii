<?php
namespace company\models;


/**
 * @throws \Exception
 *
 * @property int $Id
 * @property string $Name
 * @property string $FullName
 * @property string $Info
 * @property string $FullInfo
 * @property string $CreationTime
 * @property string $UpdateTime
 *
 *
 * @property \company\models\LinkEmail[] $LinkEmails
 * @property \company\models\LinkAddress $LinkAddress
 * @property \company\models\LinkPhone[] $LinkPhones
 * @property \company\models\LinkSite $LinkSite

 * @property \user\models\Employment[] $Employments
 * @property \user\models\Employment[] $EmploymentsAll
 */
class Company extends \application\models\translation\ActiveRecord implements \search\components\interfaces\ISearch
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
		return 'Company';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}

  public function relations()
  {
    return array(
      'LinkEmails' => array(self::HAS_MANY, '\company\models\LinkEmail', 'CompanyId'),
      'LinkAddress' => array(self::HAS_ONE, '\company\models\LinkAddress', 'CompanyId'),
      'LinkSite' => array(self::HAS_ONE, '\company\models\LinkSite', 'CompanyId'),
      'LinkPhones' => array(self::HAS_MANY, '\company\models\LinkPhone', 'CompanyId'),  
        
      //Сотрудники
      'Employments' => array(self::HAS_MANY, '\user\models\Employment', 'CompanyId', 'order' => '"User"."LastName" DESC', 'condition' => '"Employments"."EndYear" IS NULL', 'with' => array('User')),
      'EmploymentsAll' => array(self::HAS_MANY, '\user\models\Employment', 'CompanyId', 'with' => array('User')),
    );
  }

  public function byName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."Name" = :Name';
    $criteria->params['Name'] = $name;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function byFullName($name, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."FullName" = :FullName';
    $criteria->params['FullName'] = $name;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public function bySearch($term, $locale = null, $useAnd = true)
  {
    $criteria = new \CDbCriteria();
    $criteria->condition = 'to_tsvector("t"."Name") @@ plainto_tsquery(:Term)';
    $criteria->params['Term'] = $term;
    $this->getDbCriteria()->mergeWith($criteria, $useAnd);
    return $this;
  }
  
  public static function getLogoBaseDir($onServerDisc = false)
	{
    $result = \Yii::app()->params['CompanyLogoDir'];
    if ($onServerDisc)
    {
      $result = $_SERVER['DOCUMENT_ROOT'].$result;
    }
    return $result;
	}
  
  /**
	* Возвращает путь к изображению компании
	* @param bool $onServerDisc
	* @return string
	*/
	public function getLogo($onServerDisc = false)
	{
		$path = $this->Id . '_200.jpg';
		if ($onServerDisc || file_exists(self::getLogoBaseDir(true).$path))
		{
			$path = self::getLogoBaseDir($onServerDisc).$path;
		}
		else
		{
			$path = self::getLogoBaseDir($onServerDisc) . 'no_logo.png';
		}
    return $path;
	}

  /**
   * @param string $fullName
   * @return string
   */
  public function parseFullName($fullName)
  {
    preg_match("/^([\'\"]*(ООО|ОАО|АО|ЗАО|ФГУП|ПКЦ|НОУ|НПФ|РОО|КБ|ИКЦ)?\s*,?\s+)?([\'\"]*)?([А-яЁёA-z0-9 \.\,\&\-\+\%\$\#\№\!\@\~\(\)]+)\3?([\'\"]*)?$/iu", $fullName, $matches);

    $name = (isset($matches[4])) ? $matches[4] : '';
    return $name;
  }

  /**
   * @return string[]
   */
  public function getTranslationFields()
  {
    return array('Name');
  }
}