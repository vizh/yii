<?php
namespace commission\models;
/**
 * @property int $Id
 * @property string $Title
 * @property string $Description
 * @property string $Url
 * @property string $CreationTime
 * @property bool $Deleted
 */
class Commission extends \CActiveRecord
{
  public static function model($className=__CLASS__)
	{    
		return parent::model($className);
	}
	
	public function tableName()
	{
		return 'Commission';
	}
	
	public function primaryKey()
	{
		return 'Id';
	}
  
  public function __toString() 
  {
    if (!empty($this->Url))
    {
      return '<a href="'.$this->Url.'" title="'.$this->Title.'" target="_blank">'.$this->Title.'</a>';
    }
    return $this->Title;
  }
}
