<?php
namespace competence\models\tests\mailru2013;

class E2 extends \competence\models\Question
{
  public $value = array();

  public $values = [
    '' => 'Укажите регулярность использования',
    1 => 'Несколько раз в день',
    2 => 'Почти каждый день',
    3 => '2-3 раза в неделю',
    4 => 'Раз в неделю',
    5 => 'Два раза в месяц',
    6 => 'Раз в месяц и реже',
  ];

  public function rules()
  {
    return [
      ['value', 'checkAllValidator']
    ];
  }

  public function checkAllValidator($attribute, $params)
  {
    foreach ($this->value as $value)
    {
      if (empty($value))
      {
        $this->addError('value', 'Необходимо оценить частоту использования всех выбранных СМИ.');
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
    $fullData = $this->getFullData();
    $next = new A1($this->test);
    if (!isset($fullData[get_class($next)]))
    {
      return $next;
    }
    $next = new A2($this->test);
    if (!isset($fullData[get_class($next)]))
    {
      return $next;
    }
    return new A4($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new E1_1($this->test);
  }

  public function getNumber()
  {
    return 5;
  }
}
