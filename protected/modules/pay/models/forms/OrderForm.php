<?php
namespace pay\models\forms;

class OrderForm extends \CFormModel
{
  public $Items = array();

  public function rules()
  {
    return array(
      array('Items', 'safe')
    );
  }
}
