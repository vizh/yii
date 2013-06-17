<?php
namespace competence\models\tests\mailru2013;

class E3 extends \competence\models\Question
{
  public $value = [];

  public $other = [];

  public $values = [
    1 => 'Новости рынка',
    2 => 'Новости компаний',
    3 => 'Технические вопросы',
    4 => 'Информация о профильных мероприятиях',
    5 => 'Новинки сферы (новое ПО, разработки)',
    6 => 'Другое (укажите, что именно)',
  ];

  public function rules()
  {
    return [
      ['value', 'checkAllValidator'],
      ['value', 'checkOtherValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    $fullData = $this->getFullData();
    $base1_1 = new E1_1($this->test);
    $baseData1_1 = $fullData[get_class($base1_1)];

    foreach ((new E1($this->test))->getOptions() as $key => $value)
    {
      if (!in_array($key, $baseData1_1['value']))
      {
        continue;
      }
      if (empty($this->value[$key]))
      {
        $this->addError('value', 'Необходимо указать тип получаемой информации для всех выбранных СМИ.');
        return false;
      }
    }
    return true;
  }

  public function checkOtherValidator($attribute, $params)
  {
    foreach ($this->other as $key => $value)
    {
      $this->other[$key] = trim($value);
    }
    foreach ($this->value as $key => $value)
    {
      if (in_array(6, $value) && empty($this->other[$key]))
      {
        $this->addError('value', 'При выборе варианта "Другое", необходимо указать свой тип получаемой информации.');
        return false;
      }
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
    return new E4($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new E2($this->test);
  }

  public function getNumber()
  {
    return 6;
  }
}
