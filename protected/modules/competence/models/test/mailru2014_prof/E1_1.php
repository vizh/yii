<?php
namespace competence\models\test\mailru2014_prof;

class E1_1 extends \competence\models\form\Multiple {
  protected function getBaseQuestionCode()
  {
    return 'E1';
  }

  protected $values = null;

  /**
   * @return array|\competence\models\form\attribute\CheckboxValue[]|null
   */
  public function getValues()
  {
    if ($this->values == null)
    {
      /** @var \competence\models\form\Multiple $form */
      $form = $this->getBaseQuestion()->getForm();
      $result = $this->getBaseQuestion()->getResult();
      if ($result !== null)
      {
        $this->values = [];
        foreach ($form->Values as $value)
        {
          if (in_array($value->key, $result['value']))
          {
            if ($value->isOther)
            {
              $value->isOther = false;
              $value->title = 'Другое (<em>добавлен свой вариант</em>: <strong>'.$result['other'].'</strong>)';
            }
            $this->values[] = $value;
          }
          elseif ($value->isUnchecker)
          {
            $this->values[] = $value;
          }
        }
      }
      else
      {
        $this->values = $form->Values;
      }
    }

    return $this->values;
  }

  public function setValues()
  {

  }

  protected function getFormAttributeNames()
  {
    return [];
  }

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
