<?php
namespace competence\models\tests\mailru2013;

class A7 extends \competence\models\Question
{

  public $values = [
    1 => '… интересной',
    2 => '… понятной',
    3 => '… полезной',
    9 => 'Ничего из перечисленного'
  ];

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    $fullData = \competence\models\Question::getFullData();
    $base = new A6($this->test);
    $baseData = $fullData[get_class($base)];
    foreach ($baseData['value'] as $key)
    {
      if (empty($this->value[$key]))
      {
        $this->addError('value', 'Необходимо отметить качество полученной информации для каждой из указанных компаний.');
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
    return new A8($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new A6_1($this->test);
  }

  public function getNumber()
  {
    return 15;
  }
}
