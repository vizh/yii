<?php
namespace competence\models\test\mailru2014_prof;

class A2 extends \competence\models\form\Base {
  protected function getBaseQuestionCode()
  {
    return 'A1';
  }

  protected $options = null;

  public function getOptions()
  {
    if ($this->options == null)
    {
      /** @var A1 $form */
      $form = $this->getBaseQuestion()->getForm();
      $result = $this->getBaseQuestion()->getResult();
      if ($result !== null)
      {
        $this->options = [];
        foreach ($form->getOptions() as $key => $value)
        {
          if (isset($result['value'][$key]))
          {
            $this->options[$key] = $value;
          }
        }
      }
    }

    return $this->options;
  }

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    foreach ($this->getOptions() as $key => $value)
    {
      if ((empty($this->value[$key]['Company']) && empty($this->value[$key]['CompanyEmpty'])) || (empty($this->value[$key]['LastName']) && empty($this->value[$key]['LastNameEmpty'])))
      {
        $this->addError('value', 'Необходимо заполнить все значения фамилии и компании, или отметить вариант "затрудняюсь ответить".');
        return false;
      }
    }
    return true;
  }

  public function getPrev()
  {
    $e1 = $this->getQuestionByCode('E1');
    if (in_array(99, $e1->getResult()['value']))
    {
      return $e1;
    }
    else
    {
      $e1_1 = $this->getQuestionByCode('E1_1');
      if (in_array(99, $e1_1->getResult()['value']))
      {
        return $e1_1;
      }
    }
    return parent::getPrev();
  }
}
