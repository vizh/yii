<?php
namespace competence\models\tests\mailru2013;

class A2 extends \competence\models\Question
{

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    $fullData = $this->getFullData();
    $base = new A1($this->test);
    $baseData = $fullData[get_class($base)];
    foreach ($baseData['value'] as $key => $value)
    {
      if ((empty($this->value[$key]['Company']) && empty($this->value[$key]['CompanyEmpty'])) || (empty($this->value[$key]['LastName']) && empty($this->value[$key]['LastNameEmpty'])))
      {
        $this->addError('value', 'Необходимо заполнить все значения фамилии и компании, или отметить вариант "затрудняюсь ответить".');
        return false;
      }
    }
    return true;
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new A4($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $prev = new E2($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    return new E1_1($this->test);
  }

  public function getNumber()
  {
    return 10;
  }
}