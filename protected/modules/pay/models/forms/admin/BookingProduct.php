<?php
namespace pay\models\forms\admin;

class BookingProduct extends \CFormModel
{
  public $Attributes = [];

  public function rules()
  {
    return [
      ['Attributes', 'safe']
    ];
  }


} 