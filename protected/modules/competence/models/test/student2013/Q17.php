<?php
namespace competence\models\test\student2013;

class Q17 extends \competence\models\form\Input {

  private $errorMessage = 'Введите в строке число от 0 до 10';

  public function rules()
  {
    return [
      ['value' ,'numerical', 'allowEmpty' => false, 'integerOnly' => true, 'min' => 0, 'max' => 10, 'message' => $this->errorMessage, 'tooBig' => $this->errorMessage, 'tooSmall' => $this->errorMessage,]
    ];
  }



}
