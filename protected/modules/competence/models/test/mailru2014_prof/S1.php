<?php
namespace competence\models\test\mailru2014_prof;

class S1 extends \competence\models\form\Single {
  public function getNext()
  {
    if ($this->value == 3)
    {
      return null;
    }
    return parent::getNext();
  }

}
