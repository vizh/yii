<?php
namespace competence\models\tests\mailru2013;

class A6_1 extends \competence\models\Question
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
    $base = new A6($this->test);
    $baseData = $fullData[get_class($base)];
    foreach ($baseData['value'] as $key)
    {
      if (empty($this->value[$key]))
      {
        $this->addError('value', 'Необходимо указать источники информации для каждой из указанных компаний.');
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
    return new A7($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new A6($this->test);
  }
}
