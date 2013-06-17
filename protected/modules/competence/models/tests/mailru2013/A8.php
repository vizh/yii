<?php
namespace competence\models\tests\mailru2013;

class A8 extends \competence\models\Question
{
  public $value = [];

  public $other;

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите хотя бы один ответ из списка'],
      ['value', 'otherSelectionValidator']
    ];
  }

  public function otherSelectionValidator($attribute, $params)
  {
    if (in_array(98, $this->value) && strlen(trim($this->other)) == 0)
    {
      $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант компании');
      return false;
    }
    return true;
  }

  protected function getQuestionData()
  {
    return ['value' => $this->value, 'other' => $this->other];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new A9($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    $fullData = $this->getFullData();
    $prev = new A7($this->test);
    if (isset($fullData[get_class($prev)]))
    {
      return $prev;
    }
    return new A6($this->test);
  }

  public function getNumber()
  {
    return 16;
  }
}
