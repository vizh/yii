<?php
namespace pay\models\forms;

class OrderForm extends \CFormModel
{
  public $Count;
  public $Owners;
  public $PromoCodes;

  public function rules()
  {
    return array(
      array('Count, Owners, PromoCodes', 'safe')
    );
  }



  public $Items = array();
}
