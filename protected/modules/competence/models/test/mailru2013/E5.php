<?php
namespace competence\models\tests\mailru2013;

class E5 extends \competence\models\Question
{
  public $options = [
    300 => 'Независимые эксперты',
    301 => 'Официальные представители компаний',
    302 => 'Представители независимых аналитических агентств',
    303 => 'Представители государственных структур',
    304 => 'Блоггеры',
    305 => 'Информационные агентства (журналисты)',
  ];

  public $values = [
    '' => 'Укажите степень доверия',
    5 => 'Полностью доверяю',
    4 => 'Скорее доверяю',
    3 => 'Частично доверяю, частично нет',
    2 => 'Скорее не доверяю',
    1 => 'Абсолютно не доверяю',
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
        $this->addError('value', 'Необходимо оценить степень доверия информации, полученной от всех представленных лиц.');
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
    return new E4($this->test);
  }

  public function getNumber()
  {
    return 8;
  }
}
