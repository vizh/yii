<?php
namespace competence\models\tests\mailru2013;

class S5 extends \competence\models\Question
{

  public $other;

  public $values = [
    1 => 'TOP-менеджер',
    2 => 'Руководитель подразделения/ департамента/ отдела/ проекта',
    3 => 'Специалист, менеджер с высшим образованием',
    4 => 'Владелец собственного малого бизнеса',
    5 => 'Учащийся/ студент/ аспирант',
    98 => 'Другое (укажите, что именно)',
    99 => 'Ничего из перечисленного'
  ];

  public function rules()
  {
    return [
      ['value', 'required', 'message' => 'Выберите один ответ из списка'],
      ['value', 'otherSelectionValidator']
    ];
  }

  public function otherSelectionValidator($attribute, $params)
  {
    if ( $this->value == 98 && strlen(trim($this->other)) == 0)
    {
      $this->addError('Other', 'При выборе варианта "Другое" необходимо вписать свой вариант позиции в компании');
      return false;
    }
    return true;
  }

  public function getQuestionData()
  {
    return ['value' => $this->value, 'other' => $this->other];
  }

  /**
   * @return \competence\models\Question
   */
  public function getNext()
  {
    return new S6($this->test);
  }

  /**
   * @return \competence\models\Question
   */
  public function getPrev()
  {
    return new A10_1($this->test);
  }
}
