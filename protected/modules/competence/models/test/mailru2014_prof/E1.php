<?php
namespace competence\models\test\mailru2014_prof;

class E1 extends \competence\models\form\Multiple {

  public function getNext()
  {
    if (in_array(99, $this->value))
    {
      $a1 = $this->getQuestionByCode('A1');
      $a1Result = $a1->getResult();
      if (empty($a1Result))
      {
        return $this->getQuestionByCode('A1');
      }
      else
      {
        $a2 = $this->getQuestionByCode('A2');
        $a2Result = $a2->getResult();
        if (empty($a2Result))
        {
          return $this->getQuestionByCode('A2');
        }
      }
      return $this->getQuestionByCode('A4');
    }
    return parent::getNext();
  }
}
