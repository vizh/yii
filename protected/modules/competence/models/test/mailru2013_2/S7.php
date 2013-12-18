<?php
namespace competence\models\test\mailru2013_2;

class S7 extends \competence\models\form\Single {

  protected function getBaseQuestionCode()
  {
    return 'S1';
  }

  public function getNext()
  {
    $model = \competence\models\Question::model()->byTestId($this->question->TestId);
    $result = $this->getBaseQuestion()->getResult();
    if ($result['value'] == 1)
    {
      $model->byCode('S3_1');
    }
    else
    {
      $model->byCode('S3');
    }
    return $model->find();
  }

}
