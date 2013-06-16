<?php
namespace competence\models\tests\mailru2013;

class E4 extends \competence\models\Question
{

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
        $this->addError('value', 'Необходимо оценить степень доверия всем выбранным СМИ.');
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
    return new E5($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new E3($this->test);
  }
}
