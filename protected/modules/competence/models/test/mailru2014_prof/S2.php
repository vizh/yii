<?php
namespace competence\models\test\mailru2014_prof;

class S2 extends \competence\models\form\Input {

  public function rules()
  {
    return [
      ['value', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'message' => 'Введите целое число.']
    ];
  }
}
