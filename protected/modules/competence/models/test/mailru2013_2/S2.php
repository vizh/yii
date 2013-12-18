<?php
namespace competence\models\test\mailru2013_2;

class S2 extends \competence\models\form\Input {

  public function rules()
  {
    return [
      ['value', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'message' => 'Введите целое число.']
    ];
  }
}
