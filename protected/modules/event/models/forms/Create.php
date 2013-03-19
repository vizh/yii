<?php
namespace event\models\forms;
class Create extends \CFormModel
{
  public $ContactName;
  public $ContactPhone;
  public $ContactEmail;
  
  public $Title;
  public $Place;
  public $StartDate;
  public $EndDate;
  public $Url;
  public $Info;
  public $FullInfo;
  
  public $Options = array();
  
  public function attributeLabels()
  {
    
  }
}
