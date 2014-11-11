<?php
namespace competence\models\test\mailru2014_prof;

class S6 extends \competence\models\form\Single {

  public function getNext()
  {
    $s5 = $this->getQuestionByCode('S5');
    if (!in_array($s5->getResult()['value'], [1, 2, 3]))
    {
      $s1 = $this->getQuestionByCode('S1');
      if ($s1->getResult()['value'] == 1)
      {
        return $this->getQuestionByCode('S3_1');
      }
      else
      {
        return $this->getQuestionByCode('S3');
      }
    }
    return parent::getNext();
  }
}
