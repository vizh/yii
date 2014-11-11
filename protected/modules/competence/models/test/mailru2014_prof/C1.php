<?php
namespace competence\models\test\mailru2014_prof;

class C1 extends \competence\models\form\Input {

  protected function getBaseQuestionCode()
  {
    return 'S1';
  }

  public function rules()
  {
    return [
      ['value', 'numerical', 'integerOnly' => true, 'allowEmpty' => false, 'message' => 'Введите целое число.']
    ];
  }

  public function getPrev()
  {
    $result = $this->getBaseQuestion()->getResult();
    if ($result['value'] == 1)
    {
      return $this->getQuestionByCode('S3_1');
    }
    else
    {
      return $this->getQuestionByCode('S3');
    }
  }
}