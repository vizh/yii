<?php
namespace register\components\form;
class OrderForm extends \CFormModel 
{
  public $Count;
  public $Owners;
  
  public function rules()
  {
    return array(
      array('Count, Owners', 'safe')
    );
  }
}

